<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Task extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('security');
        $this->load->helper('sconfig_helper');
        $this->load->helper('client_helper');
        $this->load->helper('task_helper');
        $this->load->helper('lead_helper');
        $this->load->model('Email_Model');
        $this->load->model('Task_Model');
        $this->load->model('SMS_Model');
        $this->load->model('Agent_Model');
        $this->load->library("Auth");
        $this->load->library("Firebase");
        
        $this->Auth = new Auth();
        
        $this->Firebase = new Firebase();
        
        date_default_timezone_set("Asia/Kolkata");
    }
    
    public function index()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        $hdata['title'] = "ToDo List";
        $hdata['page_type'] = "task";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "ToDo List";
        $hdata['profile'] = $this->Agent_Model->get_profile();
        
        $data['task'] = $this->Task_Model->get_all();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/task", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function add()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        $hdata['title'] = "New ToDo";
        $hdata['page_type'] = "new-task";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."task'>ToDo List</a> / New ToDo";
        $hdata['profile'] = $this->Agent_Model->get_profile();
        
        if(isset($_GET['task']) && !empty($_GET['task']))
        {
            $data['task'] = $this->Task_Model->get_single_task($_GET['task']);
            $data['tcomments'] = $this->Task_Model->get_all_comments($_GET['task']);
        }else{
            $data['task'] = "";
        }
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/new_task", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function process_data($action="add")
    {
        if(!empty($action) && $action=='add')
        {
            $is = false;
            $data = array(
              "task_name" => isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : '-',
              "task_status" => isset($_POST['status'])&&!empty($_POST['status']) ? htmlspecialchars($_POST['status']) : get_task_status_id('task not started'),
              "task_priority" => isset($_POST['priority']) ? htmlspecialchars($_POST['priority']) : 0,
              "task_date" => isset($_POST['date']) && !empty($_POST['date']) ? htmlspecialchars(date("Y-m-d H:i", strtotime($_POST['date']))) : date("Y-m-d H:i", strtotime("+10minute")),
              "agent_id" => isset($_POST['agent']) ? htmlspecialchars($_POST['agent']) : decrypt_me($_SESSION['login_id']),
              "description" => isset($_POST['desc']) ? htmlspecialchars($_POST['desc']) : '-',
              "access_to_id" => isset($_POST['access_to_id']) ? implode(",", $_POST['access_to_id']) : null,
              "updated" => date("Y-m-d H:i:s")
            );
            
            if(isset($_POST['task_id']) && empty($_POST['task_id']))
            {
                $data['created'] = date("Y-m-d H:i:s");
            }
            
            if(isset($_POST['task_id']) && empty($_POST['task_id']))
            {
                $is = $this->Task_Model->add_new($data);
                if($is){
                    $this->session->set_flashdata("success","Task Added Successfully.");
                }else{
                    $this->session->set_flashdata("error","Something went wrong!");
                }
                if(isset($_GET['ref']) && $_GET['ref']=='d'){
                    redirect(base_url());
                }else{
                    redirect("task");
                }
            }else{
                $data['notified'] = 0;
                $is = $this->Task_Model->update_task($_POST['task_id'], $data);
                if($is){
                    $this->session->set_flashdata("success","Record has been updated");
                }else{
                    $this->session->set_flashdata("error","Something went wrong!");
                }
                redirect("task");
            }
        }else{
            redirect($_SERVER['HTTP_REFERER']);
        }
    
    }
    
    public function remove()
    {
        if(isset($_GET['me']) && !empty($_GET['me']))
        {
            $is = $this->Task_Model->remove($_GET['me']);
            if($is)
            {
                $this->session->set_flashdata("success","Record has been updated.");
            }else{
                $this->session->set_flashdata("error","Unable to delete it.");
            }
        }else{
            $this->session->set_flashdata("error","Something went wrong.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function deleteSelected()
    {
        $res = array("status"=>0,"data"=>"failed");
        if(isset($_POST['ids']) && !empty($_POST['ids']))
        {
            foreach($_POST['ids'] as $t)
            {
                $is = $this->Task_Model->remove($t);
            }
            if($is)
            {
                $res['status'] = 1;
                $res['data'] = "success";
                $this->session->set_flashdata("success","Record has been updated.");
            }else{
                $this->session->set_flashdata("error","Unable to delete it.");
            } 
        }
        print_r(json_encode($res));
    }
    
    public function markComplete()
    {
        $res = array("status"=>0, "data"=>"failed");
        if(isset($_POST['id']) && !empty($_POST['id']))
        {
            $is = $this->Task_Model->mark_complete($_POST['id']);
            if($is){
                $res['status'] = 1;
                $res['data'] = "success";
            }
            
            $task = $this->Task_Model->get_single_task($_POST['id']);
            
            if($task) {
                //send notification
                $agent_token = get_agent_device_token($task->agent_id);
                
                foreach([intval($task->agent_id) == 0 ? get_config_item("device_token") : $agent_token] as $token) {
                    if(!empty($token)){
                        $this->Firebase->sendNotification($token, [
                            'title' => $task->task_name,
                            'body'  => $task->description,
                        ]);
                    }
                }
            }
        }
        print_r(json_encode($res));
    }
    
    public function bulk_action()
    {
        $res = array("status"=>0, "data"=>"failed");
        $tasks = isset($_POST['tasks']) ? $_POST['tasks'] : '';
        $agent = isset($_POST['agent']) ? $_POST['agent'] : '';
        $s = isset($_POST['status']) ? $_POST['status'] : get_task_status_id('task not started');
        
        if(isset($_POST['status']) && !empty($_POST['status']))
        {
            if(!empty($tasks))
            {
                $is = $this->Task_Model->change_status($tasks, $s);
                if($is)
                {
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
        }
        if(isset($_POST['agent']) && !empty($_POST['agent']))
        {
            if(!empty($tasks))
            {
                $is = $this->Task_Model->transfer_to_agent($tasks, base64_decode($agent));
                if($is)
                {
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
        }
        
        print_r(json_encode($res));
    }
    
    public function addComment()
    {
        if(isset($_POST))
        {
           $cdata = array(
              "commented_by" => decrypt_me($_SESSION['login_id']),
              "status" => isset($_POST['tstatus']) && !empty($_POST['tstatus'])? $_POST['tstatus'] :get_task_status_id('task not started') ,
              "task_id" => isset($_POST['task_id']) ? base64_decode($_POST['task_id']) : '',
              "dateandtime" => isset($_POST['date']) ? date("Y-m-d H:i:s",strtotime($_POST['date'])) : date("Y-m-d H:i:s"),
              "comments" => isset($_POST['tcomment']) ? $_POST['tcomment'] : '-',
              "created" => date("Y-m-d H:i:s"),
              "updated" => date("Y-m-d H:i:s")
            );
            
            $data = array(
              "task_status" => isset($_POST['tstatus'])&&!empty($_POST['tstatus']) ? htmlspecialchars($_POST['tstatus']) : get_task_status_id('task not started'),
              "task_date" => isset($_POST['date']) && !empty($_POST['date']) ? htmlspecialchars(date("Y-m-d H:i", strtotime($_POST['date']))) : date("Y-m-d H:i", strtotime("+10minute")),
              "description" => isset($_POST['tcomment']) ? $_POST['tcomment'] :'',
              "notified" => 0
            );
            
            $is= $this->Task_Model->update_task($_POST['task_id'], $data, "no");
            $is = $this->Task_Model->add_task_comment($cdata);
            
            if($is){
                $this->session->set_flashdata("success","Record has been updated.");
            }else{
                $this->session->set_flashdata("error","Something went wrong.");
            }
        }else{
            $this->session->set_flashdata("error","Something went wrong.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function get_task_notification()
    {
        $res = array("status"=>"failed", "n"=>"");
        if(isset($_POST['push']))
        {
            $t_notification = $this->Task_Model->get_task_notification(date("Y-m-d"));
            if(!empty($t_notification))
            {
                $res['status'] = "success";
                foreach($t_notification as $t)
                {
                    $t->id = $t->task_id;
                    $t->task_id = base_url('task/add?task=').base64_encode($t->task_id);
                    $t->task_status = get_module_value($t->task_status,'task_status');
                    
                }
                $res['n'] = $t_notification;
            }
        }
        print_r(json_encode($res));
    }
    
    public function mark_notified()
    {
        $res = array("status"=>"success", "n"=>"");
        if(isset($_POST['task_id']))
        {
            $this->db->where("task_id", $_POST['task_id'])->update("crm_task", ['desktop_notified' => 1]);
        }
        print_r(json_encode($res));
    }
}
?>