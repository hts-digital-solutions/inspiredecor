<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Option extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('sconfig_helper');
        $this->load->model('Option_Model');
        $this->load->library("Auth");
        $this->Auth = new Auth();
        $this->Auth->_check_auth();
        date_default_timezone_set("Asia/Kolkata");
    }
    
    
    public function add_lead_source()
    {
        $res = array('status'=>0, 'data'=>'failed');
        
        if(isset($_POST['lead_source']) && !empty($_POST['lead_source']))
        {
            $data = array(
                'lead_source_name'  => isset($_POST['lead_source']) ? htmlspecialchars($_POST['lead_source']) : '',
                'lead_source_status'=> 1,
                'updated'   => date("Y-m-d H:i:s")
            );
            $s = false;
            if(isset($_POST['lsid']) && !empty($_POST['lsid']))
            {
                $s = $this->Option_Model->update_lead_source($_POST['lsid'],$data);
                $res['u'] = 'yes';
            }else{
                $data['created'] = date("Y-m-d H:i:s");
                $s = $this->Option_Model->add_lead_source($data);
            }
            
            if($s)
            {
                $res['df'] = base64_encode($s->lead_source_id);
                $res['data'] = 'success';
                $res['ls'] = $data['lead_source_name'];
                $res['in'] = $s->lead_source_index;
                $res['status'] = 1;
            }else{
                $res['data'] = 'notsaved';
            }
        }
        print_r(json_encode($res));
    }
    
    public function delete_lead_source()
    {
        $res = array('status'=>0, 'data'=>'failed');
        if(isset($_POST['lsid']) && !empty($_POST['lsid']))
        {
            $id = $this->Option_Model->delete_lead_source(htmlspecialchars($_POST['lsid']));
            if($id)
            {
                $res['data'] = 'success';
                $res['status'] = 1;
            }else{
                $res['data'] = 'delerror';
            }
        }
        print_r(json_encode($res));
    }
    
    public function add_service()
    {
        $res = array('status'=>0, 'data'=>'failed');
        
        if(isset($_POST['service_name']) && !empty($_POST['service_name']))
        {
            $data = array(
                'service_name'  => isset($_POST['service_name']) ? htmlspecialchars($_POST['service_name']) : '',
                'service_status'=> 1,
                'updated'   => date("Y-m-d H:i:s")
            );
            $s = false;
            if(isset($_POST['sid']) && !empty($_POST['sid']))
            {
                $s = $this->Option_Model->update_service($_POST['sid'],$data);
                $res['u'] = 'yes';
            }else{
                $data['created'] = date("Y-m-d H:i:s");
                $s = $this->Option_Model->add_service($data);
            }
            
            if($s)
            {
                $res['df'] = base64_encode($s->service_id);
                $res['data'] = 'success';
                $res['ls'] = $data['service_name'];
                $res['in'] = $s->service_index;
                $res['status'] = 1;
            }else{
                $res['data'] = 'notsaved';
            }
        }
        print_r(json_encode($res));
    }
    
    public function delete_service()
    {
        $res = array('status'=>0, 'data'=>'failed');
        if(isset($_POST['sid']) && !empty($_POST['sid']))
        {
            $id = $this->Option_Model->delete_service(htmlspecialchars($_POST['sid']));
            if($id)
            {
                $res['data'] = 'success';
                $res['status'] = 1;
            }else{
                $res['data'] = 'delerror';
            }
        }
        print_r(json_encode($res));
    }
    
    
    public function add_status()
    {
        $res = array('status'=>0, 'data'=>'failed');
        
        if(isset($_POST['status_name']) && !empty($_POST['status_name']))
        {
            $data = array(
                'status_name'  => isset($_POST['status_name']) ? htmlspecialchars($_POST['status_name']) : '',
                'status_status'=> 1,
                'updated'   => date("Y-m-d H:i:s")
            );
            $s = false;
            if(isset($_POST['stid']) && !empty($_POST['stid']))
            {
                $s = $this->Option_Model->update_status($_POST['stid'],$data);
                $res['u'] = 'yes';
            }else{
                $data['created'] = date("Y-m-d H:i:s");
                $s = $this->Option_Model->add_status($data);
            }
            
            if($s)
            {
                $res['df'] = base64_encode($s->status_id);
                $res['data'] = 'success';
                $res['ls'] = $data['status_name'];
                $res['in'] = $s->status_index;
                $res['status'] = 1;
            }else{
                $res['data'] = 'notsaved';
            }
        }
        print_r(json_encode($res));
    }
    
    public function delete_status()
    {
        $res = array('status'=>0, 'data'=>'failed');
        if(isset($_POST['stid']) && !empty($_POST['stid']))
        {
            $id = $this->Option_Model->delete_status(htmlspecialchars($_POST['stid']));
            if($id)
            {
                $res['data'] = 'success';
                $res['status'] = 1;
            }else{
                $res['data'] = 'delerror';
            }
        }
        print_r(json_encode($res));
    }
    
    
    public function add_lost_reason()
    {
        $res = array('status'=>0, 'data'=>'failed');
        
        if(isset($_POST['lost_reason_name']) && !empty($_POST['lost_reason_name']))
        {
            $data = array(
                'lost_reason_name'  => isset($_POST['lost_reason_name']) ? htmlspecialchars($_POST['lost_reason_name']) : '',
                'lost_reason_status'=> 1,
                'updated'   => date("Y-m-d H:i:s")
            );
            $s = false;
            if(isset($_POST['lrid']) && !empty($_POST['lrid']))
            {
                $s = $this->Option_Model->update_lost_reason($_POST['lrid'],$data);
                $res['u'] = 'yes';
            }else{
                $data['created'] = date("Y-m-d H:i:s");
                $s = $this->Option_Model->add_lost_reason($data);
            }
            
            if($s)
            {
                $res['df'] = base64_encode($s->lost_reason_id);
                $res['data'] = 'success';
                $res['ls'] = $data['lost_reason_name'];
                $res['in'] = $s->lost_reason_index;
                $res['status'] = 1;
            }else{
                $res['data'] = 'notsaved';
            }
        }
        print_r(json_encode($res));
    }
    
    public function delete_lost_reason()
    {
        $res = array('status'=>0, 'data'=>'failed');
        if(isset($_POST['lrid']) && !empty($_POST['lrid']))
        {
            $id = $this->Option_Model->delete_lost_reason(htmlspecialchars($_POST['lrid']));
            if($id)
            {
                $res['data'] = 'success';
                $res['status'] = 1;
            }else{
                $res['data'] = 'delerror';
            }
        }
        print_r(json_encode($res));
    }
    
    public function add_expense_category()
    {
        $res = array('status'=>0, 'data'=>'failed');
        
        if(isset($_POST['expense_category_name']) && !empty($_POST['expense_category_name']))
        {
            $name = htmlspecialchars(trim($_POST['expense_category_name'])) ?? '';
            
            $data = array(
                'name'  => isset($_POST['expense_category_name']) ? $name  : ''
            );
            $s = false;
            if(isset($_POST['ecid']) && !empty($_POST['ecid']))
            {
                $q = $this->db->where("id", base64_decode($_POST['ecid']))->get("crm_expense_category");
                if($q->num_rows() > 0){
                    $old = $q->row();
                    
                    $s = $this->Option_Model->update_expense_category($_POST['ecid'],$data);
                    if($old && $s){
                        //update all category in expense
                        $this->db->where("category", trim(strtolower($old->name)))->update("crm_project_expenses", [
                            'category'  => $name
                        ]);
                    }
                }
                
                $res['u'] = 'yes';
            }else{
                $s = $this->Option_Model->add_expense_category($data);
            }
            
            if($s)
            {
                $res['df'] = base64_encode($s->id);
                $res['data'] = 'success';
                $res['ls'] = $data['name'];
                $res['status'] = 1;
            }else{
                $res['data'] = 'notsaved';
            }
        }
        print_r(json_encode($res));
    }
    
    public function delete_expense_category()
    {
        $res = array('status'=>0, 'data'=>'failed');
        if(isset($_POST['ecid']) && !empty($_POST['ecid']))
        {
            $id = $this->Option_Model->delete_expense_category(htmlspecialchars($_POST['ecid']));
            if($id)
            {
                $res['data'] = 'success';
                $res['status'] = 1;
            }else{
                $res['data'] = 'delerror';
            }
        }
        print_r(json_encode($res));
    }
    
    public function add_task_status()
    {
        $res = array('status'=>0, 'data'=>'failed');
        
        if(isset($_POST['task_status_name']) && !empty($_POST['task_status_name']))
        {
            $data = array(
                'task_status_name'  => isset($_POST['task_status_name']) ? htmlspecialchars($_POST['task_status_name']) : '',
                'task_status_status'=> 1,
                'updated'   => date("Y-m-d H:i:s")
            );
            $s = false;
            if(isset($_POST['tsid']) && !empty($_POST['tsid']))
            {
                $s = $this->Option_Model->update_task_status($_POST['tsid'],$data);
                $res['u'] = 'yes';
            }else{
                $data['created'] = date("Y-m-d H:i:s");
                $s = $this->Option_Model->add_task_status($data);
            }
            
            if($s)
            {
                $res['df'] = base64_encode($s->task_status_id);
                $res['data'] = 'success';
                $res['ls'] = $data['task_status_name'];
                $res['in'] = $s->task_status_index;
                $res['status'] = 1;
            }else{
                $res['data'] = 'notsaved';
            }
        }
        print_r(json_encode($res));
    }
    
    public function delete_task_status()
    {
        $res = array('status'=>0, 'data'=>'failed');
        if(isset($_POST['tsid']) && !empty($_POST['tsid']))
        {
            $id = $this->Option_Model->delete_task_status(htmlspecialchars($_POST['tsid']));
            if($id)
            {
                $res['data'] = 'success';
                $res['status'] = 1;
            }else{
                $res['data'] = 'delerror';
            }
        }
        print_r(json_encode($res));
    }
    
    public function sort_option()
    {
        if(!empty($_POST))
        {
            $is = $this->Option_Model->sort_option($_POST['name'],$_POST['id'], $_POST['index']);
            if($is){
                echo "ok";
            }else{
                echo "errorm";
            }
        }else{
            echo "error";
        }
    }
    
    public function sort_feild()
    {
        if(!empty($_POST))
        {
            $is = $this->Option_Model->sort_feild($_POST['section'],$_POST['id'], $_POST['index']);
            if($is){
                echo "ok";
            }else{
                echo "errorm";
            }
        }else{
            echo "error";
        }
    }
}
?>