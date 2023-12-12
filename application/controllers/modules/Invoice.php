<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
require_once('application/third_party/dompdf/dompdf_config.inc.php');

class Invoice extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('sconfig_helper');
        $this->load->helper('client_helper');
        $this->load->helper('lead_helper');
        $this->load->helper('task_helper');
        $this->load->model('Invoice_Model');
        $this->load->model('Email_Model');
        $this->load->model('SMS_Model');
        $this->load->library("Auth");
        $this->load->model('Client_Model');
        $this->Auth = new Auth();
        $this->Auth->_check_auth();
    }
    
    public function create_invoice()
    {
       
        if(isset($_POST) && !empty($_POST)){
            $products = $cpid = $pprices = array();
            $service_names = $recurring = array();
            $invoice = $inv_id = '-';
            $subTotal = 0;
            $gst = 0;
            $discount = 0;
            $totalP = 0;
            $rtotal = 0;
            
            $invoice = substr(sha1(mt_rand()),1,12);
            if($this->input->post('client_id', true)!=''){
            $data = array(
                'client_id' => sanitize($this->input->post('client_id', true)),
                'client_name' => sanitize($this->input->post('inv_cname', true)),
                'payment_method' => sanitize($this->input->post('inv_pmethod', true)),
                'order_status' => sanitize($this->input->post('inv_ostatus', true)),
                'gst' => sanitize($this->input->post('inv_gst', true)),
                'invoice_due_date' => !empty($_POST['inv_due_date']) ? date("Y-m-d", strtotime($this->input->post('inv_due_date'))) : date("Y-m-d"),
                'send_email' => isset($_POST['send_mail']) && $_POST['send_mail'] == 'on' ? 'on' : 'off',
                'send_sms' => isset($_POST['send_sms']) && $_POST['send_sms'] == 'on' ? 'on' : 'off',
                'performa' => 1,
                'created' => !empty($_POST['inv_create_date']) ? date("Y-m-d", strtotime($this->input->post('inv_create_date',true))) : date("Y-m-d"),
                'updated' => !empty($_POST['inv_create_date']) ? date("Y-m-d", strtotime($this->input->post('inv_create_date',true))) : date("Y-m-d")
            );
            
            if(get_client_info($data['client_id'],'by_agent'))
            {
                $data["agent_id"] = get_client_info($data['client_id'],'by_agent');
            }else{
                $cemail = get_client_info($data['client_id'],'client_email');
                $data["agent_id"] = get_info_of('lead','assign_to_agent',$cemail,'email_id');
            }
            if(isset($_POST['inv_product']))
            {
                $cp_data = array();
                for($i=0; $i< count($_POST['inv_product']); $i++)
                {
                    $cp_data['product_id'] = sanitize($_POST['inv_product'][$i]);
                    $cp_data['client_id'] = sanitize($this->input->post('client_id', true));
                    $cp_data['add_date'] = $data['invoice_due_date'];
                    
                    if(sanitize($_POST['inv_bcycle'][$i])=='onetime')
                    {
                        $cp_data['next_due_date'] = date("Y-m-d", strtotime($data['invoice_due_date']));
                        // $cp_data['next_due_date'] = date("Y-m-d", strtotime($data['created']));
                    }
                    if(sanitize($_POST['inv_bcycle'][$i])=='monthly')
                    {
                        $cp_data['next_due_date'] = date("Y-m-d", strtotime('+1 month', strtotime($data['invoice_due_date'])));
                        // $cp_data['next_due_date'] = date("Y-m-d", strtotime('+1 month', strtotime($data['created'])));
                    }
                    if(sanitize($_POST['inv_bcycle'][$i])=='quarterly')
                    {
                        $cp_data['next_due_date'] = date("Y-m-d", strtotime('+3 month', strtotime($data['invoice_due_date'])));
                        // $cp_data['next_due_date'] = date("Y-m-d", strtotime('+3 month', strtotime($data['created'])));
                    }
                    if(sanitize($_POST['inv_bcycle'][$i])=='semesterly')
                    {
                        $cp_data['next_due_date'] = date("Y-m-d", strtotime('+6 month', strtotime($data['invoice_due_date'])));
                        // $cp_data['next_due_date'] = date("Y-m-d", strtotime('+6 month', strtotime($data['created'])));
                    }
                    if(sanitize($_POST['inv_bcycle'][$i])=='yearly')
                    {
                        $cp_data['next_due_date'] = date("Y-m-d", strtotime('+12 month', strtotime($data['invoice_due_date'])));
                        // $cp_data['next_due_date'] = date("Y-m-d", strtotime('+12 month', strtotime($data['created'])));
                    }
                    $cp_data['invoice_id'] = isset($_POST['invoice_gid'])
                    && !empty($_POST['invoice_gid']) ? sanitize($_POST['invoice_gid']) : $invoice;
                    $cp_data['client_product_status'] = 1;
                    $cp_data['bill_status'] = $this->input->post('inv_ostatus', true);
                    $cp_data['created'] = $data['created'];
                    $cp_data['updated'] = $data['created'];
                    $cp_data['price_override'] = sanitize($_POST['inv_poverride'][$i]);
                    $cp_data['next_due_amount'] = !empty($_POST['inv_roverride'][$i]) ? sanitize($_POST['inv_roverride'][$i]) : get_recurring_amount($_POST['inv_product'][$i]);
                    array_push($recurring, get_recurring_amount($_POST['inv_product'][$i]));
                    $rtotal += get_recurring_amount(sanitize($_POST['inv_product'][$i]));
                    
                    if(!empty($_POST['inv_poverride'][$i])){
                        $subTotal += floatval($_POST['inv_poverride'][$i]);
                        array_push($pprices, $_POST['inv_poverride'][$i]);
                    }else{
                        $subTotal += floatval(get_paying_amount($_POST['inv_product'][$i]));
                        array_push($pprices, get_paying_amount($_POST['inv_product'][$i]));
                    }
                    $cp_data['amount'] = get_paying_amount($_POST['inv_product'][$i]); 
                    $cp_data['service_name'] = sanitize($_POST['inv_sname'][$i]);
                    $cp_data['pay_method'] = sanitize($this->input->post('inv_pmethod', true));
                    if(isset($_POST['cpid'][$i]) && !empty($_POST['cpid'][$i])){
                        $this->Invoice_Model->update_c_product($_POST['cpid'][$i],$cp_data);
                        $cp_id = $_POST['cpid'][$i];
                    }else{
                        $cp_id = $this->Invoice_Model->add_c_product($cp_data);
                    }
                    array_push($cpid, $cp_id);
                    array_push($products, $_POST['inv_product'][$i]);
                    array_push($service_names, $_POST['inv_sname'][$i]);
                }
            }
            if(isset($_POST['coupon']) && $_POST['coupon'] !== '')
            {
                $discount = sanitize($_POST['coupon']);
            }
            
            if(isset($_POST['inv_gst']) && $_POST['inv_gst'] == 'yes')
            {
                $gst = get_config_item("default_tax");
            }
            $subTotal = ($subTotal - $discount);
            $gst = (($subTotal * $gst) / 100);
            $totalP = ($subTotal+ $gst);
            
            $data['products'] = implode(",",$products);
            $data['client_pid'] = implode(",",$cpid);
            $data['products_name'] = implode("_",$service_names);
            $data['products_price'] = implode(",",$pprices);
            $data['products_recurring'] = implode(",",$recurring);
            $data['recurring_total'] = $rtotal;
            $data['gst_total'] = $gst;
            $data['discount'] = $discount;
            $data['invoice_subtotal'] = $subTotal;
            $data['invoice_total'] = $totalP;
            $data['invoice_gid'] = '';
            $data['performa_id'] = isset($_POST['invoice_id'])
            && !empty($_POST['invoice_id']) ? (!empty($_POST['invoice_gid']) ? $_POST['invoice_gid'] : $invoice) : $invoice;
            $data['invoice_date'] = !empty($_POST['inv_create_date']) ? date("Y-m-d H:i:s", strtotime($this->input->post('inv_create_date',true))) : date("Y-m-d H:i:s");
            
            $client_data = array(
              "client_gst" =>  sanitize($_POST['gst']),
              "client_pan" =>  sanitize($_POST['pan']),
              "client_cin" =>  sanitize($_POST['cin']),
              "updated" => date("Y-m-d")
            );
            
            if(isset($_POST['invoice_id']) && !empty($_POST['invoice_id'])){
                $this->Client_Model->update(sanitize($_POST['client_id']), $client_data);
                $id = $this->Invoice_Model->update_new_invoice($_POST['invoice_id'],$data);
            }else{
                $this->Client_Model->update(sanitize($_POST['client_id']), $client_data);
                $_SESSION['inv'] = $this->Invoice_Model->create_new_invoice($data);
                
            }
            if(isset($_SESSION['inv']) || $_POST['invoice_id'])
            {
                if(isset($_POST['send_mail']) && $_POST['send_mail']=='on')
                {
                    $invid = !empty($_POST['invoice_id']) ? base64_encode($_POST['invoice_id']) : base64_encode($_SESSION['inv']);
                    
                    $invdata['inv'] = $this->Invoice_Model->get_invoice_by_id($invid);
                    $invdata['products'] = $this->Invoice_Model->get_products_of_invoice($invid);
                    $invdata['cp'] = $this->Invoice_Model->get_cproducts_of_invoice($invid);
                    $invoice_temp = get_config_item('invoice_email_content');
                    $invoice_con = get_config_item('invoice_confirmation_content');
                    $subject = $inv_temp = '';
                    $e_sign = get_config_item('email_signature');
                    
                    if($data['order_status']=='pending' || $data['order_status']=='due')
                    {
                        $inv_temp = $invoice_temp;
                        $subject = get_config_item('invoice_email_subject') . " : ".$invoice;
                    }else if($data['order_status']=='paid')
                    {
                        $inv_temp = $invoice_con;
                        $subject = get_config_item('invoice_confirmation_subject'). " : ".$invoice;
                    }
                    
                    $user = get_client_info($data['client_id'],'client_name')." [".get_client_info($data['client_id'],'client_company')."]";
                    $inv_temp = str_replace("{user}",$user,$inv_temp);
                    $inv_temp = str_replace("{method}",$data['payment_method'],$inv_temp);
                    $inv_temp = str_replace("{amount}",get_formatted_price($totalP),$inv_temp);
                    $inv_temp = str_replace("{due_date}",get_formatted_date($data['invoice_due_date']),$inv_temp);
                    $inv_temp = str_replace("{date}",get_formatted_date(date("Y-m-d")),$inv_temp);
                    $inv_temp = str_replace("{invoice_no}",$invoice,$inv_temp);
                    
                    $products = get_pstructure($invdata['inv'], $invdata['products'], $invdata['cp']);
                    $inv_temp = str_replace("{products}",$products,$inv_temp);
                    
                    $message = $inv_temp;
                    
                    $dir = "./resource/tmp/";
                    ob_start();
                    $dompdf = new DOMPDF();
                    $html = $this->load->view('scriptfiles/inv_email_template.php', $invdata,true);					
            		$dompdf->load_html($html);
            		if(get_invoice_services_no(base64_decode($invid)) > 1){
            		    $dompdf->set_paper('A3', 'portrait');
            		}
            		if(get_invoice_services_no(base64_decode($invid)) > 3){
            		    $dompdf->set_paper('A2', 'portrait');
            		}
            		$dompdf->render();		
            		$attach = $dir.'invoice-'.$invoice.'.pdf';
            		file_put_contents($attach, $dompdf->output());
            		
                    $message .= $e_sign;
                    $message = "<div>".$message."</div>";
                    $s = $this->Email_Model->send_email(
                        get_config_item('support_email'),
                        get_client_info($data['client_id'],'client_email'),
                        get_config_item('company_name'),
                        $subject,
                        $message,
                        $data['client_id'],
                        $invoice,
                        $attach
                    );
                    
                    $s = $this->Email_Model->send_email(
                        get_config_item('support_email'),
                        get_config_item('company_email'),
                        get_config_item('company_name'),
                        'New Invoice Notification',
                        $message,
                        0,
                        0,
                        $attach
                    );
                    unlink($attach);
                }
                if(isset($_POST['send_sms']) && $_POST['send_sms']=='on')
                {
                    $s = $this->SMS_Model->send_sms(
                        get_client_info($data['client_id'],'client_mobile'),
                        '','Invoice No.'.$invoice.' of '.get_formatted_price($totalP).' has been generated.Due date is '.get_formatted_date($data['invoice_due_date']).'. Kindly check email for more detail.',
                        $data['client_id'],
                        $data['invoice_gid']
                    );
                }
                unset($_SESSION['inv']);
                redirect(base_url('list-invoice'));
            }else{
                $this->session->set_flashdata("error", "Something went wrong, during generating invoice.");
                redirect($_SERVER['HTTP_REFERER']);
            }
            }else{
                $this->session->set_flashdata("error", "Client not found.");
                redirect($_SERVER['HTTP_REFERER']);
            }
        } 
    }
    
    public function action()
    {
        if(isset($_GET['delTxn']))
        {
            $this->Invoice_Model->delete_invoice_txn($_GET['d']);
            redirect($_SERVER['HTTP_REFERER']);
        }
        if(isset($_GET['delete']) && !empty($_GET['delete']))
        {
            $this->Invoice_Model->delete_invoice($_GET['delete']);
            redirect($_SERVER['HTTP_REFERER']);
        }
        if(isset($_GET['deleteSelected']))
        {
            $res = array("status"=>0, "data"=>"failed");
            $is = false;
            if(isset($_POST['ids']) && !empty($_POST['ids'])){
                foreach($_POST['ids'] as $i)
                $is = $this->Invoice_Model->delete_invoice($i);
            }
            if($is)
            {
                $res['status'] = 1;
                $res['data'] = "success";
            }
            print_r(json_encode($res));
        }
    }

    public function loadPdf()
    {
        if(isset($_GET['view']) && !empty($_GET['view'])){
            $data['inv'] = $this->Invoice_Model->get_invoice_by_id($_GET['view']);
            $data['products'] = $this->Invoice_Model->get_products_of_invoice($_GET['view']);
            $data['cp'] = $this->Invoice_Model->get_cproducts_of_invoice($_GET['view']);
            
            $dompdf = new DOMPDF();
            $html = $this->load->view('scriptfiles/inv_email_template.php', $data,true);					
            
    		$dompdf->load_html($html);
    		if(get_invoice_services_no(base64_decode($_GET['view'])) > 1){
    		    $dompdf->set_paper('A3', 'portrait');
    		}
    		if(get_invoice_services_no(base64_decode($_GET['view'])) > 3){
    		    $dompdf->set_paper('A2', 'portrait');
    		}
    		$dompdf->render();				
    		$dompdf->stream("invoice.pdf",array("Attachment" => false));
        }else{
            die("No invoices found !");
        }
    }
    
    public function add_payment()
    {
        if(isset($_POST) && !empty($_POST))
        {
            $invoice_no = "";
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
            
            $data = array(
              "invoice_id"  => isset($_POST['invoice_id']) ? sanitize($_POST['invoice_id']) : '',
              "client_id" => isset($_POST['client_id']) ? sanitize($_POST['client_id']) : '',
              "txn_id" => isset($_POST['txnid']) ? sanitize($_POST['txnid']) : '',
              "pay_method" => isset($_POST['pay_method']) ? sanitize($_POST['pay_method']) : '',
              "amount" => isset($_POST['amount']) ? sanitize($_POST['amount']) : 0,
              "txn_fee" => isset($_POST['txnfee']) ? sanitize($_POST['txnfee']) : 0,
              "transaction_status" => 1,
              "transaction_system_ip" => $_SERVER['REMOTE_ADDR'],
              "created" => !empty($_POST['date']) ? date("Y-m-d H:i:s", strtotime($this->input->post('date',true))) : date("Y-m-d H:i:s"),
              "updated" => !empty($_POST['date']) ? date("Y-m-d H:i:s", strtotime($this->input->post('date',true))) : date("Y-m-d H:i:s")
            );
            
            if(!empty($data) && $_POST['itotal']>= $_POST['amount'])
            {
                $invoice = $this->Invoice_Model->get_invoice_by_id(base64_encode($_POST['invoice_id']));
                $data["invoice_ref"] = $invoice->performa_id;
                $is = $this->Invoice_Model->add_txn($data);
                
                if($is)
                {
                    if(floatval($_POST['itotal']) - floatval($data['amount'])==0)
                    {
                        $cps = explode(",",$invoice->client_pid);
                        foreach($cps as $cp){
                            $this->Invoice_Model->update_c_product($cp, array("bill_status"=>"paid","invoice_id"=>$invoice_no,"cron"=>0));
                        }
                        
                        $idata = array(
                          "invoice_gid" => $invoice_no,
                          "performa" => 0,
                          "invoice_total" => (floatval($_POST['itotal']) - floatval($data['amount'])),
                          "paid_amount" => (floatval($_POST['paid_amount']) + floatval($data['amount'])),
                          "order_status" => (floatval($_POST['itotal']) - floatval($data['amount'])) <= 0 ? 'paid' : 'pending',
                          "updated" => !empty($_POST['date']) ? date("Y-m-d", strtotime($this->input->post('date',true))) : date("Y-m-d")
                        );
                        $i = $this->Invoice_Model->update_new_invoice($data['invoice_id'], $idata);
                    }else{
                        
                        $invoice_no = $invoice->performa_id;
                        
                        $idata = array(
                          "invoice_total" => (floatval($_POST['itotal']) - floatval($data['amount'])),
                          "paid_amount" => (floatval($_POST['paid_amount']) + floatval($data['amount'])),
                          "order_status" => (floatval($_POST['itotal']) - floatval($data['amount'])) <= 0 ? 'paid' : 'pending',
                          "updated" => !empty($_POST['date']) ? date("Y-m-d", strtotime($this->input->post('date',true))) : date("Y-m-d")
                        );
                        $i = $this->Invoice_Model->update_new_invoice($data['invoice_id'], $idata);
                    }
                    
                    if($i)
                    {
                        if(isset($_POST['send_mail']) && $_POST['send_mail']=='on')
                        {
                            $invid = !empty($_POST['invoice_id']) ? base64_encode($_POST['invoice_id']) : '';
                            
                            $invdata['inv'] = $this->Invoice_Model->get_invoice_by_id($invid);
                            $invdata['products'] = $this->Invoice_Model->get_products_of_invoice($invid);
                            $invdata['cp'] = $this->Invoice_Model->get_cproducts_of_invoice($invid);
                            $invoice_con = get_config_item('invoice_confirmation_content');
                            $subject = $inv_temp = '';
                            $e_sign = get_config_item('email_signature');
                            
                            $inv_temp = $invoice_con;
                            $subject = get_config_item('invoice_confirmation_subject')." : ".$invoice_no;
                            
                            $user = get_client_info($data['client_id'],'client_name')." [".get_client_info($data['client_id'],'client_company')." ]";
                            $inv_temp = str_replace("{user}",$user,$inv_temp);
                            $inv_temp = str_replace("{method}",$data['pay_method'],$inv_temp);
                            $inv_temp = str_replace("{amount}",get_formatted_price($data['amount']),$inv_temp);
                            $inv_temp = str_replace("{due_date}",get_formatted_date($invdata['inv']->invoice_due_date),$inv_temp);
                            $inv_temp = str_replace("{date}",get_formatted_date(date("Y-m-d")),$inv_temp);
                            $inv_temp = str_replace("{invoice_no}",$invoice_no,$inv_temp);
                            
                            $products = get_pstructure($invdata['inv'], $invdata['products'], $invdata['cp']);
                            $inv_temp = str_replace("{products}",$products,$inv_temp);
                            
                            $message = $inv_temp;
                            
                            $dir = "./resource/tmp/";
                            ob_start();
                            $dompdf = new DOMPDF();
                            $html = $this->load->view('scriptfiles/inv_email_template.php', $invdata,true);					
                    		$dompdf->load_html($html);
                    		$dompdf->set_paper('A3', 'portrait');
                    		if(get_invoice_services_no(base64_decode($invid)) > 1){
                    		    $dompdf->set_paper('A3', 'portrait');
                    		}
                    		if(get_invoice_services_no(base64_decode($invid)) > 3){
                    		    $dompdf->set_paper('A2', 'portrait');
                    		}
                    		$dompdf->render();			
                    		$attach = $dir.'invoice-'.$invoice_no.'.pdf';
                    		file_put_contents($attach, $dompdf->output());
                    		
                            $message .= $e_sign;
                            $message = "<div>".$message."</div>";
                            $s = $this->Email_Model->send_email(
                                get_config_item('support_email'),
                                get_client_info($data['client_id'],'client_email'),
                                get_config_item('company_name'),
                                $subject,
                                $message,
                                $data['client_id'],
                                $invoice_no,
                                $attach
                            );
                            
                            $s = $this->Email_Model->send_email(
                                get_config_item('support_email'),
                                get_config_item('company_email'),
                                get_config_item('company_name'),
                                'Invoice Confirmation Notification',
                                $message,
                                0,
                                0,
                                $attach
                            );
                            
                            unlink($attach);
                        }
                        if(isset($_POST['send_sms']) && $_POST['send_sms']=='on')
                        {
                            $s = $this->SMS_Model->send_sms(
                                get_client_info($data['client_id'],'client_mobile'),
                                '','A new payment of Invoice No.'.$invoice_no.' of '.get_formatted_price($data['amount']).' has been received. Kindly check email for more detail.',
                                $data['client_id'],
                                $invoice_no
                            );
                        }
                    }
                }
            }else{
                redirect($_SERVER['HTTP_REFERER']."&d=true");
            }
        }
        redirect(base_url('add-client?edit=').base64_encode($_POST['client_id']));
    }
    
    public function resend()
    {
        if(isset($_POST['invoices']) && is_array($_POST['invoices']))
        {
            foreach($_POST['invoices'] as $inv)
            {
                $invid = !empty($inv) ? $inv : '';
                $invdata['inv'] = $this->Invoice_Model->get_invoice_by_id($invid);
                $invdata['products'] = $this->Invoice_Model->get_products_of_invoice($invid);
                $invdata['cp'] = $this->Invoice_Model->get_cproducts_of_invoice($invid);
                $invoice_temp = get_config_item('invoice_email_content');
                $invoice_con = get_config_item('invoice_confirmation_content');
                $subject = $inv_temp = '';
                $e_sign = get_config_item('email_signature');
                $invoice = !empty($invdata['inv']->invoice_gid) ? $invdata['inv']->invoice_gid : $invdata['inv']->performa_id;
                
                if($invdata['inv']->order_status=='pending' || $invdata['inv']->order_status=='due')
                {
                    $inv_temp = $invoice_temp;
                    $subject = get_config_item('invoice_email_subject') . " : ".$invoice;
                }else if($invdata['inv']->order_status=='paid')
                {
                    $inv_temp = $invoice_con;
                    $subject = get_config_item('invoice_confirmation_subject'). " : ".$invoice;
                }
                
                $user = get_client_info($invdata['inv']->client_id,'client_name')." [".get_client_info($invdata['inv']->client_id,'client_company')." ]";
                $inv_temp = str_replace("{user}",$user,$inv_temp);
                $inv_temp = str_replace("{method}",$invdata['inv']->payment_method,$inv_temp);
                $inv_temp = str_replace("{amount}",get_formatted_price($invdata['inv']->invoice_total),$inv_temp);
                $inv_temp = str_replace("{due_date}",get_formatted_date($invdata['inv']->invoice_due_date),$inv_temp);
                $inv_temp = str_replace("{date}",get_formatted_date(date("Y-m-d")),$inv_temp);
                $inv_temp = str_replace("{invoice_no}",$invoice,$inv_temp);
                
                $products = get_pstructure($invdata['inv'], $invdata['products'], $invdata['cp']);
                $inv_temp = str_replace("{products}",$products,$inv_temp);
                
                $message = $inv_temp;
                
                $dir = "./resource/tmp/";
                ob_start();
                $dompdf = new DOMPDF();
                $html = $this->load->view('scriptfiles/inv_email_template.php', $invdata,true);					
        		$dompdf->load_html($html);
        		if(get_invoice_services_no(base64_decode($inv)) > 1){
        		    $dompdf->set_paper('A3', 'portrait');
        		}
        		if(get_invoice_services_no(base64_decode($inv)) > 3){
        		    $dompdf->set_paper('A2', 'portrait');
        		}
        		$dompdf->render();		
        		$attach = $dir.'invoice-'.$invoice.'.pdf';
        		file_put_contents($attach, $dompdf->output());
        		
                $message .= $e_sign;
                $message = "<div>".$message."</div>";
                $s = $this->Email_Model->send_email(
                    get_config_item('support_email'),
                    get_client_info($invdata['inv']->client_id,'client_email'),
                    get_config_item('company_name'),
                    $subject,
                    $message,
                    $invdata['inv']->client_id,
                    $invoice,
                    $attach
                );
                
                $s = $this->Email_Model->send_email(
                    get_config_item('support_email'),
                    get_config_item('company_email'),
                    get_config_item('company_name'),
                    'Invoice Notification',
                    $message,
                    0,
                    0,
                    $attach
                );
                unlink($attach);
            }
            
            echo "done";
        }else{
            echo "failed";
        }
    }
    
    public function mergeSelected()
    {
        if(isset($_POST['invoices']) && is_array($_POST['invoices']) && count($_POST['invoices']) > 1)
        {
            $merged_inovice_id = "";
            $mergable = array();
            $is_merge = false;
            $inv_cpid = $inv_p = $inv_pn = $inv_pp = $inv_pr = "";
            $rtotal = $gtotal = $dtotal = $st = $t = $pa = 0;
            
            foreach($_POST['invoices'] as $inv)
            {
                $data = $this->Invoice_Model->get_invoice_by_id($inv);
                $inv_cpid .= $data->client_pid .",";
                $inv_p .= $data->products .",";
                $inv_pn .= $data->products_name ."_";
                $inv_pp .= $data->products_price .",";
                $inv_pr .= $data->products_recurring .",";
                $rtotal += $data->recurring_total;
                $gtotal += $data->gst_total;
                $dtotal += $data->discount;
                $st += $data->invoice_subtotal;
                $t += $data->invoice_total;
                $pa += $data->paid_amount;
                
                if(empty($data->invoice_gid)){
                    array_push($mergable, $data->performa_id);
                    $merged_inovice_id = $data->performa_id;
                    $is_merge = true;
                }else{
                    $is_merge = false;
                    break;
                }
            }
            
            $inv_cpid = substr_replace($inv_cpid, "",-1);
            $inv_p = substr_replace($inv_p ,"",-1);
            $inv_pn = substr_replace($inv_pn ,"",-1);
            $inv_pp = substr_replace($inv_pp ,"",-1);
            $inv_pr = substr_replace($inv_pr ,"",-1);
            
            
            if($is_merge){
                foreach($mergable as $i){
                    
                    $this->db->set("invoice_id",$merged_inovice_id)->where("invoice_id",$i)->update("crm_client_products");
                    if($i!==$merged_inovice_id)
                    {
                        $this->db->where("performa_id",$i)->delete("crm_invoice");
                    }
                }
                
                $udata = array(
                    "client_pid" => $inv_cpid,
                    "products" => $inv_p,
                    "products_name" => $inv_pn,
                    "products_price" => $inv_pp,
                    "products_recurring" => $inv_pr,
                    "recurring_total" => $rtotal,
                    "gst_total" => $gtotal,
                    "discount" => $dtotal,
                    "invoice_subtotal" => $st,
                    "invoice_total" => $t,
                    "paid_amount" => $pa
                );
                
                $this->db->where("performa_id",$merged_inovice_id)->update("crm_invoice",$udata);
                
                echo "done";
            }else{
                echo "wrong";
            }
        }else{
            echo "failed";
        }
    }
    
    //module to edit invoice
    public function payment($invoice = null)
    {
        if($invoice)
        {
            if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
                $this->Auth->_check_Aauth();
            }else{
                $this->Auth->_check_auth();
            }
            $hdata['title'] = "Edit Invoice";
            $hdata['page_type'] = "edit-invoice";
            $hdata['rurl'] = base_url('resource/');
            
            if(isset($_GET['isc']) && !empty($_GET['isc'])){
               $hdata['track'] = "<a href='".$_SERVER['HTTP_REFERER']."'>Summary</a> / <a href='".base_url('clients')."'>Clients</a> /
                 <a href='".$_SERVER['HTTP_REFERER']."'>".get_client_info(base64_decode($_GET['isc']),'client_name')."</a> / Edit Invoice";
                
            }else{
               $hdata['track'] = "<a href='".base_url()."list-invoice'>List Invoice</a> / Edit Invoice";
            }
            
            $data = [];
            if(isset($invoice) && !empty($invoice))
            {
                $data['i'] = $this->Invoice_Model->get_invoice_by_id($invoice);
                $data['products'] = $this->Invoice_Model->get_products_of_invoice($invoice);
                $data['cp'] = $this->Invoice_Model->get_cproducts_of_invoice($invoice);
                $data['txn'] = $this->Invoice_Model->get_txn($invoice);
            }
            
            $this->load->view("includes/global_header", $hdata);
            $this->load->view("includes/side_nav", $hdata);
            $this->load->view("modules/pages/edit_invoice", $data);
            $this->load->view("includes/global_footer", $hdata);
        }else{
            $this->session->set_flashdata("error", "Invoice doesn't exist.");
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
}
?>