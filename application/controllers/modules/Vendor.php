<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
require_once('application/third_party/dompdf/dompdf_config.inc.php');

class Vendor extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('sconfig_helper');
        $this->load->helper('lead_helper');
        $this->load->helper('task_helper');
        $this->load->helper('security');
        $this->load->helper('vendor_helper');
        $this->load->model('Vendor_Model');
        $this->load->model('Invoice_Model');
        $this->load->model('SMS_Model');
        $this->load->model('Email_Model');
        $this->load->library("Auth");
        $this->Auth = new Auth();
        $this->Auth->_check_auth();
        date_default_timezone_set("Asia/Kolkata");
    }
    
    public function add_new()
    {
        if(isset($_SESSION['dback'])){
            unset($_SESSION['dback']);
        }
        $res = array("status"=>0, "data"=>"failed");
        if(!empty($_POST))
        {
            $last_id = get_last_vendor_id();
            if(!empty($last_id)){
                $int = intval(filter_var($last_id, FILTER_SANITIZE_NUMBER_INT));
                $int = intval($int) + 1;
                $new_id = "USR".$int;
            }else{
                $new_id = "USR1";
            }
            
            $ferror = true;
            
            if(empty(sanitize($_POST['full_name']))){
                $_SESSION['rfield']['full_name'] = "Please enter First Name.";
                $ferror = true;
            }else{
                $ferror = false;
                $_SESSION['rfield']['full_name'] = "";
            }
            
            // if(isset($_POST['company_name']) && empty(sanitize($_POST['company_name']))){
            //     $_SESSION['rfield']['company_name'] = "Please enter the Company Name.";
            //     $ferror = true;
            // }else{
            //     $ferror = false;
            //     $_SESSION['rfield']['company_name'] = "";
            // }
            
            // if(empty(sanitize($_POST['pincode'])) || !is_numeric($_POST['pincode'])){
            //     $_SESSION['rfield']['pincode'] = "Please enter valid Pincode.";
            //     $ferror = true;
            // }else{
            //     $ferror = false;
            //     $_SESSION['rfield']['pincode'] = "";
            // }
            
            // if(empty($_POST['email'])){
            //     $_SESSION['rfield']['email'] = "Please enter Email.";
            //     $ferror = true;
            // }else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            //     $_SESSION['rfield']['email'] = "Please enter a valid Email.";
            //     $ferror = true;
            // }else{
            //     $ferror = false;
            //     $_SESSION['rfield']['email'] = "";
            // }
            
            if(empty(sanitize($_POST['contact']))){
                $_SESSION['rfield']['contact'] = "Please enter Contact No.";
                $ferror = true;
            }else if(!preg_match('/^[0-9]{10}+$/', $_POST['contact'])){
                $_SESSION['rfield']['contact'] = "Please enter a valid Contact No.";
                $ferror = true;
            }else{
                $ferror = false;
                $_SESSION['rfield']['contact'] = "";
            }
            
            $data = array(
                "vendor_name"  => sanitize($this->input->post('full_name',true)),
                "vendor_company"  => sanitize($this->input->post('company_name',true)),
                "vendor_pan" => sanitize($this->input->post('pan_number',true)),
                "vendor_gst" => sanitize($this->input->post('gst_number',true)),
                "vendor_cin" => sanitize($this->input->post('cin_number',true)),
                "vendor_email"  => sanitize($this->input->post('email',true)),
                "vendor_mobile"  => sanitize($this->input->post('contact',true)),
                "vendor_position"  => sanitize($this->input->post('position',true)),
                "vendor_alt_no"  => sanitize($this->input->post('altno',true)),
                "vendor_website"  => htmlspecialchars($this->input->post('website',true)),
                "vendor_source"  => sanitize(base64_decode($this->input->post('source',true))),
                "vendor_fulladdress"  => $this->input->post('office_address',true),
                "vendor_country"  => sanitize($this->input->post('country',true)),
                "vendor_state"  => sanitize($this->input->post('state',true)),
                "vendor_city"  => sanitize($this->input->post('city',true)),
                "vendor_pincode"  => sanitize($this->input->post('pincode',true)),
                
                "quoted_rate"  => sanitize($this->input->post('quoted_rate',true)),
                "final_rate"  => sanitize($this->input->post('final_rate',true)),
                "vendor_type"  => sanitize($this->input->post('vendor_type',true)),
                "office_location"  => sanitize($this->input->post('office_location',true)),
                "office_address"  => sanitize($this->input->post('office_address',true)),
                "comments"  => sanitize($this->input->post('comments',true)),
                "expertise_in_product"  => sanitize($this->input->post('expertise_in_product',true)),
                
                "vendor_password" => md5($this->input->post('contact',true)),
                "vendor_raw_password" => encrypt_me($this->input->post('contact',true)),
                "updated"  => sanitize(date("Y-m-d"))
            );
            
            $_SESSION['dback'] = $data;
            
            if(!$ferror){
                
                if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
                && $_SESSION['roll']!=='admin')
                {
                    $res['by_agent'] = decrypt_me($_SESSION['login_id']);
                }
                if(isset($_POST['vendor_id']) && !empty($_POST['vendor_id']))
                {
                    $id = $this->Vendor_Model->update($_POST['vendor_id'], $data);
                    $res['update'] = true;
                }else{
                    unset($_SESSION['dback']) ;
                    unset($_SESSION['rfield']) ;
                    $data['created'] = date("Y-m-d");
                    $data["vendor_uid"]  = $new_id;
                    $id = $this->Vendor_Model->add_new($data);
                    if(isset($_POST['ref']) && $_POST['ref']=='inv'){
                        $res['ref'] = true;
                        $res['redirect'] = base_url().'create-invoice?ref='.base64_encode($id.'_'.$_POST['full_name']);
                    }
                }
            }else{
                $id = false;
            }
            
            if($id)
            {
                $res['status'] = 1;
                $res['data'] = "success";
            }else{
                $res['data'] = "adderror";                
            }
        }
        print_r(json_encode($res));
    }
    
    public function action()
    {
        if(isset($_GET['delete']) && !empty($_GET['delete']))
        {
            $this->Vendor_Model->delete_vendor($_GET['delete']);
            redirect($_SERVER['HTTP_REFERER']);
        }
        if(isset($_GET['deleteCp']) && !empty($_GET['deleteCp']))
        {
            $this->Vendor_Model->delete_vendor_product($_GET['deleteCp']);
            redirect($_SERVER['HTTP_REFERER']);
        }
        if(isset($_GET['editCp']) && !empty($_GET['editCp']))
        {
            $hdata['title'] = "Admin | Edit Vendor Product";
            $hdata['page_type'] = "edit-cproduct";
            $hdata['rurl'] = base_url('resource/');
            
            $data['cp'] = $this->Vendor_Model->get_cproduct(sanitize($_GET['editCp']));
            
            $hdata['track'] = "<a href='".$_SERVER['HTTP_REFERER']."'>Summary</a> / <a href='".base_url('vendors')."'>Vendors</a> /
             <a href='".$_SERVER['HTTP_REFERER']."'>".get_vendor_info($data['cp']->vendor_id,'vendor_name')."</a> / ".$data['cp']->service_name;
            
            $this->load->view("includes/global_header", $hdata);
            $this->load->view("includes/side_nav", $hdata);
            $this->load->view("modules/pages/edit_cproduct", $data);
            $this->load->view("includes/global_footer", $hdata);
        }
        
        if(isset($_GET['deleteSelected']))
        {
            $res = array("status"=>0,"data"=>"failed");
            if(isset($_POST['ids']) && !empty($_POST['ids']))
            {
                $is = $this->Vendor_Model->delete_vendors(sanitize($_POST['ids']));
                if($is){
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
            print_r(json_encode($res));
        }
        
        if(isset($_GET['deleteSelectedE']))
        {
            $res = array("status"=>0,"data"=>"failed");
            if(isset($_POST['ids']) && !empty($_POST['ids']))
            {
                $is = $this->Vendor_Model->delete_vendors_emails(sanitize($_POST['ids']));
                if($is){
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
            print_r(json_encode($res));
        }
        
        if(isset($_GET['deleteSelectedS']))
        {
            $res = array("status"=>0,"data"=>"failed");
            if(isset($_POST['ids']) && !empty($_POST['ids']))
            {
                $is = $this->Vendor_Model->delete_vendors_sms_selected(sanitize($_POST['ids']));
                if($is){
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
            print_r(json_encode($res));
        }
        
        if(isset($_GET['delsms']) && !empty($_GET['delsms']))
        {
            $is = $this->Vendor_Model->delete_vendors_sms(sanitize($_GET['delsms']));
            redirect($_SERVER['HTTP_REFERER']);
        }
        if(isset($_GET['delemail']) && !empty($_GET['delemail']))
        {
            $is = $this->Vendor_Model->delete_vendors_email(sanitize($_GET['delemail']));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function search_match()
    {
        $search = isset($_GET['term']) ? sanitize($_GET['term']) : '';
        $data = $this->Vendor_Model->search_match($search);
        $res = array();
        if(!empty($data)){
            foreach($data as $d)
            {
                array_push($res, array("id"=> $d->vendor_id,"gst"=> $d->vendor_gst,
                "value"=>$d->vendor_name, "label"=>$d->vendor_name. " - ". $d->vendor_company,"pan"=> $d->vendor_pan,
                "cin"=> $d->vendor_cin));
            }
        }else
        {
            $res = array('id'=>0,'value'=>'no results');
        }
        print_r(json_encode($res));
    }
    
    public function search_match_company()
    {
        $search = isset($_GET['term']) ? sanitize($_GET['term']) : '';
        $data = $this->Vendor_Model->search_match($search);
        $res = array();
        if(!empty($data)){
            foreach($data as $d)
            {
                array_push($res, array("id"=> $d->vendor_id,
                "value"=>$d->vendor_company, "label"=>$d->vendor_company));
            }
        }else
        {
            $res = array('id'=>0,'value'=>'no results');
        }
        print_r(json_encode($res));
    }
    
    public function update_cproduct()
    {
       if(isset($_POST) && !empty($_POST))
       {
            $data = array(
                'product_id' => sanitize($this->input->post('product')),
                'service_name' => sanitize($this->input->post('sname')),
                'amount' => sanitize($this->input->post('fpay')),
                'add_date' => sanitize(date("Y-m-d", strtotime($this->input->post('reg_date')))),
                'next_due_date' => sanitize(date("Y-m-d", strtotime($this->input->post('nextdue')))),
                'next_due_amount' => sanitize($this->input->post('ramount')),
                'vendor_product_status' => sanitize($this->input->post('status')),
                'pay_method' => sanitize($this->input->post('paymethod')),
                'bill_status' => sanitize($this->input->post('billstatus')),
                'admin_note' => sanitize($this->input->post('admin_note')),
                'updated' => date("Y-m-d")
            );   
            
            $is = $this->Vendor_Model->update_cproduct($_POST['cpid'],$data);
       }
       if(isset($_POST['cid']) && !empty($_POST['cid'])){
            redirect(base_url('add-vendor/?edit='.base64_encode($_POST['cid'])));
       }else{
           redirect(base_url('vendors'));
       }
    }
    
    public function send_sms_to_vendor()
    {
        $res = array("status"=>0, "data"=>"failed");
        if(isset($_POST) && !empty($_POST))
        {
            $mobile = isset($_POST['vendor_mobile']) ? $_POST['vendor_mobile'] : '';
            $sms = isset($_POST['smstext']) ? $_POST['smstext'] : '';
            $is = $this->SMS_Model->send_sms($mobile,"", $sms,$_POST['vendor_id'],'');
            if($is)
            {
                $res['status'] = 1;
                $res['data'] = "success";
            }
        }
        print_r(json_encode($res));
    }
    
    public function save_anote_to_vendor()
    {
        $res = array("status"=>0, "data"=>"failed");
        if(isset($_POST) && !empty($_POST))
        {
            $note = isset($_POST['snoteText']) ? $_POST['snoteText'] : '';
            $is = $this->Vendor_Model->update($_POST['vendor_id'], array("admin_note"=>$note));
            if($is)
            {
                $res['status'] = 1;
                $res['data'] = "success";
            }
        }
        print_r(json_encode($res));
    }
    
    public function show_inv()
    {
        
        if(isset($_GET['view']) && !empty($_GET['view'])){
            $data['inv'] = $this->Invoice_Model->get_invoice_by_id($_GET['view']);
            $data['products'] = $this->Invoice_Model->get_products_of_invoice($_GET['view']);
            $data['cp'] = $this->Invoice_Model->get_cproducts_of_invoice($_GET['view']);
            ob_start();
            $dompdf = new DOMPDF();
            $html = $this->load->view('scriptfiles/inv_email_template.php', $data,true);					
            
    		$dompdf->load_html($html);
    		if(get_invoice_services_no(base64_decode($_GET['view'])) >= 1){
    		    $dompdf->set_paper('A3', 'portrait');
    		}
    		if(get_invoice_services_no(base64_decode($_GET['view'])) > 3){
    		    $dompdf->set_paper('A2', 'portrait');
    		}
    		$dompdf->render();		
    		
    		$title = !empty($data['inv']->invoice_gid) ? $data['inv']->invoice_gid : $data['inv']->performa_id;
    		$company = get_vendor_info($data['inv']->vendor_id,'vendor_company');
    		$dompdf->stream("#".$title."-".$company.".pdf",array("Attachment" => false));
    		die();
        }else{
            die("No invoices found !");
        }
    }
    
    public function email()
    {
        $this->load->library("email");
        $this->email->from(get_config_item('support_email'));
        $this->email->to("sendmailtotridev@gmail.com");
        $this->email->message("hello");
        var_dump($this->email->send());
    }
    
    public function viewMe()
    {
        $res = array("status"=>0, "data"=>"failed");
        if(isset($_POST['what']) && !empty($_POST['what']))
        {
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $data = $_POST['what'] == 'email' ? $this->Vendor_Model->get_email_data($id)
            : $this->Vendor_Model->get_sms_data($id);
            
            if(!empty($data))
            {
                $res['status'] = 1;
                $res['data'] = "success";
                $res['d'] = $data;
            }
        }
        print_r(json_encode($res));
    }
    
    public function send_template_email()
    {
        if(isset($_POST['template']) && !empty($_POST['template']))
        {
            redirect(base_url('home/compose_new_email?c=').$_GET['c']."&t=".$_POST['template']);
            
        }else{
            $this->session->set_flashdata("error","Something went wrong!");
            redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
    
    public function send_compose_email()
    {
        if(isset($_POST['csubject']) && !empty($_POST['csubject']) && 
        isset($_POST['ccontent']) && !empty($_POST['ccontent'])){
            
            $sub = ($_POST['csubject']);
            $content = ($_POST['ccontent']);
            $vendor = isset($_POST['vendorid']) ? $_POST['vendorid'] : '';
            
            //vendor details 
            if(!empty($vendor))
            {
                $cinfo = $this->Vendor_Model->get_vendor_by_id($vendor);
                if(!empty($cinfo)){
                    //s
                    $sub = str_replace('{user}',$cinfo->vendor_name, $sub);
                    $sub = str_replace('{email}',$cinfo->vendor_email, $sub);
                    $sub = str_replace('{mobile}',$cinfo->vendor_mobile, $sub);
                    $sub = str_replace('{date}',get_formatted_date(date("Y-m-d")), $sub);
                    //m
                    $content = str_replace('{user}',$cinfo->vendor_name, $content);
                    $content = str_replace('{email}',$cinfo->vendor_email, $content);
                    $content = str_replace('{mobile}',$cinfo->vendor_mobile, $content);
                    $content = str_replace('{date}',get_formatted_date(date("Y-m-d")), $content);
                    
                    $is = $this->Email_Model->send_email(
                        get_config_item('support_email'),
                        $cinfo->vendor_email,
                        get_config_item('company_name'),
                        $sub,
                        $content,
                        $cinfo->vendor_id,
                        0,
                        ''
                    );
                    
                    if($is){
                        $this->session->set_flashdata("success", "Successfully sent email."); 
                    }else{
                        $this->session->set_flashdata("error", "Failed to send Email."); 
                    }
                }else{
                    $this->session->set_flashdata("error", "Vendor doesn't exist."); 
                }
            }else{
                $this->session->set_flashdata("error", "Something went wrong! Try again.");   
            }
            redirect($_POST['rurl']);
        }else{
            $this->session->set_flashdata("error", "Please enter data to send!");
            redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
}
?>