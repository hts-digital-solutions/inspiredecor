<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Agent extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('security');
        $this->load->helper('sconfig_helper');
        $this->load->helper('client_helper');
        $this->load->model('Agent_Model');
        $this->load->model('SMS_Model');
        $this->load->model('Email_Model');
        $this->load->library("Auth");
        $this->Auth = new Auth();
        $this->Auth->_check_auth();
        date_default_timezone_set("Asia/Kolkata");
    }
    
    public function add_new()
    {
        $res = array("status"=>0, "data"=>"success");
        if(isset($_POST) && !empty($_POST))
        {
            $data = array(
              'agent_name' => isset($_POST['aname']) ? sanitize($_POST['aname']) : '',
              'agent_email' => isset($_POST['aemail']) ? sanitize($_POST['aemail']) : '',
              'agent_mobile' => isset($_POST['amobile']) ? sanitize($_POST['amobile']) : '',
              'agent_roll' => isset($_POST['aroll']) ? sanitize($_POST['aroll']) : '',
              'agent_status' => isset($_POST['astatus']) ? sanitize($_POST['astatus']) : 0,
              'client_access' => (isset($_POST['afeature']) && $_POST['afeature'] != '' && $_POST['afeature'] == 'yes') ? 'yes' : '',
              'updated' => date("Y-m-d H:i:s")
            );
            
            if(isset($_POST['apassword']) && !empty($_POST['apassword'])){
                $data['agent_password'] = md5($_POST['apassword']);
            }
            
            if(isset($_POST['agent_raw_password']) && !empty($_POST['agent_raw_password'])){
                $data['agent_raw_password'] = encrypt_me($_POST['agent_raw_password']);
            }
            
            if(isset($_POST['aid']) && !empty($_POST['aid']))
            {
              $data['created'] = date("Y-m-d H:i:s");
            }
            
            if(count($data)!=0)
            {
                if(isset($_POST['aid']) && !empty($_POST['aid']))
                {
                    $is = $this->Agent_Model->update_new($_POST['aid'], $data);
                }else{
                    $is = $this->Agent_Model->add_new($data);
                }
                if($is)
                {
                    $this->session->set_flashdata("success","Record has been updated.");
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
        }
        
        print_r(json_encode($res));
    }
    
    
    public function allowCfeature()
    {
        $res = array("status"=>0, "data"=>"success");
        if(isset($_POST['id']) && !empty($_POST['id']))
        {
            if(isset($_POST['allow']))
            {
                $is = $this->Agent_Model->access_control($_POST['id'], $_POST['allow']);
                if($is)
                {
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
        }
        
        print_r(json_encode($res));
    }
    
    public function get_details()
    {
        $res = array("status"=>0,"data"=>"failed");
        if(isset($_POST['id']) && !empty($_POST['id']))
        {
            $data = $this->Agent_Model->get_agent($_POST['id']);
            if(!empty($data))
            {
                $res['status'] = 1;
                $res['data'] = "success";
                $res['a'] = $data;
            }
        }
        
        print_r(json_encode($res));
    }
    
    public function del_agent()
    {
        $this->Auth->_check_Aauth();
        if(isset($_GET['d']) && !empty($_GET['d']) && isset($_GET['to']) && !empty($_GET['to']))
        {
            $status = $this->Agent_Model->transfer_all_lead($_GET['d'], $_GET['to']);
            if($status){
                $is = $this->Agent_Model->delete_agent($_GET['d']);
                $this->session->set_flashdata("success","Record has been updated.");
            }else{
                $this->session->set_flashdata("error","Something went wrong! Try Again.");
            }
        }
        
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function updateProfile()
    {
        if(isset($_POST['profile'])){
            $data = array(
              "agent_name" => isset($_POST['name']) ? sanitize($_POST['name']) : '',
              "agent_email" => isset($_POST['email']) ? sanitize($_POST['email']) : '',  
              "agent_mobile" => isset($_POST['mobile']) ? sanitize($_POST['mobile']) : '',
              "updated" => date("Y-m-d H:i:s")
            );
            
            $update = $this->Agent_Model->update_new($_POST['id'], $data);
            if($update){
                $this->session->set_flashdata("success","Profile updated successfully.");
            }else{
               $this->session->set_flashdata("error","Unable to update profile!"); 
            }
        }else{
            $this->session->set_flashdata("error","Something went wrong!");
        }
        header("Location:".$_SERVER['HTTP_REFERER']);
    }
    
    public function updatePassword()
    {
        if(isset($_POST['password'])){
            $yes = false;
            if($_POST['newpass'] !== $_POST['confirmpass']){
               $yes = false;
               $this->session->set_flashdata("error","New password and Confirm password is not same.");
               redirect($_SERVER['HTTP_REFERER']);
            }
            
            if(isset($_POST['oldpass']) && !empty($_POST['oldpass'])){
               $is = $this->Agent_Model->match_password($_POST['id'], htmlspecialchars($_POST['oldpass']));
               if($is==false){
                 $yes = false;
                 $this->session->set_flashdata("error","Old password does not match.");
                 redirect($_SERVER['HTTP_REFERER']);  
               }else{
                   $yes = true;
               }
            }else{
               $yes = false;
               $this->session->set_flashdata("error","Please enter the old password.");
               redirect($_SERVER['HTTP_REFERER']);
            }
            
            $data = array(
              "agent_password" => isset($_POST['newpass']) ? md5(htmlspecialchars($_POST['newpass'])) : '',
              "agent_raw_password" => isset($_POST['newpass']) ? encrypt_me(htmlspecialchars($_POST['newpass'])) : '', 
              "updated" => date("Y-m-d H:i:s")
            );
            if($yes){
                $update = $this->Agent_Model->update_new($_POST['id'], $data);
            }else{
                $update = false;
            }
            if($update){
                $_SESSION['pc'] = "yes";
                $this->session->set_flashdata("success","Password updated successfully.");
            }else{
               $this->session->set_flashdata("error","Unable to update password!"); 
            }
        }else{
            $this->session->set_flashdata("error","Something went wrong!");
        }
        header("Location:".$_SERVER['HTTP_REFERER']);
    }
    
    public function uploadProfileImg()
    {
        if(isset($_POST['profileimg']) && !empty($_POST['profileimg'])){
            $data = $_POST['profileimg'];
            $image_arr1 = explode(";",$data);
            $image_arr2 = explode(",",$image_arr1[1]);
            $data = base64_decode($image_arr2[1]);
            $name = "profile_".time().'.png';
            if(!is_dir(FCPATH.'resource/system_uploads/agent/')){
                mkdir(FCPATH.'resource/system_uploads/agent/');
            }
            $upload = FCPATH.'resource/system_uploads/agent/'.$name;
            $s = file_put_contents($upload, $data);
            
            if($s){
                $agent = base64_encode(decrypt_me($_SESSION['login_id']));
                $oldimg = $this->Agent_Model->get_profile_img($agent);
                if(file_exists(FCPATH.'resource/system_uploads/agent/'.$oldimg) && !is_dir(FCPATH.'resource/system_uploads/agent/'.$oldimg)){
                    unlink(FCPATH.'resource/system_uploads/agent/'.$oldimg);
                }
                $this->Agent_Model->update_new($agent, array("profile_image"=>$name,"updated"=>date("Y-m-d H:i:s")));
                echo "done";
            }else{
                echo "error2";
            }
            
        }else{
            echo "error";
        }
    }
}
?>