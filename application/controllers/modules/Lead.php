<?php
ob_start();
defined("BASEPATH") OR exit("No direct script access allowed!");

class Lead extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('lead_helper');
        $this->load->helper('client_helper');
        $this->load->helper('security');
        $this->load->helper('sconfig_helper');
        $this->load->model('Lead_Model');
        $this->load->model('Client_Model');
        $this->load->model('SMS_Model');
        $this->load->library("Auth");
        $this->Auth = new Auth();
        $this->Auth->_check_auth();
        date_default_timezone_set("Asia/Kolkata");
    }
    
    public function add_new_lead()
    {
       
        $leadid = null;
        if(!empty($_POST)){
            $_SESSION['al_data'] = $_POST;
            $_SESSION['al_ferror'] = array();
            $lead_data = array();
            $lead_fields = get_fields();
            foreach($lead_fields as $lf)
            {
                if($lf->feild_type == 'email'){
                    if(isset($_POST[$lf->feild_value_name])
                    && filter_var($_POST[$lf->feild_value_name], FILTER_VALIDATE_EMAIL))
                    {
                       $lead_data[$lf->feild_value_name] = sanitize($_POST[$lf->feild_value_name]);
                    }else if(!empty($_POST[$lf->feild_value_name])){
                        $_SESSION['al_ferror'][$lf->feild_value_name] = "Please enter a valid Email.";
                    }else{
                        unset($_SESSION['al_ferror'][$lf->feild_value_name]);
                    }
                }else{
                    if(isset($_POST[$lf->feild_value_name]) && is_array($_POST[$lf->feild_value_name])){
                        $lead_data[$lf->feild_value_name] = sanitize(implode(",",$_POST[$lf->feild_value_name]));
                    }else if(isset($_POST[$lf->feild_value_name])){
                        if($lf->is_required){
                            if(empty(sanitize($_POST[$lf->feild_value_name]))){
                                $_SESSION['al_ferror'][$lf->feild_value_name] = "Please enter ".str_replace("_"," ",$lf->feild_value_name);
                                
                            }else if($lf->feild_value_name=='contact_no' && !preg_match('/^[0-9]{10}+$/', $_POST[$lf->feild_value_name])){
                                $_SESSION['al_ferror'][$lf->feild_value_name] = "Please enter a valid ".str_replace("_"," ",$lf->feild_value_name);
                                
                            }else if($lf->feild_value_name=='alternative_no' && !preg_match('/^[0-9]{10}+$/', $_POST[$lf->feild_value_name]))
                            {
                                $_SESSION['al_ferror'][$lf->feild_value_name] = "Please enter a valid ".str_replace("_"," ",$lf->feild_value_name);
                                
                            }else{
                                unset($_SESSION['al_ferror'][$lf->feild_value_name]);
                            }
                            
                        }
                        if($lf->feild_value_name!='description'){
                            $lead_data[$lf->feild_value_name] = sanitize($_POST[$lf->feild_value_name]);
                        }else{
                            $lead_data[$lf->feild_value_name] = ($_POST[$lf->feild_value_name]);
                        }
                    }
                    if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
                    {
                        $lead_data['assign_to_agent'] = decrypt_me($_SESSION['login_id']);
                    }
                }
            }
            $lead_data['created'] = date('Y-m-d H:i:s');
            $lead_data['followup_date'] = !empty($_POST['followup']) ? date("Y-m-d H:i:s", strtotime($_POST['followup'])) : date("Y-m-d H:i:s");
            $lead_data['updated'] = date('Y-m-d H:i:s');
            $lead_data['client_id'] = isset($_POST['client_id']) && !empty($_POST['client_id']) ? $_POST['client_id']:'';
            
            if(!empty($lead_data) && count($_SESSION['al_ferror'])==0){
                
                unset($_SESSION['al_ferror']);
                
                $id = $this->Lead_Model->add_new_lead($lead_data);
                $leadid = $id;
                if($id){
                   
                   $followup_data = array(
                        'lead_id'   => $id,
                        'commented_by'  => isset($_SESSION['login_id']) ? decrypt_me($_SESSION['login_id']) : 0,
                        'followup_status_id' => isset($_POST['status']) ? sanitize($_POST['status']) : '',
                        'followup_desc' => isset($_POST['followup_desc']) ? ($_POST['followup_desc']) : '',
                        'assign_to_agent' => isset($_POST['assign_to_agent']) ? sanitize($_POST['assign_to_agent']) : '',
                        'followup_status' => 1,
                        'for_calender' => isset($_POST['addtocal']) ? $_POST['addtocal'] : 'no',
                        'created' => date("Y-m-d h:i:s"),
                        'updated' => date("Y-m-d h:i:s")
                    );
                   
                    $followup_data['followup_date'] = !empty($_POST['followup']) ? date("Y-m-d H:i:s", strtotime($_POST['followup'])) : date("Y-m-d H:i:s");
                    
                    $fid = $this->Lead_Model->add_followup($followup_data);
                   
                   $_SESSION['lead_added'] = true;
                   if(isset($_SESSION['fforl']) && !empty($_SESSION['fforl']))
                   {
                       $this->Lead_Model->reserveForthis($_SESSION['fforl'], $id);
                   }
                   $this->session->set_flashdata("success", "Record has been updated."); 
                   unset($_SESSION['al_data']);
                }else{
                   $this->session->set_flashdata("error", "Unable to add new lead.");  
                }
            }else{
                $this->session->set_flashdata("error", "Please enter mandatory fields.");
                redirect(base_url('add-lead'));
            }
            
        }else{
            $this->session->set_flashdata("error", "Lead information is empty! Please check all fields.");
        }
        if(isset($_POST['isAddNew']) && $_POST['isAddNew']=='yes')
        {
            $_SESSION['sanother'] = "yes";
            redirect('add-lead');
        }else{
            if(isset($_SESSION['sanother'])){unset($_SESSION['sanother']);}
            redirect(base_url('followup-leads'));
        }
    }
    
    public function update_lead()
    {
        $lead_id = isset($_POST['lead_id']) ? $_POST['lead_id'] : '';
        if(!empty($_POST)){
            $lead_data = array();
            $lead_fields = get_fields();
            foreach($lead_fields as $lf)
            {
                if($lf->feild_type == 'email'){
                    if(isset($_POST[$lf->feild_value_name]) && filter_var($_POST[$lf->feild_value_name], FILTER_VALIDATE_EMAIL))
                    {
                       if(isset($_POST[$lf->feild_value_name]) && !empty($_POST[$lf->feild_value_name])){
                            $lead_data[$lf->feild_value_name] = sanitize($_POST[$lf->feild_value_name]);
                       }
                    }else if(!empty($_POST[$lf->feild_value_name])){
                        $this->session->set_flashdata("error", "Email is not valid.");
                    }
                }else{
                    if(isset($_POST[$lf->feild_value_name]) && is_array($_POST[$lf->feild_value_name]) 
                    && !empty($_POST[$lf->feild_value_name])){
                        $lead_data[$lf->feild_value_name] = sanitize(implode(",",$_POST[$lf->feild_value_name]));
                    }else if(isset($_POST[$lf->feild_value_name]) && !empty($_POST[$lf->feild_value_name])){
                        $lead_data[$lf->feild_value_name] = sanitize($_POST[$lf->feild_value_name]);
                    }
                }
            }
            $lead_data['updated'] = date('Y-m-d h:i:s');
            
            if(!empty($lead_data)){
                
                $id = $this->Lead_Model->update_lead($lead_id, $lead_data);
                if($id){
                   if(isset($_SESSION['fforl']) && !empty($_SESSION['fforl']))
                   {
                       $this->Lead_Model->reserveForthis($_SESSION['fforl'], $lead_id);
                   }
                   $this->session->set_flashdata("success", "Record has been updated."); 
                   unset($_SESSION['al_data']);
                   unset($_SESSION['fforl']);
                }else{
                   $this->session->set_flashdata("error", "Unable to update lead.");  
                }
            }else{
                $this->session->set_flashdata("error", "Something went wrong!");
            }
            
        }else{
            $this->session->set_flashdata("error", "Lead information is empty! Please check all fields.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    
    public function delete_lead()
    {
        if(isset($_GET['me']) && !empty($_GET['me']))
        {
            $s = $this->Lead_Model->delete_lead(htmlspecialchars($_GET['me']));
            $this->session->set_flashdata('success',"Record has been updated.");
        }
        redirect(base_url('lead'));
    }
    
    public function attach_doc()
    {
        $res = array("status"=>0,"data"=>"failed");
        
        $max_size = get_config_item('file_max_size');
        $allowed_type = explode("|", get_config_item('allowed_files'));
        $target_dir = "./resource/system_uploads/lead_docs/";
        
        if(isset($_FILES['upload_file']) && !empty($_FILES['upload_file']))
        {
            $target_file = $target_dir.$_FILES['upload_file']['name'];
            $ext = pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION);
            
            $data['lead_doc_type'] = $ext;
            $data['lead_doc_name'] = isset($_POST['file_name']) ? sanitize($_POST['file_name']) : '';
            $data['lead_id'] = isset($_POST['lead_id']) ? sanitize($_POST['lead_id']) : '';
            $data['lead_doc_status'] = 1;
            $data['created'] = date('Y-m-d h:i:s');
            $data['updated'] = date('Y-m-d h:i:s');
            if(in_array($ext, $allowed_type)){
                if($_FILES['upload_file']['size'] > $max_size){
                    $res['data'] = 'sizeerror';
                }else
                if(move_uploaded_file($_FILES['upload_file']['tmp_name'], $target_file)){
                    $new_file = "upload_".rand(0,100000).".".$ext;
                    if(file_exists($target_file)){
                        rename($target_file, $target_dir.$new_file);
                    }
                    $data['lead_doc_file'] = $new_file;
                    $id = $this->Lead_Model->save_lead_doc($data);
                    if($id){
                        $res['status'] = 1;
                        $res['data'] = 'success';
                        $this->session->set_flashdata('success','File has been uploaded.');
                    }else{
                        $res['saveerror'];
                    }
                }else{
                   $res['data'] = "uploaderror"; 
                }
            }else{
                $res['data'] = "filetypeerror";
            }
        }
        print_r(json_encode($res));
    }
    
    public function add_followup()
    {
        
        if(isset($_POST) && !empty($_POST))
        {
            $data = array(
                'lead_id'   => isset($_POST['lead_id']) ? sanitize($_POST['lead_id']) : '',
                'commented_by'  => isset($_SESSION['login_id']) ? decrypt_me($_SESSION['login_id']) : 0,
                'followup_status_id' => isset($_POST['followup_status']) ? sanitize($_POST['followup_status']) : '',
                'followup_desc' => isset($_POST['followup_desc']) ? sanitize($_POST['followup_desc']) : '',
                'assign_to_agent' => isset($_POST['followup_asign']) ? sanitize($_POST['followup_asign']) : '',
                'followup_status' => 1,
                'for_calender' => isset($_POST['is_cal']) ? $_POST['is_cal'] : 'no',
                'followup_lost_reason_id' => isset($_POST['lost_reason_id']) ? sanitize($_POST['lost_reason_id']) : '',
                'created' => date("Y-m-d h:i:s"),
                'updated' => date("Y-m-d h:i:s")
            );
            
            if(isset($_POST['followup_date']) && !empty($_POST['followup_date'])){
                $data['followup_date'] = date("Y-m-d H:i:s", strtotime($_POST['followup_date']));
            }
            
            if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
            {
                $data["assign_to_agent"] = decrypt_me($_SESSION['login_id']);
            }
            
            $id = $this->Lead_Model->add_followup($data);
            
            if($id){
                $this->Lead_Model->update_lead($data['lead_id'],
                array("status"=>$data['followup_status_id'],"assign_to_agent"=>$this->input->post('followup_asign',true),"updated"=>date("Y-m-d h:i:s"),
                "followup_date"=>date("Y-m-d H:i:s", strtotime($_POST['followup_date']))));
                
                if(strtolower(get_module_value($data['followup_status_id'], 'status'))=='won')
                {
                    $lead_d = $this->Lead_Model->get_lead_by_id(base64_encode($data['lead_id']));
                    $this->convert_to_client($lead_d);
                }
                $this->session->set_flashdata('success', 'Record has been updated.');
            }else{
                $this->session->set_flashdata('error', 'Unable to add!');
            }
        }else{
            $this->session->set_flashdata('error', 'Follow Up data not found!');
        }
        
        redirect(base_url('followup-leads'));
    }
    
    public function get_followup_notification()
    {
        $res = array("status"=>"failed", "n"=>"");
        if(isset($_POST['push']))
        {
            $f_notification = $this->Lead_Model->get_all_f_notification(date("Y-m-d"));
            if(!empty($f_notification))
            {
                $res['status'] = "success";
                foreach($f_notification as $f)
                {
                    $f->lead_id = base_url('followup?lead=').base64_encode($f->lead_id);
                    $f->commented_by = ($f->commented_by==0) ? 'Admin' : get_module_value($f->commented_by,'agent');
                    $f->followup_status_id = get_module_value($f->followup_status_id,'status');
                    
                }
                $res['n'] = $f_notification;
            }
        }
        print_r(json_encode($res));
    }
    
    public function mark_notified()
    {
        $res = array("status"=>"success", "n"=>"");
        if(isset($_POST['followup_id']))
        {
            $this->db->where("followup_id", $_POST['followup_id'])->update("crm_followup", ['desktop_notified' => 1]);
        }
        print_r(json_encode($res));
    }
    
    public function get_expired_followup()
    {
        $res = array("status"=>"failed", "f"=>"");
        if(isset($_POST['c']))
        {
            $f_ = $this->Lead_Model->get_expired_f();
            if(!empty($f_))
            {
                $res['status'] = "success";
                $res['f'] = $f_;
            }
        }
        print_r(json_encode($res));
    }
    
    public function convert_to_client($lead)
    {
        if(!empty($lead))
        {
            $last_id = get_last_client_id();
            if(!empty($last_id)){
                $int = intval(filter_var($last_id, FILTER_SANITIZE_NUMBER_INT));
                $int = intval($int) + 1;
                $new_id = "USR".$int;
            }else{
                $new_id = "USR1";
            }
            if(!empty($lead->client_id)){
                $isa = $this->Client_Model->get_client_by_id(base64_encode($lead->client_id));
            }else{
                $isa = get_client_by_email($lead->email_id);
            }
            if(!$isa){
                $c_data = array(
                    "client_name"  => sanitize($lead->full_name),
                    "client_company"  => sanitize($lead->company_name),
                    "client_email"  => sanitize($lead->email_id),
                    "client_mobile"  => sanitize($lead->contact_no),
                    "client_position"  => sanitize($lead->position),
                    "client_alt_no"  => sanitize($lead->alternative_no),
                    "client_website"  => sanitize($lead->website),
                    "client_source"  => get_module_value($lead->lead_source, 'lead_source'),
                    "client_fulladdress"  => sanitize($lead->full_address),
                    "client_country"  => sanitize($lead->country),
                    "client_state"  => sanitize($lead->state),
                    "client_city"  => sanitize($lead->city),
                    "client_pincode"  => sanitize($lead->pincode),
                    "client_password" => md5($lead->contact_no),
                    "reference_name"  => sanitize($lead->reference_name ?? ''),
                    "reference_contact_number" => sanitize($lead->reference_contact_number ?? ''),
                    "client_raw_password" => encrypt_me($lead->contact_no),
                    "client_uid" => sanitize($new_id),
                    "by_agent" => sanitize($lead->assign_to_agent),
                    "lead_id" => sanitize($lead->lead_id),
                    "updated"  => date("Y-m-d"),  
                    "created"  => date("Y-m-d")  
                );
                if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
                {
                    $c_data["by_agent"] = decrypt_me($_SESSION['login_id']);
                }
                if(!empty($c_data))
                {
                    $is = $this->Client_Model->add_new($c_data);
                    $is = $this->Client_Model->get_client_by_id(base64_encode($is));
                    ($is) ? redirect(base_url("create-invoice?")."ref=".base64_encode($is->client_id."_".$is->client_name))
                    : '';
                }else{
                    return false;
                }
            }else{
                redirect(base_url("create-invoice?")."ref=".base64_encode($isa->client_id."_".$isa->client_name));
            }
        }else{
            return false;
        }
    }
    
    public function send_fsms()
    {
        $res = array("status"=>0, "data"=>"failed");
        if(isset($_POST['mob']) && !empty($_POST['mob']))
        {
            $is = $this->SMS_Model->send_sms($_POST['mob'],'', $_POST['sms']);
            if($is)
            {
                $res['status'] = 1;
                $res['data'] = "success";
            }
        }
        print_r(json_encode($res));
    }
    
    public function bulk_a()
    {
        $res = array("status"=>0, "data"=>"failed");
        $leads = isset($_POST['leads']) ? $_POST['leads'] : '';
        $agent = isset($_POST['agent']) ? $_POST['agent'] : '';
        $s = isset($_POST['status']) ? $_POST['status'] : '';
        
        if(isset($_POST['status']) && !empty($_POST['status']))
        {
            if(!empty($leads))
            {
                $is = $this->Lead_Model->change_status($leads, $s);
                if($is)
                {
                    $fdata = array("followup_status_id"=>$s);
                    foreach($leads as $l){
                        $fdata = array(
                            'lead_id'   => base64_decode($l),
                            'commented_by'  => isset($_SESSION['login_id']) ? decrypt_me($_SESSION['login_id']) : 0,
                            'followup_status_id' => $s,
                            'followup_desc' => 'Bulk Action',
                            'assign_to_agent' => '',
                            'followup_status' => 1,
                            'followup_date' => date("Y-m-d h:i"),
                            'for_calender' => 'no',
                            'followup_lost_reason_id' => '',
                            'created' => date("Y-m-d h:i:s"),
                            'updated' => date("Y-m-d h:i:s")
                        );
                        $this->Lead_Model->add_followup($fdata);
                    }
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
        }
        if(isset($_POST['agent']) && !empty($_POST['agent']))
        {
            if(!empty($leads))
            {
                $is = $this->Lead_Model->transfer_to_agent($leads, base64_decode($agent));
                if($is)
                {
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
        }
        
        print_r(json_encode($res));
    }
    
    public function action()
    {
        $res = array("status"=>0, "data"=>"failed");
        if(isset($_GET['deleteSelected']))
        {
            if(isset($_POST['ids']) && !empty($_POST['ids']))
            {
                $is = $this->Lead_Model->deleteSelected($_POST['ids']);
                if($is)
                {
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
            print_r(json_encode($res));
        }
        
        if(isset($_GET['delg']))
        {
            if(isset($_GET['g']) && !empty($_GET['g']))
            {
                $this->Lead_Model->delete_group($_GET['g']);
            }
            $this->session->set_flashdata("success","Record has been updated.");
            redirect($_SERVER['HTTP_REFERER']);
        }
        
        if(isset($_GET['delglist']))
        {
            if(isset($_GET['g']) && !empty($_GET['g']))
            {
                $this->Lead_Model->delete_grouplist($_GET['g']);
            }
            $this->session->set_flashdata("success","Record has been updated.");
            redirect($_SERVER['HTTP_REFERER']);
        }
        
        if(isset($_GET['delfile']))
        {
            if(isset($_GET['f']) && !empty($_GET['f']))
            {
                $this->Lead_Model->delete_file($_GET['f']);
                if(isset($_GET['fu']) && file_exists('resource/system_uploads/lead_docs/'.base64_decode($_GET['fu'])))
                {
                    unlink('resource/system_uploads/lead_docs/'.base64_decode($_GET['fu']));
                }
                $this->session->set_flashdata('success','Record has been updated.');
            }
            $this->session->set_flashdata("success","Record has been updated.");
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    
    public function add_group()
    {
        if(isset($_POST['group_name']) && !empty($_POST['group_name']))
        {
            $data = array(
              "group_name" => htmlspecialchars($_POST['group_name']),
              "group_status" => 1,
              "created" => date("Y-m-d h:i:s"),
              "updated" => date("Y-m-d h:i:s")
            );
            $is = $this->Lead_Model->add_group($data);
            $this->session->set_flashdata("success","Record has been updated.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function update_group()
    {
        if(isset($_POST['group_name']) && !empty($_POST['group_name']))
        {
            $data = array(
              "group_name" => htmlspecialchars($_POST['group_name']),
              "group_status" => 1,
              "updated" => date("Y-m-d h:i:s")
            );
            $is = $this->Lead_Model->update_group($_POST['group_id'], $data);
            $this->session->set_flashdata("success","Record has been updated.");
        }
        redirect(base_url('import-lead'));
    }
    
    public function import_lead()
    {
        if(!empty($_POST) && !empty($_FILES)) {
            $group = $this->input->post("group", TRUE);
            $empty_value_found = $is_added = false;
            $_SESSION['lfields'] = array();
            $ext = pathinfo($_FILES['leadfile']['name'], PATHINFO_EXTENSION);
            if($ext==='csv'){
                $tdir = "resource/tmp/".$_FILES['leadfile']['name'];
                $file = $_FILES['leadfile']['tmp_name'];
                $handle = fopen ($file,"r");
                if(move_uploaded_file($_FILES['leadfile']['tmp_name'], $tdir)){
                    $_SESSION['import_file'] = $tdir;   
                }
                if(isset($_POST))
                {
                    $_SESSION['lfields'] = $_POST;
                    if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
                    {
                        $_SESSION['assign_to_agent'] = decrypt_me($_SESSION['login_id']);
                    }
                }
                
                $fileop = fgetcsv($handle,0,",");
                $_SESSION['filecols'] = array();
                foreach($fileop as $fh)
                {
                    array_push($_SESSION['filecols'], $fh);
                }
                redirect('home/map_file_to');
            }else{
                $this->session->set_flashdata("error","Only csv file is supported!");
                redirect($_SERVER['HTTP_REFERER']);
            }
        }else {
            $this->session->set_flashdata("error","Data not found!");
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function import_lead_file()
    {
        $file = $_SESSION['import_file'];
        $handle = fopen ($file,"r");
        $fileoph = fgetcsv($handle,0,",");
        $added = false;
        
        while(($fileop = fgetcsv($handle,0,",")) !==false){
            if(isset($_POST['colsmap']) && is_array($_POST['colsmap']))
            {
                foreach($_POST['colsmap'] as $k=>$v)
                {
                    ($v!='') ? $data[$k] = $fileop[$v] : '';
                }
            }
            if(isset($_SESSION['lfields']) && is_array($_SESSION['lfields']))
            {
                foreach($_SESSION['lfields'] as $k=>$v)
                {
                    !empty($k) ? $data[$k] = $v : '';
                }
            }
            $data['created'] = date("Y-m-d h:i:s");
            $data['updated'] = date("Y-m-d h:i:s");
            
            $is = $this->Lead_Model->add_new_lead($data);
            if($is)
            {
                $added = true;
            }else{
                $added = false;
            }
        }
        
        if($added)
        {
            unset($_SESSION['lfields']);
            unset($_SESSION['filecols']);
            file_exists($_SESSION['import_file']) ? unlink($_SESSION['import_file']) : '';
            unset($_SESSION['import_file']);
            
            $this->session->set_flashdata("success","Leads Imported Successfully.");
            redirect("lead");
        }else{
            unset($_SESSION['lfields']);
            unset($_SESSION['filecols']);
            file_exists($_SESSION['import_file']) ? unlink($_SESSION['import_file']) : '';
            unset($_SESSION['import_file']);
            $this->session->set_flashdata("error","Some data was broken rest imported.");
            redirect("import-lead");
        }
    }
    
}

?>