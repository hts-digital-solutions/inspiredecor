<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Setting extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url','file','security'));
        $this->load->helper('sconfig_helper');
        $this->load->model('Setting_Model');
        $this->load->library("Auth");
        $this->Auth = new Auth();
        $this->Auth->_check_auth();
        date_default_timezone_set("Asia/Kolkata");
    }
    
    public function sort_lead_feild()
    {
        if(!empty($_POST['id']))
        {
            $index = isset($_POST['index']) ? $_POST['index'] : 0;
            $swap = isset($_POST['swap']) ? $_POST['swap'] : 0;
            $this->Setting_Model->sort_crm_feild($_POST['id'], $_POST['sid'], $index, $swap);
            echo "ok";
        }else{
            echo "error";
        }
    }
    
    public function add_custom_field()
    {
        $res = array("status"=>0, "data"=>'failed');
        
        if(isset($_POST) && !empty($_POST))
        {
            $data = array(
                'feild_name' => $this->input->post('feild_name', true),
                'feild_value_name' => strtolower(str_replace(" ", "_", $this->input->post('feild_name', true))),
                'feild_type' => $this->input->post('option_type', true),
                'action_allowed' => 1,
                'feild_status' => 1,
                'created'   => date('Y-m-d'),
                'updated'   => date('Y-m-d')
            );
            
            if(isset($_POST['forlead']) && $_POST['forlead']==='yes'){
                $data['for_ip'] = $_SERVER['REMOTE_ADDR'].":".$this->agent->browser();
            }
            
            if(isset($_POST['section']) && $_POST['section']!='other'){
                $data['section_id'] = $this->input->post('section', true);
            }else if(isset($_POST['new_section']) && !empty($_POST['new_section'])){
                $id = $this->Setting_Model->add_new_section($_POST['new_section']);
                $data['section_id'] = $id;
            }
            if(empty($_POST['feild_id'])){
                $data['feild_index'] = intval(get_last_field_index($this->input->post('section', true))) + 1;
            }
            if(isset($_POST['option_value_name']) && !empty($_POST['option_value_name'])){
                $data['feild_options'] = implode(",", $_POST['option_value_name']);
                $data['feild_options_value'] = str_replace(' ','_',implode(",", array_map('strtolower', $_POST['option_value_name'])));
            }
            if(isset($_POST['module']) && !empty($_POST['module'])){
                $data['option_module'] = $_POST['module'];
            }
            $status = false;
            if(empty($_POST['feild_id'])){
                $status = $this->Setting_Model->add_custom_field($data);
                if($status){
                    $this->add_this_to_lead($data['feild_value_name']);
                    if(isset($_POST['forlead']) && $_POST['forlead']==='yes'){
                        $_SESSION['fforl'] = $status->feild_id;
                    }
                }
            }else{
                $res['update'] = true;
                $status = $this->Setting_Model->update_custom_field($_POST['feild_id'], $data);
            }
            if($status){
                $res['data'] = 'done';
                $res['status'] = 1;
                $res['section'] = "id".$data['section_id'];
                $res['en'] = base64_encode($status->feild_id);
                $res['n'] = $status->feild_name;
                $res['action_allowed']=$status->action_allowed;
                $res['in'] = $status->feild_index;
            }else{
                $data['data'] = 'error';
            }
            
            
        }
        print_r(json_encode($res));
    }
    
    
    public function get_field_info(){
        $res = array('status'=>0, 'data'=>'failed');
        
        if(isset($_POST['id']) && !empty($_POST['id']))
        {
            $data = $this->Setting_Model->get_field_show_by_id(base64_decode($_POST['id']));
            $res['data'] = $data;
            $res['status'] = 1;
        }
        
        print_r(json_encode($res));
    }
    
    public function delete_field()
    {
        $name = '';
        $res = array('status'=>0, 'data'=>'failed');
        if(isset($_POST['id']) && !empty($_POST['id']))
        {
            $fd = $this->Setting_Model->get_field_show_by_id(base64_decode($_POST['id']));
            $name = $fd->feild_value_name;
            $this->Setting_Model->delete_feild(base64_decode($_POST['id']));
            if(true){
                $this->Setting_Model->remove_this_to_lead($name);
                $res['status'] = 1;
                $res['data'] = 'success';
            }
        }
        print_r(json_encode($res));
    }
    
    public function add_this_to_lead($column)
    {
        if(!empty($column))
        {
            $this->Setting_Model->add_this_to_lead($column);
            return true;
        }
    }
    
    public function save_setting()
    {
        
        $valid = false;
        if(isset($_POST) && !empty($_POST))
        {
            $data = array();
            if(isset($_POST['company_name']) && !empty($_POST['company_name']))
            {
                $data['company_name'] = sanitize($_POST['company_name']);
            }
            
            if(isset($_POST['contact_person']) && !empty($_POST['contact_person']))
            {
                $data['contact_person'] = sanitize($_POST['contact_person']);
            }
            
            if(isset($_POST['company_email']) && !empty($_POST['company_email']))
            {
                $data['company_email'] = sanitize($_POST['company_email']);
            }
            
            if(isset($_POST['company_mobile']) && !empty($_POST['company_mobile']))
            {
                $data['company_mobile'] = sanitize($_POST['company_mobile']);
            }
            
            if(isset($_POST['website_name']) && !empty($_POST['website_name']))
            {
                $data['website_name'] = sanitize($_POST['website_name']);
            }
            
            if(isset($_POST['company_address']) && !empty($_POST['company_address']))
            {
                $data['company_address'] = sanitize($_POST['company_address']);
            }
            
            if(isset($_POST['company_zip_code']) && !empty($_POST['company_zip_code']))
            {
                $data['company_zip_code'] = sanitize($_POST['company_zip_code']);
            }
            if(isset($_POST['RAZOR_KEY_ID']) && !empty($_POST['RAZOR_KEY_ID']))
            {
                $data['RAZOR_KEY_ID'] = encrypt_me(sanitize($_POST['RAZOR_KEY_ID']));
            }
            if(isset($_POST['RAZOR_KEY_SECRET']) && !empty($_POST['RAZOR_KEY_SECRET']))
            {
                $data['RAZOR_KEY_SECRET'] = encrypt_me(sanitize($_POST['RAZOR_KEY_SECRET']));
            }
            
            if(isset($_POST['PAYU_KEY_ID']) && !empty($_POST['PAYU_KEY_ID']))
            {
                $data['PAYU_KEY_ID'] = encrypt_me(sanitize($_POST['PAYU_KEY_ID']));
            }
            if(isset($_POST['PAYU_SALT_KEY']) && !empty($_POST['PAYU_SALT_KEY']))
            {
                $data['PAYU_SALT_KEY'] = encrypt_me(sanitize($_POST['PAYU_SALT_KEY']));
            }
            
            if(isset($_POST['company_city']) && !empty($_POST['company_city']))
            {
                $data['company_city'] = sanitize($_POST['company_city']);
            }
            
            if(isset($_POST['sms_api_key']) && !empty($_POST['sms_api_key']))
            {
                $data['sms_api_key'] = sanitize($_POST['sms_api_key']);
            }
            
            if(isset($_POST['company_state']) && !empty($_POST['company_state']))
            {
                $data['company_state'] = sanitize($_POST['company_state']);
            }
            
            if(isset($_POST['company_country']) && !empty($_POST['company_country']))
            {
                $data['company_country'] = sanitize($_POST['company_country']);
            }
            
            if(isset($_POST['company_gst']) && !empty($_POST['company_gst']))
            {
                $data['company_gst'] = sanitize($_POST['company_gst']);
            }
            
            if(isset($_POST['company_pan']) && !empty($_POST['company_pan']))
            {
                $data['company_pan'] = sanitize($_POST['company_pan']);
            }
            
            if(isset($_POST['company_cin']) && !empty($_POST['company_cin']))
            {
                $data['company_cin'] = sanitize($_POST['company_cin']);
            }
            
            if(isset($_POST['username']) && !empty($_POST['username']))
            {
                $data['admin_username'] = sanitize($_POST['username']);
            }
            
            if(isset($_POST['last_passwd']) && !empty($_POST['last_passwd'])
             && isset($_POST['new_passwd']) && !empty($_POST['new_passwd'])
             && md5($_POST['last_passwd'])==get_config_item('admin_password'))
            {
                $data['admin_password'] = md5($_POST['new_passwd']);
                $data['admin_raw_password'] = encrypt_me($_POST['new_passwd']);
            }
            
            
            if(isset($_POST['locale']) && !empty($_POST['locale']))
            {
                $data['locale'] = sanitize($_POST['locale']);
            }
            
            if(isset($_POST['mail_type']) && !empty($_POST['mail_type']))
            {
                $data['mail_type'] = sanitize($_POST['mail_type']);
            }
            if(isset($_POST['task_what']) && !empty($_POST['task_what']))
            {
                $data['task_what'] = sanitize($_POST['task_what']);
            }
            
            if(isset($_POST['followup_what']) && !empty($_POST['followup_what']))
            {
                $data['followup_what'] = sanitize($_POST['followup_what']);
            }
            
            if(isset($_POST['task_notified_minute']) && !empty($_POST['task_notified_minute']))
            {
                $data['task_notified_minute'] = sanitize($_POST['task_notified_minute']);
            }else{
                $data['task_notified_minute'] = 10;
            }
            
            if(isset($_POST['followup_notified_minute']) && !empty($_POST['followup_notified_minute']))
            {
                $data['followup_notified_minute'] = sanitize($_POST['followup_notified_minute']);
            }else{
                $data['followup_notified_minute'] = 10;
            }
            
            if(isset($_POST['default_currency']) && !empty($_POST['default_currency']))
            {
                $data['default_currency'] = sanitize($_POST['default_currency']);
            }
            
            if(isset($_POST['currency_position']) && !empty($_POST['currency_position']))
            {
                $data['currency_position'] = sanitize($_POST['currency_position']);
            }
            
            if(isset($_POST['currency_decimals']) && !empty($_POST['currency_decimals']))
            {
                $data['currency_decimals'] = sanitize($_POST['currency_decimals']);
            }
            
            if(isset($_POST['razorpay_furl']) && !empty($_POST['razorpay_furl']))
            {
                $data['razorpay_furl'] = sanitize($_POST['razorpay_furl']);
            }
            if(isset($_POST['razorpay_surl']) && !empty($_POST['razorpay_surl']))
            {
                $data['razorpay_surl'] = sanitize($_POST['razorpay_surl']);
            }
            
            if(isset($_POST['payu_furl']) && !empty($_POST['payu_furl']))
            {
                $data['payu_furl'] = sanitize($_POST['payu_furl']);
            }
            if(isset($_POST['payu_surl']) && !empty($_POST['payu_surl']))
            {
                $data['payu_surl'] = sanitize($_POST['payu_surl']);
            }
            
            if(isset($_POST['two_step_verification']) && !empty($_POST['two_step_verification']))
            {
                $data['two_step_verification'] = sanitize($_POST['two_step_verification']);
            }else{
                $data['two_step_verification'] = 'no';
            }
            
            if(isset($_POST['is_razorpay']) && !empty($_POST['is_razorpay']))
            {
                $data['is_razorpay'] = sanitize($_POST['is_razorpay']);
            }else{
                $data['is_razorpay'] = 'no';
            }
            
            if(isset($_POST['is_payu']) && !empty($_POST['is_payu']))
            {
                $data['is_payu'] = sanitize($_POST['is_payu']);
            }else{
                $data['is_payu'] = 'no';
            }
            
            if(isset($_POST['is_bank_details']) && !empty($_POST['is_bank_details']))
            {
                $data['is_bank_details'] = sanitize($_POST['is_bank_details']);
            }else{
                $data['is_bank_details'] = 'no';
            }
            
            if(isset($_POST['bank_details']) && !empty($_POST['bank_details']))
            {
                $data['bank_details'] = htmlspecialchars($this->input->post('bank_details',true));
            }else{
                $data['bank_details'] = '';
            }
            
            if(isset($_POST['login_notification']) && !empty($_POST['login_notification']))
            {
                $data['login_notification'] = sanitize($_POST['login_notification']);
            }else{
                $data['login_notification'] = 'no';
            }
            
            if(isset($_POST['purchase_code']) && !empty($_POST['purchase_code']))
            {
                $pkey = sanitize($_POST['purchase_code']);
                $v = file_get_contents(VERIFY_URL.'verify?code='.$pkey);
                $v = true;//json_decode($v);
                
                if($v == null) 
                {
                    $this->session->set_flashdata('error', 'Your purchase code is Invalid for this hosting. Please try again');
                    redirect($_SERVER['HTTP_REFERER']);
                }else
                {   
                    /*if( isset($v->server) && $v->server !== $_SERVER['SERVER_ADDR']
                    || isset($v->domain) && $v->domain !== remove_www($_SERVER['HTTP_HOST'])
                    || !isset($v->server) || !isset($v->domain))
                    {
                       $this->session->set_flashdata('error', 'Please check your purchase key!');
                       redirect($_SERVER['HTTP_REFERER']);
                    }else{*/
                        // $d = 'Installed'."|".encrypt_me($pkey.remove_www($_SERVER['HTTP_HOST']).$_SERVER['SERVER_ADDR'])."|".date('Y-m-d H:i:s')."|".base64_encode($_SERVER['HTTP_HOST'].$_SERVER['SERVER_ADDR']);
                        // $data['purchase_code'] = encrypt_me($pkey.remove_www($_SERVER['HTTP_HOST']).$_SERVER['SERVER_ADDR']);
                        // write_file('./application/config/installed.txt', $d);
                        $valid = true;
                    //}
                }
            }
            
            if(isset($_POST['default_tax']) && !empty($_POST['default_tax']))
            {
                $data['default_tax'] = sanitize($_POST['default_tax']);
            }
            
            if(isset($_POST['']) && !empty($_POST['']))
            {
                $data[''] = $_POST[''];
            }
            
            if(isset($_POST['date_format']) && !empty($_POST['date_format']))
            {
                $data['date_format'] = sanitize($_POST['date_format']);
            }
            
            if(isset($_POST['file_max_size']) && !empty($_POST['file_max_size']))
            {
                $data['file_max_size'] = sanitize($_POST['file_max_size']);
            }
            
            if(isset($_POST['support_email']) && !empty($_POST['support_email']))
            {
                $data['support_email'] = sanitize($_POST['support_email']);
            }
            
            if(isset($_POST['email_protocol']) && !empty($_POST['email_protocol']))
            {
                $data['email_protocol'] = sanitize($_POST['email_protocol']);
            }
            
            if(isset($_POST['smtp_host']) && !empty($_POST['smtp_host']))
            {
                $data['smtp_host'] = sanitize($_POST['smtp_host']);
            }
            
            if(isset($_POST['smtp_user']) && !empty($_POST['smtp_user']))
            {
                $data['smtp_user'] = sanitize($_POST['smtp_user']);
            }
            
            if(isset($_POST['smtp_pass']) && !empty($_POST['smtp_pass']))
            {
                $data['smtp_pass'] = sanitize($_POST['smtp_pass']);
            }
            
            if(isset($_POST['smtp_port']) && !empty($_POST['smtp_port']))
            {
                $data['smtp_port'] = sanitize($_POST['smtp_port']);
            }
            
            if(isset($_POST['sms_host']) && !empty($_POST['sms_host']))
            {
                $data['sms_host'] = sanitize($_POST['sms_host']);
            }
            
            if(isset($_POST['sms_user_id']) && !empty($_POST['sms_user_id']))
            {
                $data['sms_user_id'] = sanitize($_POST['sms_user_id']);
            }
            
            if(isset($_POST['sms_user']) && !empty($_POST['sms_user']))
            {
                $data['sms_user'] = sanitize($_POST['sms_user']);
            }
            
            if(isset($_POST['sms_pass']) && !empty($_POST['sms_pass']))
            {
                $data['sms_pass'] = sanitize($_POST['sms_pass']);
            }
            
            if(isset($_POST['invoice_prefix']) && !empty($_POST['invoice_prefix']))
            {
                $data['invoice_prefix'] = sanitize($_POST['invoice_prefix']);
            }
            
            if(isset($_POST['invoices_due_after']) && !empty($_POST['invoices_due_after']))
            {
                $data['invoices_due_after'] = sanitize($_POST['invoices_due_after']);
            }
            
            if(isset($_POST['invoices_due_before']) && !empty($_POST['invoices_due_before']))
            {
                $data['invoices_due_before'] = sanitize($_POST['invoices_due_before']);
            }
            
            if(isset($_POST['invoice_start_no']) && !empty($_POST['invoice_start_no']))
            {
                $data['invoice_start_no'] = sanitize($_POST['invoice_start_no']);
            }
            
            if(isset($_FILES['invoice_logo']) && !empty($_FILES['invoice_logo']['name']))
            {
                $target = "./resource/system_uploads/inv_logo/";
                $file = $_FILES['invoice_logo']['name'];
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if(in_array($ext, array("jpg","jpeg","png"))){
                    if(move_uploaded_file($_FILES['invoice_logo']['tmp_name'], $target.$file)){
                        $data['invoice_logo'] = $file;
                        if(file_exists($target.$_POST['prev_logo'])){
                            unlink($target.$_POST['prev_logo']);
                        }
                    }else{
                       $data['invoice_logo'] = sanitize($_POST['prev_logo']); 
                    }
                }else{
                   $this->session->set_flashdata('error', 'Please check invoice logo type!');
                   redirect($_SERVER['HTTP_REFERER']); 
                }
                
            }else if(isset($_POST['prev_logo']) && !empty($_POST['prev_logo']))
            {
                $data['invoice_logo'] = sanitize($_POST['prev_logo']);
            }
            
            if(isset($_POST['invoice_email_subject']) && !empty($_POST['invoice_email_subject']))
            {
                $data['invoice_email_subject'] = $_POST['invoice_email_subject'];
            }
            if(isset($_POST['invoice_email_content']) && !empty($_POST['invoice_email_content']))
            {
                $data['invoice_email_content'] = $_POST['invoice_email_content'];
            }
            if(isset($_POST['overdue_email_subject']) && !empty($_POST['overdue_email_subject']))
            {
                $data['overdue_email_subject'] = $_POST['overdue_email_subject'];
            }
            
            if(isset($_POST['overdue_email_content']) && !empty($_POST['overdue_email_content']))
            {
                $data['overdue_email_content'] = $_POST['overdue_email_content'];
            }
            if(isset($_POST['email_signature']) && !empty($_POST['email_signature']))
            {
                $data['email_signature'] = $_POST['email_signature'];
            }
            if(isset($_POST['invoice_confirmation_subject']) && !empty($_POST['invoice_confirmation_subject']))
            {
                $data['invoice_confirmation_subject'] = $_POST['invoice_confirmation_subject'];
            }
            if(isset($_POST['invoice_confirmation_content']) && !empty($_POST['invoice_confirmation_content']))
            {
                $data['invoice_confirmation_content'] = $_POST['invoice_confirmation_content'];
            }
            
            if(isset($_POST['subject']) && isset($_POST['content']))
            {
                for($i=0; $i<count($_POST['subject']); $i++)
                {
                    $edata = array(
                      "subject" => $_POST['subject'][$i],
                      "content" => $_POST['content'][$i],
                      "status" => 1,
                      "updated" => date("Y-m-d H:i:s")
                    );
                    
                    if(isset($_POST['etempid'][$i]))
                    {
                        $q = $this->Setting_Model->update_etemplate($_POST['etempid'][$i], $edata);
                        if($q){
                            $this->session->set_flashdata("success","Record has been updated.");
                        }
                    }else{
                        $edata['created'] = date("Y-m-d H:i:s");
                        $isq = $this->Setting_Model->add_etemplate($edata);
                        if($isq){
                            $this->session->set_flashdata("success","Record has been updated.");
                        }
                    }
                }
            }
            
            if(!empty($data))
            {
                $is = $this->Setting_Model->save_settings($data);
                if($is){
                    $this->session->set_flashdata("success", "Settings updated Successfully.");
                }else{
                    $this->session->set_flashdata("error", "No changes deleted.");
                }
            }else{
                $this->session->set_flashdata("error", "Purchase key should not be blank.");
            }
            
        }else{
            $this->session->set_flashdata("error", "Something went wrong, Please check data.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function markRequired()
    {
        $res = array("status"=>0,"data"=>"failed");
        if(isset($_POST['id']) && isset($_POST['val']))
        {
            $is = $this->Setting_Model->markRequired($_POST['id'], $_POST['val']);
            if($is)
            {
                $res['status'] = 1;
                $res['data'] = "success";
            }
        }
        
        print_r(json_encode($res));
    }
}
?>
