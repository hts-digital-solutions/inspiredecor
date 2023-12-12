<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Home extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('security');
        $this->load->helper('sconfig_helper');
        $this->load->helper('client_helper');
        $this->load->helper('vendor_helper');
        $this->load->helper('lead_helper');
        $this->load->helper('task_helper');
        $this->load->model('Lead_Model');
        $this->load->model('Product_Model');
        $this->load->model('Project_Model');
        $this->load->model('Project_Expense_Model');
        $this->load->model('Agent_Model');
        $this->load->model('Invoice_Model');
        $this->load->model('Client_Model');
        $this->load->model('Vendor_Model');
        $this->load->model('Setting_Model');
        $this->load->model('Email_Model');
        $this->load->model('Report_Model');
        $this->load->model('Task_Model');
        $this->load->model('SMS_Model');
        $this->load->library("Auth");
        $this->Auth = new Auth();
        
        date_default_timezone_set("Asia/Kolkata");
        
        //clear
        if($this->uri->segment(1)!='add-client'){
            unset($_SESSION['dback']) ;
            unset($_SESSION['rfield']) ;
        }
        if($this->uri->segment(1)!='add-lead')
        {
            unset($_SESSION['al_ferror']);
        }
    }
    
    public function saveDeviceToken()
    {
        $token = isset($_GET['token']) ? $_GET['token'] : "";
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        
        if($token) {
            if($id == 0) {
                $is = $this->db->where("config_key", "device_token")->get("crm_config");
                if($is->num_rows() > 0) {
                    $this->db->where("config_key", "device_token")->update("crm_config", ['value' => $token]);
                }else {
                    $this->db->insert("crm_config", ["config_key" => "device_token", "value" => $token]);
                }
            }else {
                $this->db->where("agent_id", $id)->update("crm_agent", ["device_token" => $token]);
            }
            
            echo json_encode(['status' => "success", "message" => "Token updated"]);
        }else {
            echo json_encode(['status' => "failed", "message" => "Token required"]);
        }
    }
    
    public function index()
    {
        if(isset($_SESSION['logged_in']) && isset($_SESSION['roll']) 
        && $_SESSION['roll']==='admin')
        {
            if(isset($_GET['ref']) && base64_decode($_GET['ref'])=='/setting'){
                if(isset($_SESSION['setting_access']) && $_SESSION['setting_access']===true){
                   redirect('setting'); 
                }else{
                   $_SESSION['access_sr'] = true;
                   $this->_system_login(); 
                }
            }else{
                $this->_admin_dashboard();
            }
        }else if(isset($_SESSION['logged_in']) && $_SESSION['roll']!='admin'){
            $this->_user_dashboard();
        }
        else{
            $this->_system_login();
        }
    }
    
    public function check_session_in_screen() {
        print_r($_SESSION);
    }
    
    public function _system_login()
    {
        $hdata['title'] = "System Login";
        $hdata['page_type'] = "login";
        $hdata['rurl'] = base_url('resource/');
        $hdata['amp'] = $hdata['canonical'] = base_url();
        
        $_SESSION['ref_url'] = isset($_GET['ref']) ? $_GET['ref'] : '';
        if(isset($_GET['ref']) && base64_decode($_GET['ref'])=='/setting'){
            $data['typeref'] = isset($_GET['ref']) ? $_GET['ref'] : '';
        }else{
            $data['typeref'] = "";
        }
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("modules/home/system_login", $data);
        $this->load->view("includes/global_footer", $hdata);
        
    }
    
    public function V2stepverification()
    {
        (isset($_SESSION['logged_in'])) ? redirect(base_url()) : '';
        (!isset($_SESSION['2sv'])) ? redirect(base_url()) : '';
        if(isset($_SESSION['al']) && $_SESSION['al'] > 3){
            $this->session->set_flashdata('l-error','Too many login attempts! Account will be lock.');
            redirect(base_url());    
        }
        
        $hdata['title'] = "2stepVerification";
        $hdata['page_type'] = "login";
        $hdata['rurl'] = base_url('resource/');
        $hdata['amp'] = $hdata['canonical'] = base_url();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("modules/home/2stepv");
        $this->load->view("includes/global_footer", $hdata);
        
    }
    
    public function validateLogin()
    {
        /*$purchase_code = str_replace('www.', '', o_pkey(get_config_item('purchase_code')));
        $res = file_get_contents(VERIFY_URL.'verify?code='.$purchase_code);
       
        if(json_decode($res)->is_valid==='no')
        {
            $this->session->set_flashdata("l-error","Your account has been disabled! Please contact to administrator.");
            redirect('/');
        }*/
        
        $_SESSION['sgen'] = encrypt_me(rand(0,10000000));
        $is2step = get_config_item('two_step_verification');
        if(isset($_GET['ref']) && !empty($_GET['ref']))
        {
            if(isset($_POST['username']) && isset($_POST['password'])){
                
                $username = !filter_var($_POST['username'], FILTER_VALIDATE_EMAIL) ? $_POST['username'] : '';
                $email = filter_var($_POST['username'], FILTER_VALIDATE_EMAIL) ? $_POST['username'] : '';
                $password = isset($_POST['password']) ? md5($_POST['password']) : '';
                
                if(!empty($username)){
                    $is = validate_login_username($username, $password);
                    if($is){
                        if($is2step==='yes'){
                            $number = get_config_item('company_mobile');
                            $_SESSION['tempm'] = encrypt_me($number);
                            $o = rand(0,512348);
                            $sms = 'OTP for verfication is : '.$o;
                            $_SESSION['2sv'] = encrypt_me($o);
                            $this->SMS_Model->send_sms($number, "2step Verification SMS", $sms,0);
                            $this->session->set_flashdata("l-success","OTP has been sent for 2stepVerification.");
                            redirect('V2stepverification?r='.base64_encode('admin').'&isv='.base64_encode('yes'));
                        }else{
                            $this->goNormal('admin');
                        }
                    }else{
                       $is = $this->Agent_Model->login_validate($_POST['username'], $password);
                       if($is){ 
                           $this->goNormal('other', $is);
                       }else{
                           $this->session->set_flashdata("l-error","User doesn't exist.");
                       }
                    }
                }else if(!empty($email)){
                   $is = validate_login_email($email, $password);
                   if($is){
                        if($is2step==='yes'){
                            $number = get_config_item('company_mobile');
                            $_SESSION['tempm'] = encrypt_me($number);
                            $o = rand(0,512348);
                            $sms = 'OTP for verfication is : '.$o;
                            $_SESSION['2sv'] = encrypt_me($o);
                            $this->SMS_Model->send_sms($number, "2step Verification SMS", $sms,0);
                            $this->session->set_flashdata("l-success","OTP has been sent for 2stepVerification.");
                            redirect('V2stepverification?r='.base64_encode('admin').'&isv='.base64_encode('yes'));
                        }else{
                            $this->goNormal('admin');
                        }
                   }else{
                       $is = $this->Agent_Model->login_validate($_POST['username'], $password);
                       if($is){ 
                           $this->goNormal('other', $is);
                       }else{
                           $this->session->set_flashdata("l-error","User doesn't exist.");
                       }
                   }
                }else{
                    $this->session->set_flashdata("l-error","Invalid username or email.");
                }
            }
        }else{
            $this->session->set_flashdata("l-error","Sorry, you are not allowed to login.");
        }

        if(isset($_SESSION['ref_url']) && !empty($_SESSION['ref_url'])){
            redirect(base64_decode($_SESSION['ref_url']));
        }else{
            redirect(base_url());
        }
    }
    
    public function goNormal($roll='', $is='')
    {
        if($roll=='admin')
        {
            $this->session->set_userdata('logged_in',true);
            $this->session->set_userdata('is_admin',true);
            $this->session->set_userdata('roll','admin');
            $this->session->set_userdata('login_id',encrypt_me(0));
            
            $this->Setting_Model->set_config('session_active','yes');
            $this->login_notification();
            $this->save_login($_SESSION['login_id'],get_config_item('company_email'), $_SESSION['sgen']);
        }
        if($roll!='admin')
        {
            $this->session->set_userdata('logged_in',true);
            $this->session->set_userdata('is_admin',false);
            $this->session->set_userdata('roll',$is->agent_roll);
            $this->session->set_userdata('ca', $is->client_access);
            $this->session->set_userdata('login_id',encrypt_me($is->agent_id));
            
            $this->save_login($_SESSION['login_id'],$is->agent_email,$_SESSION['sgen']);
        }
        if(isset($_SESSION['ref_url']) && !empty($_SESSION['ref_url'])){
            redirect(base64_decode($_SESSION['ref_url']));
        }else{
            redirect(base_url());
        }
    }
    
    public function V2stepverify($roll="", $is="")
    {
        $isv = isset($_POST['isv']) ? base64_decode($_POST['isv']) : '';
        if(isset($_GET['os']) && $_GET['os']=='yes' && $isv==='yes')
        {
            if(isset($_SESSION['2sv']) && !empty($_SESSION['2sv']))
            {
                $otp = isset($_POST['otp']) ? encrypt_me($_POST['otp']) : '';
                $roll = isset($_POST['roll']) ? base64_decode($_POST['roll']) : '';
                
                if($otp===$_SESSION['2sv'])
                {
                    if($roll=='admin')
                    {
                        $this->session->set_userdata('logged_in',true);
                        $this->session->set_userdata('is_admin',true);
                        $this->session->set_userdata('roll','admin');
                        $this->session->set_userdata('login_id',encrypt_me(0));
                        
                        $this->Setting_Model->set_config('session_active','yes');
                        $this->login_notification();
                        $this->save_login($_SESSION['login_id'],get_config_item('company_email'),$_SESSION['sgen']);
                    }
                    if($roll!='admin')
                    {
                        $this->session->set_userdata('logged_in',true);
                        $this->session->set_userdata('is_admin',false);
                        $this->session->set_userdata('roll',$is->agent_roll);
                        $this->session->set_userdata('ca', $is->client_access);
                        $this->session->set_userdata('login_id',encrypt_me($is->agent_id));
                        
                        $this->save_login($_SESSION['login_id'],$is->agent_email,$_SESSION['sgen']);
                    }
                    if(isset($_SESSION['ref_url']) && !empty($_SESSION['ref_url'])){
                        redirect(base64_decode($_SESSION['ref_url']));
                    }else{
                        redirect(base_url());
                    }
                }else{
                   $_SESSION['al'] = isset($_SESSION['al']) ? $_SESSION['al'] + 1 : 1;
                   $this->session->set_flashdata("l-error", "OTP doesn't match!");
                   redirect($_SERVER['HTTP_REFERER']);
                }
            }else{
                $this->session->set_flashdata("l-error", "OTP is not valid!");
                redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            if(isset($_SESSION['al']) && $_SESSION['al'] > 3){
                $this->session->set_flashdata("l-error", "Too many login attempts! Account will be lock.");
            }else{
                $this->session->set_flashdata("l-error", "Something went wrong during 2stepV.");
            }
            redirect(base_url());
        }
    }
    
    public function login_notification()
    {
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']===true)
        {
            $isNotify = get_config_item("login_notification");
            $email = get_config_item('company_email');
            $link = base_url('home/login_attempt?token='.base64_encode($email."_".$_SESSION['sgen']).'&verify=true');
            $m = get_config_item('company_mobile');
            $msg = 'New Login attempt. Take action if it was no you.';
            $msg .= $link;
            
            $url = 'http://ip-api.com/php/'.$_SERVER['REMOTE_ADDR'];
            $geodata = @file_get_contents($url);
            $pd = @unserialize($geodata);
            $coord = $pd['lat']."_".$pd['lon'];
            
            $is = $this->Setting_Model->is_same_place($coord, $email);
            
            if(!$is && $isNotify==='yes'){
                $this->SMS_Model->send_sms($m, 'Login Attempt', $msg, 0);
            }
        }
    }
    
    public function _admin_dashboard()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Dashboard";
        $hdata['page_type'] = "dashboard";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Dashboard";
        unset($_SESSION['2sv']);
        unset($_SESSION['tempm']);
        
        $data['invoice_awaiting'] = $this->Invoice_Model->get_invoice_not_paid();
        $data['yearly_sales'] = $this->Lead_Model->get_won_sales('year');
        $data['monthly_sales'] = $this->Lead_Model->get_won_sales('month');
        $data['miss_oppertunity'] = $this->Lead_Model->get_missed_ones();
        $data['bemp'] = $this->Client_Model->get_best_employee();
        $data['bvservice'] = $this->Product_Model->get_best_service();
        $data['revenue'] = $this->Client_Model->get_revenue_of_year();
        $data['isource'] = $this->Client_Model->get_income_source();
        $data['task'] = $this->Task_Model->get_all('dashboard');
        $data['sms_balance'] = $this->SMS_Model->get_sms_balance();
        
        $feature = @file_get_contents(API."feature");
        $feature = json_decode($feature);
        if($feature->status=='success'){
            $feature = $feature->data;
        }else{
            $feature = '';
        }
        $data['feature'] = $feature;
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/dashboard", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function cinfo()
    {
        echo get_info_of('lead','assign_to_agent','umesh.yadav@gmail.com','email_id');
    }
    
    public function lead()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        $hdata['title'] = "Lead";
        $hdata['page_type'] = "lead";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Lead";
        
        $data['all_leads'] = $this->Lead_Model->get_all_leads();
        $data['isf'] = 'no';
        $hdata['profile'] = $this->Agent_Model->get_profile();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/lead", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function followup_leads()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        $hdata['title'] = "Followup Leads";
        $hdata['page_type'] = "flead";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Followup Lead";
        $hdata['profile'] = $this->Agent_Model->get_profile();
        
        $data['all_leads'] = $this->Lead_Model->get_all_leads();
        
        $data['isf'] = 'yes';
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/lead", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function add_lead()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        $hdata['title'] = "Add Lead";
        $hdata['page_type'] = "addlead";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."lead'>Lead</a> / Add Lead";
        $hdata['profile'] = $this->Agent_Model->get_profile();
        
        $id = isset($_GET['existing']) ? $_GET['existing'] : '';
        $data['all_details'] = get_fields(1);
        $data['sections'] = get_sections();
        $data['lead'] = $this->Client_Model->get_client_by_id($id);
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/add_lead", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    //add_issue_category.php
    public function add_issue_category()
    {
        $this->Auth->_check_Aauth();
        
        $hdata['title'] = "Add Site Issue Category";
        $hdata['page_type'] = "addlead";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."burning-report'>Site Issues</a> / Add Site Issue Category";
        
        $data = [];
        
        if(isset($_GET['edit']) && !empty($_GET['edit']))
        {
            $data['category'] = $this->Project_Model->get_site_issue_category($_GET['edit']);
            if($data['category']!=''){
                $hdata['title'] = 'Site Issue Category';
                $hdata['track'] = 'Update Site Issue Category';
            }
        }

        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/add_issue_category", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    //site_issue_category
    public function site_issue_category()
    {
        $this->Auth->_check_Aauth();
        
        $hdata['title'] = "Site Issue Category";
        $hdata['page_type'] = "addlead";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Site Issue Category";
        
        $data['categories'] = $this->Project_Model->get_all_site_issue_category();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/site_issue_category", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function import_lead()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        $hdata['title'] = "Import Lead";
        $hdata['page_type'] = "importlead";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."lead'>Lead</a> / Import Lead";
        $hdata['profile'] = $this->Agent_Model->get_profile();
        
        $data['groups'] = $this->Lead_Model->get_groups();
        if(isset($_GET['g']) && isset($_GET['edit']) && !empty($_GET['edit']))
        {
            $data['sg'] = $this->Lead_Model->get_groups($_GET['edit']);
        }
        $data['fields'] = get_fields('map');
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/import-lead", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function map_file_to()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        
        if(!isset($_SESSION['filecols']) && empty($_SESSION['filecols']))
        {
           redirect('import-lead'); 
        }
        
        $hdata['title'] = "Import Lead";
        $hdata['page_type'] = "importlead";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."lead'>Lead</a> / Import Lead";
        
        $data['cols'] = $_SESSION['filecols'];
        $data['fields'] = get_fields('map');
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/map_file", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function followup()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        $hdata['title'] = "Followup";
        $hdata['page_type'] = "followup";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."followup-leads'>Followup Lead</a> / Followup";
        
        $id = isset($_GET['lead']) ? $_GET['lead'] : '';
        $data['all_details'] = get_fields(1);
        $data['sections'] = get_sections();
        $data['lead'] = $this->Lead_Model->get_lead_by_id($id);
        $data['lead_docs'] = $this->Lead_Model->get_lead_docs_id($id);
        $data['followup'] = $this->Lead_Model->get_all_followups($id);
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/followup", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function setting()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Setting";
        $hdata['page_type'] = "setting";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Setting";
        
        $data['states'] = get_states();
        $data['countries'] = get_countries();
        $data['sections'] = get_sections();
        $data['modules'] = get_select_modules();
        $data['lead_source'] = get_lead_source();
        $data['service'] = get_service();
        $data['status'] = get_status();
        $data['lost_reason'] = get_lost_reason();
        $data['expense_category'] = $this->db->order_by("name", "asc")->get("crm_expense_category")->result();
        $data['task_status'] = get_module_values('task_status');
        $data['agent'] = $this->Agent_Model->get_all();
        $data['bfiles'] = $this->get_backup_files();
        $data['lhistory'] = $this->Setting_Model->get_lhistory(get_config_item('company_email'));
        $data['sms_balance'] = $this->SMS_Model->get_sms_balance();
        $data['etemplates'] = $this->Setting_Model->get_etemplates();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/setting", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function _user_dashboard()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        $hdata['title'] = "Dashboard";
        $hdata['page_type'] = "dashboard";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Dashboard";
        
        $hdata['profile'] = $this->Agent_Model->get_profile();
        $data['invoice_awaiting'] = $this->Invoice_Model->get_invoice_not_paid();
        $data['yearly_sales'] = $this->Lead_Model->get_won_sales('year');
        $data['monthly_sales'] = $this->Lead_Model->get_won_sales('month');
        $data['miss_oppertunity'] = $this->Lead_Model->get_missed_ones();
        $data['bvservice'] = $this->Product_Model->get_best_service();
        $data['revenue'] = $this->Client_Model->get_revenue_of_year();
        $data['isource'] = $this->Client_Model->get_income_source();
        $data['task'] = $this->Task_Model->get_all();
        
        $feature = @file_get_contents(API."feature");
        $feature = json_decode($feature);
        if($feature->status=='success'){
            $feature = $feature->data;
        }else{
            $feature = '';
        }
        $data['feature'] = $feature;
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/dashboard", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function profile(){
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        $hdata['title'] = "Profile";
        $hdata['page_type'] = "profile";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Profile";
        
        $data['profile'] = $this->Agent_Model->get_profile();
        $hdata['profile'] = $data['profile'];
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/profile", $data);
        $this->load->view("includes/global_footer", $hdata);
    }

    public function product_and_services()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Product & Services";
        $hdata['page_type'] = "product-and-services";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Product and Services";
        
        $data['products'] = $this->Product_Model->get_all();
        if(isset($_GET['me']) && !empty($_GET['me']))
        {
            $data['product'] = $this->Product_Model->get_detail_by_id($_GET['me']);
        }
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/product_and_services", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function clients()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        $hdata['title'] = "Clients";
        $hdata['page_type'] = "clients";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Clients";
        $hdata['profile'] = $this->Agent_Model->get_profile();
        
        $data['clients'] = $this->Client_Model->get_all();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/clients", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function vendors()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        $hdata['title'] = "Vendors";
        $hdata['page_type'] = "vendors";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Vendors";
        $hdata['profile'] = $this->Agent_Model->get_profile();
        
        $data['vendors'] = $this->Vendor_Model->get_all();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/vendors", $data);
        $this->load->view("includes/global_footer", $hdata);
    }

    
    public function add_vendor()
    {
        $hdata['title'] = "Add Vendor";
        $hdata['page_type'] = "add-vendor";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."vendors'>Vendors</a> / Add Vendor";
        $hdata['profile'] = $this->Agent_Model->get_profile();
        
        if(isset($_GET['edit']) && !empty($_GET['edit']))
        {
            $data['vendor'] = $this->Vendor_Model->get_vendor_by_id($_GET['edit']);
            if($data['vendor']!=''){
                $hdata['title'] = isset($data['vendor']->vendor_name) ? $data['vendor']->vendor_name : 'Add Vendor';
                $hdata['track'] = "<a href='".base_url()."vendors'>Vendors</a> / ".$data['vendor']->vendor_name;
            }
            
        }else{
            $data = [];
        }
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/add_vendor", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function add_client()
    {
        $hdata['title'] = "Add Client";
        $hdata['page_type'] = "add-client";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."clients'>Clients</a> / Add Client";
        $hdata['profile'] = $this->Agent_Model->get_profile();
        
        if(isset($_GET['edit']) && !empty($_GET['edit']))
        {
            $data['client'] = $this->Client_Model->get_client_by_id($_GET['edit']);
            if($data['client']!=''){
                $hdata['title'] = isset($data['client']->client_name) ? $data['client']->client_name : 'Add Client';
                $hdata['track'] = "<a href='".base_url()."clients'>Clients</a> / ".$data['client']->client_name;
            }
            $data['invoices'] = $this->Invoice_Model->get_all_invoices($_GET['edit']);
            $data['products'] = $this->Client_Model->get_all_products($_GET['edit']);
            $data['emails'] = $this->Client_Model->get_client_emails($_GET['edit']);
            $data['sms'] = $this->Client_Model->get_client_sms($_GET['edit']);
            $data['etemplates'] = $this->Setting_Model->get_etemplates();
        }else{
            $data = [];
        }
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/add_client", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function projects()
    {  
        $hdata['title'] = "All Projects";
        $hdata['page_type'] = "projects"; 
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."clients'>Clients</a> / Projects";
        
        $data['projects'] = $this->Project_Model->get_all();
        $data['clients'] = $this->Client_Model->get_all();
            
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/projects", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function importExpense()
    {
        $hdata['title'] = "Import Expense";
        $hdata['page_type'] = "import-expense"; 
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Import Expenses";
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/import-expense");
        $this->load->view("includes/global_footer", $hdata);
    }
    
    function burning_report()
    {
        $hdata['title'] = "Site Issues";
        $hdata['page_type'] = "burning-report"; 
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."clients'>Clients</a> / Site Issues";
        
        $data['burning_reports'] = $this->Project_Model->get_all_burning_report($this->Auth->_auth_id());
        $data['clients'] = $this->Client_Model->get_all();
        $data['agents'] = $this->Agent_Model->get_all();
        $data['projects'] = $this->Project_Model->get_all();
        $data['categories'] = $this->Project_Model->get_all_site_issue_category();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/burning_report", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function petty_cash()
    {  
        $hdata['title'] = "Cash Flow";
        $hdata['page_type'] = "petty_cash"; 
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Cash Flow";
        
        $data['agents'] = $this->Agent_Model->get_all();
        $data['petty_cash'] = $this->Project_Model->get_all_petty_cash($this->Auth->_auth_id());
            
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/petty_cash", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function update_closing_balance()
    {
        $date = isset($_GET['date']) && !empty($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : date("Y-m-d");
        $this->Project_Model->updateClosingBal($date);
        
        header("Location:". $_SERVER['HTTP_REFERER']);
    }
    
    public function add_project()
    {
        $hdata['title'] = "Add Project";
        $hdata['page_type'] = "add-project";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."clients'>Clients</a> / Add Project";
        
        if(isset($_GET['edit']) && !empty($_GET['edit']))
        {
            $data['project'] = $this->Project_Model->get_project($_GET['edit']);
            if($data['project']!=''){
                $hdata['title'] = isset($data['project']->project_name) ? $data['project']->project_name : 'Add Project';
                $hdata['track'] = "<a href='".base_url()."clients'>Clients</a> / Projects / ".$data['project']->project_name;
            }
        }
        
        $data['clients'] = $this->Client_Model->get_all();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/add_project", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function add_burning_report()
    {
        $hdata['title'] = "Add Site Issues";
        $hdata['page_type'] = "add-burning-report";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."clients'>Clients</a> / Add Site Issues";
        
        if(isset($_GET['edit']) && !empty($_GET['edit']))
        {
            $data['burning_report'] = $this->Project_Model->get_burning_report($_GET['edit']);
            if($data['burning_report']!=''){
                $hdata['title'] = 'Burning Report';
                $hdata['track'] = 'Update Burning Report';
            }
        }
        
        $data['clients'] = $this->Client_Model->get_all();
        $data['agents'] = $this->Agent_Model->get_all();
        $data['projects'] = json_encode($this->Project_Model->get_all(true));
        $data['categories'] = $this->Project_Model->get_all_site_issue_category();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/add_burning_report", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function add_aaujar()
    {
        $hdata['title'] = "Add Tool";
        $hdata['page_type'] = "add-aaujar";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."agents'>Business Associates</a> / Add Tool";
        
        if(isset($_GET['edit']) && !empty($_GET['edit']))
        {
            $data['aaujar'] = $this->Project_Model->get_aaujar($_GET['edit']);
            if($data['aaujar']!=''){
                $hdata['title'] = 'Tool';
                $hdata['track'] = 'Update Tool';
            }
        }
        
        $data['clients'] = $this->Client_Model->get_all();
        $data['agents'] = $this->Agent_Model->get_all();
        $data['auzaar_names'] = $this->Project_Model->get_all_aaujar_names();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/add_aaujar", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function verify_aaujar()
    {
        $hdata['title'] = "Add Tool";
        $hdata['page_type'] = "add-aaujar";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."auzaar'>Tool</a> / Verify Tool";
        
        $data['agents'] = $this->Agent_Model->get_all();
        $data['auzaar_names'] = $this->Project_Model->get_all_aaujar_names();
        
        if(!empty($_GET['agent_id']) && !empty($_GET['auzaar'])) {
            $data['tool'] = $this->db->where("tool_name", $_GET['auzaar'])
                ->where("agent_id", $_GET['agent_id'])->where("DATE(created)", date('Y-m-d'))->get("crm_aaujar")->row() ?? '';
        }
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/verify_tool", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function add_petty_cash()
    {
        $hdata['title'] = "Add Cash Flow";
        $hdata['page_type'] = "add-petty-cash";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Add Cash Flow";
        
        if(isset($_GET['edit']) && !empty($_GET['edit']))
        {
            $data['petty_cash'] = $this->Project_Model->get_petty_cash($_GET['edit']);
            if($data['petty_cash']!=''){
                $hdata['title'] = "Cash Flow Update";
                $hdata['track'] = "Cash Flow Update";
            }
        }
        
        $data['agents'] = $this->Agent_Model->get_all();
        $date = isset($_GET['date']) && !empty($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : date('Y-m-d');
        $data['petty'] = $this->Project_Model->getPetty($this->Auth->_auth_id() != 0 ? $this->Auth->_auth_id() : ($_GET['agent'] ?? 0), $date);
       
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/add_petty_cash", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function print_work_status()
    {
        $hdata['title'] = "Tomorrow's Action Plan Clients";
        $hdata['page_type'] = "print-work-status";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."clients'>Clients</a> / Work Status";
        
        $data['projects'] = $this->Project_Model->get_all(true);
        $data['active_projects'] = $this->Project_Model->get_all_active();
        $data['agents'] = $this->Agent_Model->get_all();
        $data['clients'] = $this->Client_Model->get_all();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/print_work_status", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function print_work_status_lead()
    {
        $hdata['title'] = "Tomorrow's Action Plan Leads";
        $hdata['page_type'] = "print-work-status-lead";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."lead'>Leads</a> / Work Status";
        
        $data['active_projects'] = $this->Project_Model->get_all_active_lead();
        $data['agents'] = $this->Agent_Model->get_all();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/print_work_status_lead", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function expenses()
    {  
        $hdata['title'] = "All Expenses";
        $hdata['page_type'] = "expenses"; 
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."clients'>Clients</a> / <a href='".base_url()."projects'>Projects</a> / Expenses";
        
        $data['expenses'] = $this->Project_Expense_Model->get_all($this->Auth->_auth_id());
        $data['projects'] = $this->Project_Model->get_all();
        $data['agents'] = $this->Agent_Model->get_all();
        $data['clients'] = $this->Client_Model->get_all();
        $data['categories'] = $this->Project_Expense_Model->get_all_category();
            
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/expenses", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function aaujar()
    {
        $hdata['title'] = "Tools";
        $hdata['page_type'] = "Tool"; 
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."agents'>Business Associates</a> / Tool";
        
        $data['auzaars'] = $this->Project_Model->get_all_aaujars($this->Auth->_auth_id());
        $data['agents'] = $this->Agent_Model->get_all();
        $data['auzaar_names'] = $this->Project_Model->get_all_aaujar_names();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/aaujar", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function work_status()
    {
        $hdata['title'] = "Work Status";
        $hdata['page_type'] = "work-status"; 
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."clients'>Clients</a> / <a href='".base_url()."projects'>Projects</a> / Work Status";
        
        $data['work_status'] = $this->Project_Model->get_all_work_status($this->Auth->_auth_id(), true);
        $data['projects'] = $this->Project_Model->get_all();
        $data['agents'] = $this->Agent_Model->get_all();
        $data['clients'] = $this->Client_Model->get_all();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/work_status", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function client_payments()
    {
        $hdata['title'] = "Client Payments";
        $hdata['page_type'] = "client-payments"; 
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."clients'>Clients</a> / Payments";
        
        $data['payments'] = $this->Project_Model->get_all_client_payments($this->Auth->_auth_id());
        $data['projects'] = $this->Project_Model->get_all();
        $data['clients'] = $this->Client_Model->get_all();
            
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/client_payments", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function add_expense()
    {
        $hdata['title'] = "Add Expenses";
        $hdata['page_type'] = "add-expense";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."projects'>Projects</a> / Add Expense";
        
        if(isset($_GET['edit']) && !empty($_GET['edit']))
        {
            $data['expense'] = $this->Project_Expense_Model->get_project_expense($_GET['edit']);
            if($data['expense']!=''){
                $hdata['title'] = isset($data['expense']->project_name) ? $data['expense']->project_name : 'Add Expense';
                $hdata['track'] = "<a href='".base_url()."projects'>Projects</a> / ".$data['expense']->project_name;
            }
        }
        
        $data['agents'] = $this->Agent_Model->get_all();
        $data['clients'] = $this->Client_Model->get_all();
        $data['categories'] = $this->Project_Expense_Model->get_all_category();
        $data['projects'] = json_encode($this->Project_Model->get_all(true));
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/add_expense", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function add_payment()
    {
        $hdata['title'] = "Add Client Payment";
        $hdata['page_type'] = "add-payment";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."projects'>Projects</a> / Add Client Payment";
        
        if(isset($_GET['edit']) && !empty($_GET['edit']))
        {
            $data['payment'] = $this->Project_Model->get_client_payment($_GET['edit']);
            if($data['payment']!=''){
                $hdata['title'] = isset($data['payment']->project_name) ? $data['payment']->project_name : 'Add Client Payment';
                $hdata['track'] = "<a href='".base_url()."projects'>Projects</a> / ".$data['payment']->project_name;
            }
        }
        
        $data['clients'] = $this->Client_Model->get_all();
        $data['projects'] = json_encode($this->Project_Model->get_all(true));
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/add_payment", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function add_work_status()
    {
        $hdata['title'] = "Add Work Status";
        $hdata['page_type'] = "add-work-status";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."projects'>Projects</a> / Add Work Status";
        
        if(isset($_GET['edit']) && !empty($_GET['edit']))
        {
            $data['work_status'] = $this->Project_Model->get_work_status($_GET['edit']);
            if($data['work_status']!=''){
                $hdata['title'] = isset($data['work_status']->project_name) ? $data['work_status']->project_name : 'Add Work Status';
                $hdata['track'] = "<a href='".base_url()."projects'>Projects</a> / ".$data['work_status']->project_name;
            }
        }
        
        $data['clients'] = $this->Client_Model->get_all();
        $data['agents'] = $this->Agent_Model->get_all();
        $data['projects'] = json_encode($this->Project_Model->get_all(true));
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/add_work_status", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function create_invoice()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        $hdata['title'] = "Create Invoice";
        $hdata['page_type'] = "create-invoice";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Create Invoice";
        $hdata['profile'] = $this->Agent_Model->get_profile();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/create_invoice");
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function edit_invoice()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        $hdata['title'] = "Edit Invoice";
        $hdata['page_type'] = "create-invoice";
        $hdata['rurl'] = base_url('resource/');
        if(isset($_GET['isc']) && !empty($_GET['isc'])){
           $hdata['track'] = "<a href='".$_SERVER['HTTP_REFERER']."'>Summary</a> / <a href='".base_url('clients')."'>Clients</a> /
             <a href='".$_SERVER['HTTP_REFERER']."'>".get_client_info(base64_decode($_GET['isc']),'client_name')."</a> / Edit Invoice";
            
        }else{
           $hdata['track'] = "<a href='".base_url()."list-invoice'>List Invoice</a> / Edit Invoice";
        }
        
        $data = [];
        if(isset($_GET['edit']) && !empty($_GET['edit']))
        {
            $data['i'] = $this->Invoice_Model->get_invoice_by_id($_GET['edit']);
            
            //check if payment is not initiated 
            if($data['i']->paid_amount != 0){
                $this->session->set_flashdata("error", "Invoice is not editable.");
                redirect($_SERVER['HTTP_REFERER']);
            }
            $data['products'] = $this->Invoice_Model->get_products_of_invoice($_GET['edit']);
            $data['cp'] = $this->Invoice_Model->get_cproducts_of_invoice($_GET['edit']);
            $data['txn'] = $this->Invoice_Model->get_txn($_GET['edit']);
        }
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/create_invoice", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function list_invoice()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        $hdata['title'] = "List Invoice";
        $hdata['page_type'] = "list-invoice";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "List Invoice";
        $hdata['profile'] = $this->Agent_Model->get_profile();
        
        $data['invoices'] = $this->Invoice_Model->get_all_invoices();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/list_invoice", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function sms()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "SMS";
        $hdata['page_type'] = "sms";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "SMS";
        
        $api_url = "http://themenick.in/urgent/systemvalidator/home/api/sms";
        $sms = @file_get_contents($api_url);
        $data['sms_balance'] = $this->SMS_Model->get_sms_balance();
        $data['sms_this_month'] = $this->SMS_Model->sms_sent_this_month();
        $data['qtys'] = array_reverse(json_decode($sms)->data);
        
        if(isset($_GET['pid'])){
            if(isset($_GET['s']) && decrypt_me($_GET['s'])=='success'){
                $this->session->set_flashdata("success","Payment is successfull.<br/> Payment id : ".decrypt_me($_GET['pid']));
            }else{
                $this->session->set_flashdata("error","Payment is failed. <br/> Payment id : ".decrypt_me($_GET['pid']));
            }
            $id = $this->SMS_Model->add_sms_credit();
            $id ? redirect('sms-credit') : redirect('sms');
        }
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/sms", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function sent_sms()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Sent SMS";
        $hdata['page_type'] = "sent-sms";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."sms'>SMS</a> / Sent SMS";
        
        $data['sms'] = $this->SMS_Model->get_all_sms();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/sent-sms", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function sms_credit()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "SMS Credit";
        $hdata['page_type'] = "sms-credit";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."sms'>SMS</a> / SMS Credit";
        
        $data['sms_credit'] = $this->SMS_Model->get_credit_history();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/sms-credit", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function resentOTP()
    {
        $res = array("status"=>0, "data"=>"failed");
        if(isset($_POST['type']) && !empty($_POST['type']) 
        && isset($_SESSION['smsL']) && $_SESSION['smsL'] <= 3)
        {
            if($type=='2sv')
            {
                $mob = isset($_SESSION['tempm']) ? $_SESSION['tempm'] : 0;
                if($mob !== 0)
                {
                   $otp = rand(0, 512343);
                   $msg = 'New OTP for verification is :'.$otp;
                   $is = $this->SMS_Model->send_sms($mob, '2step Verification SMS', $msg, 0); 
                   if($is)
                   {
                       $_SESSION['smsL'] = isset($_SESSION['smsL']) ? $_SESSION['smsL'] + 1 : 1;
                       $res['status'] = 1;
                       $res['data'] = "success";
                   }
                }
            }
        }
        print_r(json_encode($res));
    }
    
    public function login_attempt()
    {
        $hdata['title'] = "Verify Login Attempt";
        $hdata['page_type'] = "login";
        $hdata['rurl'] = base_url('resource/');
        
        $token = isset($_GET['token']) ? $_GET['token'] : '';
        $token = explode("_",base64_decode($token));
        
        $data['ldetails'] = $this->Setting_Model->get_ld($token);
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("modules/home/login_attempt", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function save_login($loginid, $email, $s)
    {
        if(!empty($loginid) && !empty($email))
        {
            $url = 'http://ip-api.com/php/'.$_SERVER['REMOTE_ADDR'];
            $geodata = @file_get_contents($url);
            $pd = @unserialize($geodata);
            
            $coord = $pd['lat']."_".$pd['lon'];
            $data = array(
              "session_id" => $s,
              "login_id"   => $loginid,
              "login_email"=> $email,
              "login_ip"   => $_SERVER['REMOTE_ADDR'],
              "login_place" => $geodata,
              "login_coord" => $coord,
              "login_time" => date("Y-m-d H:i:s"),
              "browser_used" => $this->agent->browser(),
              "platform" => $this->agent->platform()
            );   
            
            $this->Setting_Model->save_login($data);
        }
    }
    
    public function block($token)
    {
        $token = explode("_",base64_decode($token));
        if(isset($token[0]) && $token[0]===get_config_item('company_email'))
        {
            $this->Setting_Model->set_attempt_action($token[0], $token[1],'no');
            $this->Setting_Model->set_config('session_active','block');
            redirect(base_url());
        }else{
            redirect("HTTP_REFERER");
        }
    }
    
    public function ignore($token)
    {
        $token = explode("_",base64_decode($token));
        if(isset($token[0]) && $token[0]===get_config_item('company_email'))
        {
            $this->Setting_Model->set_attempt_action($token[0], $token[1],'yes');
            redirect(base_url());
        }else{
            redirect("HTTP_REFERER");
        }
    }
    
    public function dump_database(){
        $this->Auth->_check_Aauth();
        $res = array("status"=>0, "data"=>"failed");
        
        include_once(FCPATH . '/application/third_party/mysqldump-php-master/src/Ifsnop/Mysqldump/Mysqldump.php');
        $dump = new Ifsnop\Mysqldump\Mysqldump('mysql:host=localhost;dbname='.$this->db->database, $this->db->username, $this->db->password);
        $f = 'dbbackup_'.date("d_M_Y_H_i_s").'.sql';
        $file_name = FCPATH.'resource/dump_file/'.$f;
        $status = $dump->start($file_name);
        
        if($status=='')
        {
            $res['status'] = 1;
            $res['data'] = "success";
            $res['f'] = base64_encode($f);
        }
        print_r(json_encode($res));
    }
    
    public function get_backup_files()
    {   
        $this->Auth->_check_Aauth();
        $log_directory = FCPATH.'resource/dump_file/';

        $results_array = array();
        if (is_dir($log_directory))
        {
            if ($handle = opendir($log_directory))
            {
                while(($file = readdir($handle)) !== FALSE)
                {
                    if($file != '..' && $file != '.' ){
                        $results_array[] = $file;
                    }
                }
                closedir($handle);
            }
        }
        return $results_array;
    }
    
    public function remove_bckupfile()
    {
        $this->Auth->_check_Aauth();
        $res = array("status"=>0, "data"=>"failed");
        if(isset($_POST['remove']) && $_POST['remove'])
        {
            $file = FCPATH.'resource/dump_file/'.base64_decode($_POST['file']);
            if(file_exists($file))
            {
                unlink($file);
                $res['status'] = 1;
                $res['data'] = "success";
            }
        }
        print_r(json_encode($res));
    }
    
    public function sessionOut()
    {
        $this->Auth->_check_Aauth();
        $res = array("status"=>0, "data"=>"failed");
        if(isset($_POST['action']) && $_POST['action'])
        {
            $is = $this->Setting_Model->set_config('session_active','block');
            if($is)
            {
                $res['status'] = 1;
                $res['data'] = "success";
            }
        }
        print_r(json_encode($res));
    }
    
    public function download_file()
    {
        $this->Auth->_check_Aauth();
        
        if(isset($_GET["file"])){
        $file = base64_decode($_GET["file"]);
        if(preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i', $file)){
            
            $filepath = FCPATH."resource/dump_file/" . $file;
            if(file_exists($filepath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filepath));
                flush(); // Flush system output buffer
                readfile($filepath);
            } else {
                echo "Error: File type";
            }
        } else {
            die("Invalid file name!");
        }
        }
    }
    
    public function clearLoginHistory()
    {
        if(isset($_GET['e']) && !empty($_GET['e']))
        {
            $this->Setting_Model->clearLH($_GET['e']);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function setting_access()
    {
        if(isset($_POST['actype']) && !empty($_POST['actype']))
        {
            if(base64_decode($_POST['actype']) == '/setting')
            {
                if(md5($_POST['password'])==get_config_item('admin_password'))
                {
                    $_SESSION['setting_access'] = true;
                    redirect('/setting');
                }else{
                    $this->session->set_flashdata('l-error',"Password is not valid.");
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        }else{
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function report()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Report";
        $hdata['page_type'] = "report";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "Report";
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/report");
        $this->load->view("includes/global_footer", $hdata);
    }
    
    
    public function importDB()
    {
        $res = array("status"=>0,"data"=>"failed");
        if(isset($_POST['importdb']) && $_POST['importdb']==true)
        {
            $conn =new mysqli('localhost', $this->db->username, $this->db->password , $this->db->database);
            $query = '';
            $sqlScript = file(FCPATH.'resource/dump_file/'.base64_decode($_POST['file']));
            
            $this->Setting_Model->drop_tables();
            
            foreach ($sqlScript as $line)	{
            	
            	$startWith = substr(trim($line), 0 ,2);
            	$endWith = substr(trim($line), -1 ,1);
            	
            	if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
            		continue;
            	}
            		
            	$query = $query . $line;
            	if ($endWith == ';') {
            		mysqli_query($conn,$query) or die('<div class="error-response sql-import-response">Problem in executing the SQL query <b>' . $query. '</b></div>');
            		$query= '';		
            	}
            }
            
            $res['status'] = 1;
            $res['data'] = "success";
        }
        
        print_r(json_encode($res));
    }
    
    public function event()
    {
        $events = $this->Lead_Model->get_events();
        print_r(($events));
    }
    
    public function test_smtp()
    {
        $res = array("status"=>0,"data"=>"failed");
        if(isset($_POST['email']) && !empty($_POST['email']))
        {
            $message = '
                Testing for SMTP Connection is successfully completed.
            ';
            
            
            $is = $this->Email_Model->send_email(
                get_config_item('support_email'),
                $_POST['email'],
                get_config_item("company_name"),
                "SMTP Mail Test",
                $message,
                "","","","smtp"
                );
            if($is)
            {
                $res['status'] = 1;
                $res['data'] = "success";
            }
        }
        
        print_r(json_encode($res));
    }
   
    public function compose_new_email()
    {
        if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
            $this->Auth->_check_Aauth();
        }else{
            $this->Auth->_check_auth();
        }
        
        if(isset($_GET['t']) && $_GET['t']!='compose'){
            $data['sub'] = get_info_of('email_template','subject',$_GET['t'],'email_template_id');
            $data['content'] = get_info_of('email_template','content',$_GET['t'],'email_template_id');
            $hdata['title'] = "Email Template";
            $hdata['page_type'] = "email-template";
            $hdata['track'] = "<a href='".$_SERVER['HTTP_REFERER']."'>Summary</a> / Email Template";
        }else{
            $data['sub'] = '';
            $data['content'] = '';
            $hdata['title'] = "Compose New Email";
            $hdata['page_type'] = "compose-new-email";
            $hdata['track'] = "<a href='".$_SERVER['HTTP_REFERER']."'>Summary</a> / Compose New Email";
        }
        
        $hdata['rurl'] = base_url('resource/');
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/compose_new_email", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function forgotpass()
    {
        $hdata['title'] = "Forgot Password";
        $hdata['page_type'] = "login";
        $hdata['rurl'] = base_url('resource/');
        $hdata['amp'] = $hdata['canonical'] = base_url();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("modules/home/forgot_password");
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function password_recover()
    {
        $hdata['title'] = "Recover Your Password";
        $hdata['page_type'] = "login";
        $hdata['rurl'] = base_url('resource/');
        $hdata['amp'] = $hdata['canonical'] = base_url();
        if(isset($_GET['token']) && $_GET['token']===base64_encode($_SERVER['SERVER_ADDR'].get_config_item('ott'))){
            $this->load->view("includes/global_header", $hdata);
            $this->load->view("modules/home/new_password");
            $this->load->view("includes/global_footer", $hdata);
        }else{
            die("#Token has been expired.");
        }
    }
    
    public function forgot_password()
    {
        if(isset($_GET['ref']) && base64_decode($_GET['ref'])===$_SERVER['SERVER_ADDR'])
        {
            $is = false;
            $data = isset($_POST['username']) ? $_POST['username'] : '';
            if(filter_var($data, FILTER_VALIDATE_EMAIL))
            {
                $is = ($data==get_config_item('company_email')) ? true : false;   
            }else{
                $is = ($data==get_config_item('admin_username')) ? true : false;
            }
            
            if($is)
            {
                $this->Setting_Model->set_config('ott',encrypt_me($_SERVER['REMOTE_ADDR'].rand(0,100)));
                $link = base_url('home/password_recover?token='.base64_encode($_SERVER['SERVER_ADDR'].get_config_item('ott')));
                $message = '
                <div style="padding:10px;border:1px solid lightgray;">
                <h3>You requested to recover your password!</h3>
                <br/>
                <p>Below is a link to recover your password please click on it :- <br>
                <a href="'.$link.'">Click me to recover password</a>
                </p>
                <br/><br/>
                <span>Token is valid for one time.</span>
                </div>
                ';
                $this->Email_Model->send_email(
                get_config_item('support_email'),
                get_config_item('company_email'),
                get_config_item("company_name"),
                "Password Recovery",
                $message,
                "","",""    
                );
                
                $this->session->set_flashdata("success", "Password recovery link has been sent to your email.");
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->session->set_flashdata("error", "Account doesn't exist with given detail.");
                redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            die("#Can't proceed this request.");
        }
    }
    
    public function forgot_password_recover()
    {
        if(isset($_GET['token']) && $_GET['token']===base64_encode($_SERVER['SERVER_ADDR'].get_config_item('ott')))
        {
            $np = isset($_POST['newpass']) ? $_POST['newpass'] : '';
            $cp = isset($_POST['cpass']) ? $_POST['cpass'] : '';
            
            if($np !== $cp)
            {
               $this->session->set_flashdata("error", "New password and Confirm password is not the same.");
               redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->Setting_Model->set_config("admin_password", md5($np));
                $this->Setting_Model->set_config("admin_raw_password", encrypt_me($np));
                $this->Setting_Model->set_config("ott", '');
                $this->session->set_flashdata("success", "Password has been recoverd successfully.");
                redirect(base_url());
            }
             
        }else{
            die("#Token has been expired.");
        }
    }
    
    public function getbesclient()
    {
        $res = array("status"=>0,"data"=>"failed");
        if(isset($_POST['d']) && !empty($_POST['d']))
        {
            $res['status'] = 1;
            $res['data'] = "success";
            $res['d'] = $this->Client_Model->get_best_employee($_POST['d']);
        }
        print_r(json_encode($res));
    }
    
    public function getbestservice()
    {
        $res = array("status"=>0,"data"=>"failed");
        if(isset($_POST['d']) && !empty($_POST['d']))
        {
            $res['status'] = 1;
            $res['data'] = "success";
            $res['d'] = $this->Product_Model->get_best_service($_POST['d']);
        }
        print_r(json_encode($res));
    }
    
    public function razorpay_callback()
    {
        $this->load->view("modules/home/razorpay_callback");
    }
    
    public function pay_with_razorpay($inv='/')
    {
        if(isset($inv) && !empty($inv))
        {
            $invoice_id = decrypt_me($inv);
            $data['title'] = "Payment Portal";
            $data['invoice'] = $this->Invoice_Model->get_invoice_by_id(base64_encode($invoice_id));
            
            $this->load->view("modules/home/razorpay_payment", $data);
        }
    }
    
    public function razorpay_success()
    { 
        if(isset($_SESSION['rpay']['payment']) &&
         $_SESSION['rpay']['payment']=='success'
         && $_SESSION['rpay']['amount']!=0)
         {
            $invoice_no = "";
            if(isset($_SESSION['rpay']['invoice_gid']) && empty($_SESSION['rpay']['invoice_gid'])){
                $inv_prefix = get_config_item('invoice_prefix');
                $inv = get_last_invoice_id();
                
                if($inv!='')
                {
                    $int = intval(filter_var($inv, FILTER_SANITIZE_NUMBER_INT));
                    $int = intval($int) + 1;
                    $invoice_no = $inv_prefix.$int;
                }else{
                    $invoice_no = $inv_prefix.get_config_item('invoice_start_no');
                }
            }else{
                $invoice_no = $_SESSION['rpay']['invoice_gid'];
            }
            $invoice = $this->Invoice_Model->get_invoice_by_id(base64_encode($_SESSION['rpay']['invoice_id']));
            $data = array(
              "invoice_id"  => isset($_SESSION['rpay']['invoice_id']) ? sanitize($_SESSION['rpay']['invoice_id']) : '',
              "invoice_ref" => $invoice->performa_id,
              "client_id" => isset($_SESSION['rpay']['client_id']) ? sanitize($_SESSION['rpay']['client_id']) : '',
              "txn_id" => isset($_SESSION['rpay']['payment_id']) ? sanitize($_SESSION['rpay']['payment_id']) : '',
              "pay_method" => 'razorpay',
              "amount" => isset($_SESSION['rpay']['amount']) ? sanitize($_SESSION['rpay']['amount']) : 0,
              "txn_fee" => 0,
              "transaction_status" => 1,
              "transaction_system_ip" => $_SERVER['REMOTE_ADDR'],
              "created" => date("Y-m-d H:i:s"),
              "updated" => date("Y-m-d H:i:s")
            );
            
            $is = $this->Invoice_Model->add_txn($data);
            if($is){
                $invoice = $this->Invoice_Model->get_invoice_by_id(base64_encode($_SESSION['rpay']['invoice_id']));
                $cps = explode(",",$invoice->client_pid);
                foreach($cps as $cp){
                    $this->Invoice_Model->update_c_product($cp, array("bill_status"=>"paid","invoice_id"=>$invoice_no,"cron"=>0));
                }
                $idata = array(
                  "invoice_total" => (floatval($_SESSION['rpay']['amount']) - floatval($data['amount'])),
                  "paid_amount" => (floatval($invoice->paid_amount) + floatval($data['amount'])),
                  "payment_method" => 'razorpay',
                  "performa" => 0,
                  "invoice_gid" => $invoice_no,
                  "order_status" => 'paid',
                  "updated" => date("Y-m-d")
                );
                $i = $this->Invoice_Model->update_new_invoice($data['invoice_id'], $idata);
                unset($_SESSION['rpay']);
                redirect(get_config_item('razorpay_surl'));
            }else{
                redirect(get_config_item('razorpay_furl'));
            }
         }
    }
    
    public function razorpay_failure()
    {
        if(isset($_SESSION['rpay']['payment']) &&
         $_SESSION['rpay']['payment']=='failed')
         {
            $invoice_no = "";
            if(isset($_SESSION['rpay']['invoice_gid']) && empty($_SESSION['rpay']['invoice_gid'])){
                $inv_prefix = get_config_item('invoice_prefix');
                $inv = get_last_invoice_id();
                
                if($inv!='')
                {
                    $int = intval(filter_var($inv, FILTER_SANITIZE_NUMBER_INT));
                    $int = intval($int) + 1;
                    $invoice_no = $inv_prefix.$int;
                }else{
                    $invoice_no = $inv_prefix.get_config_item('invoice_start_no');
                }
            }else{
                $invoice_no = $_SESSION['rpay']['invoice_gid'];
            }
            $invoice = $this->Invoice_Model->get_invoice_by_id(base64_encode($_SESSION['rpay']['invoice_id']));
            $data = array(
              "invoice_id"  => isset($_SESSION['rpay']['invoice_id']) ? sanitize($_SESSION['rpay']['invoice_id']) : '',
              "invoice_ref" => $invoice->performa_id,
              "client_id" => isset($_SESSION['rpay']['client_id']) ? sanitize($_SESSION['rpay']['client_id']) : '',
              "txn_id" => isset($_SESSION['rpay']['payment_id']) ? sanitize($_SESSION['rpay']['payment_id']) : '',
              "pay_method" => 'razorpay',
              "amount" => isset($_SESSION['rpay']['amount']) ? sanitize($_SESSION['rpay']['amount']) : 0,
              "txn_fee" => 0,
              "transaction_status" => 0,
              "transaction_system_ip" => $_SERVER['REMOTE_ADDR'],
              "created" => date("Y-m-d H:i:s"),
              "updated" => date("Y-m-d H:i:s")
            );
            
            $is = $this->Invoice_Model->add_txn($data);
            unset($_SESSION['rpay']);
            redirect(get_config_item('razorpay_furl'));
         }
    }
    
    public function pay_with_payumoney($inv='/')
    {
        if(isset($inv) && !empty($inv))
        {
            $invoice_id = decrypt_me($inv);
            $data['title'] = "Payment Portal";
            $invoice = $this->Invoice_Model->get_invoice_by_id(base64_encode($invoice_id));
            $POST_DATA = array();
            if(!empty($invoice))
            {
                $POST_DATA['key'] = decrypt_me(get_config_item('PAYU_KEY_ID'));
                $POST_DATA['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
                $POST_DATA['amount'] = $invoice->invoice_total;
                $POST_DATA['firstname'] = get_client_info($invoice->client_id,'client_name');
                $POST_DATA['email'] = get_client_info($invoice->client_id,'client_email');
                $POST_DATA['phone'] = get_client_info($invoice->client_id,'client_mobile');
                $POST_DATA['productinfo'] = $invoice->invoice_gid;
                $POST_DATA['surl'] = base_url('home/payu_success');
                $POST_DATA['furl'] = base_url('home/payu_failure');
                $POST_DATA['service_provider'] = 'payu_paisa';
                $POST_DATA['address1'] = get_client_info($invoice->client_id,'client_fulladdress');
                $POST_DATA['city'] = get_client_info($invoice->client_id,'client_city');
                $POST_DATA['state'] = get_module_value(get_client_info($invoice->client_id,'client_state'),'state');
                $POST_DATA['country'] = get_module_value(get_client_info($invoice->client_id,'client_country'),'country');
                $POST_DATA['zipcode'] = get_client_info($invoice->client_id,'client_pincode');
                
                $_SESSION['payu']['client_id'] = $invoice->client_id;
                $_SESSION['payu']['invoice_id'] = $invoice->invoice_id;
                $_SESSION['payu']['invoice_gid'] = $invoice->invoice_gid;
                $_SESSION['payu']['amount'] = $invoice->invoice_total;
                
            }
            $data['POST'] = $POST_DATA;
            
            $this->load->view("modules/home/PayUMoney/PayUMoney_form", $data);
        }
    }
    
    public function payu_success()
    {
        if(isset($_POST['mihpayid']) &&
         $_POST['status']=='success'
         && $_POST['amount']!=0)
         {
            $invoice_no = "";
            if(isset($_SESSION['payu']['invoice_gid']) && empty($_SESSION['payu']['invoice_gid'])){
                $inv_prefix = get_config_item('invoice_prefix');
                $inv = get_last_invoice_id();
                
                if($inv!='')
                {
                    $int = intval(filter_var($inv, FILTER_SANITIZE_NUMBER_INT));
                    $int = intval($int) + 1;
                    $invoice_no = $inv_prefix.$int;
                }else{
                    $invoice_no = $inv_prefix.get_config_item('invoice_start_no');
                }
            }else{
                $invoice_no = $_SESSION['payu']['invoice_gid'];
            }
            $invoice = $this->Invoice_Model->get_invoice_by_id(base64_encode($_SESSION['payu']['invoice_id']));
            
            $data = array(
              "invoice_id"  => isset($_SESSION['payu']['invoice_id']) ? sanitize($_SESSION['payu']['invoice_id']) : '',
              "invoice_ref" => $invoice->performa_id,
              "client_id" => isset($_SESSION['payu']['client_id']) ? sanitize($_SESSION['payu']['client_id']) : '',
              "txn_id" => isset($_POST['txnid']) ? sanitize($_POST['txnid']."/".$_POST['payuMoneyId']) : '',
              "pay_method" => $_POST['mode']=='' ? 'payumoney' : 'payumoney/'.$_POST['mode'],
              "amount" => isset($_POST['amount']) ? sanitize($_POST['amount']) : 0,
              "txn_fee" => 0,
              "transaction_status" => 1,
              "transaction_system_ip" => $_SERVER['REMOTE_ADDR'],
              "created" => date("Y-m-d H:i:s"),
              "updated" => date("Y-m-d H:i:s")
            );
            
            $is = $this->Invoice_Model->add_txn($data);
            if($is){
                $cps = explode(",",$invoice->client_pid);
                foreach($cps as $cp){
                    $this->Invoice_Model->update_c_product($cp, array("bill_status"=>"paid","invoice_id"=>$invoice_no,"cron"=>0));
                }
                $idata = array(
                  "invoice_total" => (floatval($_SESSION['payu']['amount']) - floatval($data['amount'])),
                  "paid_amount" => (floatval($invoice->paid_amount) + floatval($data['amount'])),
                  "payment_method" => $_POST['mode']=='' ? 'payumoney' : $_POST['mode'],
                  "invoice_gid" => $invoice_no,
                  "performa" => 0,
                  "order_status" => 'paid',
                  "updated" => date("Y-m-d")
                );
                $i = $this->Invoice_Model->update_new_invoice($data['invoice_id'], $idata);
                unset($_SESSION['payu']);
                redirect(get_config_item('payu_surl'));
            }else{
                redirect(get_config_item('payu_furl'));
            }
         }
        
    }
    
    public function payu_failure()
    {
        if(isset($_POST['mihpayid']) &&
         $_POST['status']=='failure')
         {
            $invoice_no = "";
            if(isset($_SESSION['payu']['invoice_gid']) && empty($_SESSION['payu']['invoice_gid'])){
                $inv_prefix = get_config_item('invoice_prefix');
                $inv = get_last_invoice_id();
                
                if($inv!='')
                {
                    $int = intval(filter_var($inv, FILTER_SANITIZE_NUMBER_INT));
                    $int = intval($int) + 1;
                    $invoice_no = $inv_prefix.$int;
                }else{
                    $invoice_no = $inv_prefix.get_config_item('invoice_start_no');
                }
            }else{
                $invoice_no = $_SESSION['payu']['invoice_gid'];
            }
            $invoice = $this->Invoice_Model->get_invoice_by_id(base64_encode($_SESSION['payu']['invoice_id']));
            $data = array(
              "invoice_id"  => isset($_SESSION['payu']['invoice_id']) ? sanitize($_SESSION['payu']['invoice_id']) : '',
              "invoice_ref" => $invoice->performa_id,
              "client_id" => isset($_SESSION['payu']['client_id']) ? sanitize($_SESSION['payu']['client_id']) : '',
              "txn_id" => isset($_POST['txnid']) ? sanitize($_POST['txnid']."/".$_POST['payuMoneyId']) : '',
              "pay_method" => $_POST['mode']=='' ? 'payumoney' : $_POST['mode'],
              "amount" => isset($_POST['amount']) ? sanitize($_POST['amount']) : 0,
              "txn_fee" => 0,
              "transaction_status" => 0,
              "transaction_system_ip" => $_SERVER['REMOTE_ADDR'],
              "created" => date("Y-m-d H:i:s"),
              "updated" => date("Y-m-d H:i:s")
            );
            
            $is = $this->Invoice_Model->add_txn($data);
            unset($_SESSION['payu']);
            redirect(get_config_item('payu_furl'));
         }
    }
    
    public function logout()
    {
        $this->session->sess_destroy();
        unset($_SESSION);
        redirect(base_url());
    }    
}

?>