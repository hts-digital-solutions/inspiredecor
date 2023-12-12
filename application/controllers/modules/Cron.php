<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
require_once('application/third_party/dompdf/dompdf_config.inc.php');

class Cron extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('security');
        $this->load->helper('sconfig_helper');
        $this->load->helper('client_helper');
        $this->load->model('Product_Model');
        $this->load->model('Project_Model');
        $this->load->model('Invoice_Model');
        $this->load->model('Client_Model');
        $this->load->model('Task_Model');
        $this->load->model('SMS_Model');
        $this->load->model('Setting_Model');
        $this->load->model('Lead_Model');
        $this->load->model('Email_Model');
        
        $this->load->library("Firebase");
        $this->Firebase = new Firebase();
        
        date_default_timezone_set("Asia/Kolkata");
    }
    
    public function update_closing_balance()
    {
        $this->Project_Model->updateClosingBal(date('Y-m-d'));
        $this->Project_Model->update_closing_aaujar();
    }
    
    public function initiate_petty_cash()
    {
        $this->Project_Model->initiatePettyCash();
        $this->Project_Model->initiateTool();
        // $this->Project_Model->initiateWorkStatus($_GET['date'] ?? '');
    }
    
    public function invoice_automate()
    {
        $current_date = date("Y-m-d");
        $over_due_after = get_config_item('invoices_due_after');
        $over_due_before = get_config_item('invoices_due_before');
        
        $clients = $this->Client_Model->get_all();
        if(isset($clients) && !empty($clients)){
            foreach($clients as $c){
                $client_ps = $this->Client_Model->get_all_products(base64_encode($c->client_id)); 
                if(isset($client_ps) && !empty($client_ps)){
                    $cp_store_b = array();
                    $cp_store_a = array();
                    foreach($client_ps as $cp){
                        if( $cp->billing_cycle != 'onetime' && ( $current_date > $cp->next_due_date
                            || dateDiffInDays($cp->next_due_date) == $over_due_before." days") && $cp->cron==0
                        ){
                            array_push($cp_store_b, $cp);
                        }else 
                        if( $cp->billing_cycle != 'onetime' && ($current_date > $cp->next_due_date 
                            || dateDiffInDays($cp->next_due_date) == $over_due_after." days") && $cp->cron==0
                        ){
                            array_push($cp_store_a, $cp);
                        }
                    }
                    
                    if(!empty($cp_store_b) && count($cp_store_b) !== 0){
                        $invoice = $this->create_invoice($c,$cp_store_b, 'before'); 
                    }
                    if(!empty($cp_store_a) && count($cp_store_a) !== 0){
                        $invoice = $this->create_invoice($c,$cp_store_a, 'after'); 
                    }
                }
            }
            $this->Setting_Model->set_config('inv_cron_run', date("d-m-Y h:i:s A"));
        }
        echo "run";
    }
    
    public function create_invoice($c,$cp_store, $over_due)
    {
        if(isset($cp_store) && !empty($cp_store) 
        && isset($c) && !empty($c)){
            $products = $cpid = $pprices = array();
            $service_names = $recurring = array();
            $invoice = $inv_id = $pm ='-';
            $subTotal = 0;
            $gst = 0;
            $discount = 0;
            $totalP = 0;
            $rtotal = 0;
            
            $over_due_email_subject = get_config_item('overdue_email_content');
            
            $invoice = substr(sha1(mt_rand()),1,12);
            $due_date = "";
            $data = array(
                'client_id' => $c->client_id,
                'client_name' => $c->client_name,
                'order_status' => 'pending',
                'gst' => 'yes',
                'send_email' => 'on',
                'send_sms' => 'on',
                'created' => date("Y-m-d"),
                'updated' => date("Y-m-d")
            );
            
            if(isset($cp_store))
            {
                $cp_data = array();
                for($i=0; $i< count($cp_store); $i++)
                {
                    array_push($recurring, get_recurring_amount($cp_store[$i]->product_id));
                    $rtotal += get_recurring_amount($cp_store[$i]->product_id);
                    $subTotal = $rtotal;
                    array_push($cpid, $cp_store[$i]->client_product_id);
                    array_push($products, $cp_store[$i]->product_id);
                    array_push($service_names, $cp_store[$i]->service_name);
                    $pm = isset($cp_store[$i]->pay_method) ? $cp_store[$i]->pay_method : '';
                    
                    $bcycle = get_info_of('product_service','billing_cycle',$cp_store[$i]->product_id,'product_service_id');
                    $due_date = $bcycle=='monthly' ? date("Y-m-d",strtotime($cp_store[$i]->next_due_date." +30day")) : date("Y-m-d",strtotime('+10day'));
                    $due_date = $bcycle=='yearly' ? date("Y-m-d",strtotime($cp_store[$i]->next_due_date." +1year")) : $due_date;
                    $due_date = $bcycle=='quarterly' ? date("Y-m-d",strtotime($cp_store[$i]->next_due_date." +4month")) : $due_date;
                    $due_date = $bcycle=='semesterly' ? date("Y-m-d",strtotime($cp_store[$i]->next_due_date." +6month")) : $due_date;
                    
                    $this->Invoice_Model->update_c_product($cp_store[$i]->client_product_id,
                    array("invoice_id"=> $invoice,"bill_status"=>"pending","next_due_date"=>$due_date,"add_date"=>$cp_store[$i]->next_due_date, "cron"=>1));
                }
            }
            $discount = 0;
            if(isset($data['gst']) && $data['gst'] == 'yes')
            {
                $gst = get_config_item("default_tax");
            }
            $subTotal = ($subTotal - $discount);
            $gst = (($subTotal * $gst) / 100);
            $totalP = ($subTotal+ $gst);
            
            $data['products'] = implode(",",$products);
            $data['client_pid'] = implode(",",$cpid);
            $data['products_name'] = implode(",",$service_names);
            $data['products_price'] = implode(",",$pprices);
            $data['products_recurring'] = implode(",",$recurring);
            $data['recurring_total'] = $rtotal;
            $data['gst_total'] = $gst;
            $data['payment_method'] = $pm;
            $data['discount'] = $discount;
            $data['invoice_subtotal'] = $subTotal;
            $data['invoice_total'] = $totalP;
            $data['invoice_gid'] = '';
            $data['performa_id'] = $invoice;
            $data['performa'] = 1;
            $data['is_recurring'] = "yes";
            $data['invoice_date'] = date("Y-m-d H:i:s");
            if($over_due == 'after') {
                $data['invoice_due_date'] = date("Y-m-d", strtotime("+".get_config_item('invoices_due_after')."day"));
            } else {
                $data['invoice_due_date'] = date("Y-m-d", strtotime("-".get_config_item('invoices_due_before')."day"));
            }
            
            $invid = $this->Invoice_Model->create_new_invoice($data);

            if($invid)
            {
                if(isset($data['send_email']) && $data['send_email']=='on')
                {
                    $invdata['inv'] = $this->Invoice_Model->get_invoice_by_id(base64_encode($invid));
                    $invdata['products'] = $this->Invoice_Model->get_products_of_invoice(base64_encode($invid));
                    $invdata['cp'] = $this->Invoice_Model->get_cproducts_of_invoice(base64_encode($invid));
                    $invdata['rinv'] = "yes";
                    
                    $user = get_client_info($c->client_id,'client_name')."[ ".get_client_info($c->client_id,'client_company')." ]";
                    $over_due_email_subject = str_replace("{user}",$user,$over_due_email_subject);
                    $over_due_email_subject = str_replace("{method}",$pm,$over_due_email_subject);
                    $over_due_email_subject = str_replace("{amount}",get_formatted_price($totalP),$over_due_email_subject);
                    $over_due_email_subject = str_replace("{due_date}",get_formatted_date($cp_store[0]->next_due_date),$over_due_email_subject);
                    $over_due_email_subject = str_replace("{date}",get_formatted_date(date("Y-m-d")),$over_due_email_subject);
                    $over_due_email_subject = str_replace("{invoice_no}",$invoice,$over_due_email_subject);
                    $e_sign = get_config_item("email_signature");
                    
                    $products = get_pstructure($invdata['inv'], $invdata['products'], $invdata['cp']);
                    $over_due_email_subject = str_replace("{products}",$products,$over_due_email_subject);
                    
                    $message = $over_due_email_subject.$e_sign;
                    
                    $dir = "./resource/tmp/";
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
                    $message = "<div>".$message."</div>";
                    
                    $s = $this->Email_Model->send_email(
                        get_config_item('support_email'),
                        get_client_info($data['client_id'],'client_email'),
                        get_config_item('company_name'),
                        'Recurring Invoice [invoice number - '.$invoice."]",
                        $message,
                        $data['client_id'],
                        $invoice,
                        $attach
                    );
                    
                    unlink($attach);
                }
                if(isset($data['send_sms']) && $data['send_sms']=='ond')
                {
                    $s = $this->SMS_Model->send_sms(
                        get_client_info($c->client_id,'client_mobile'),
                        'Recurring payment notification - '.$invoice,
                        'An invoice has been generated regarding recurring payment of product/service.
                        Visit your email for more details.',
                        $c->client_id,
                        $invoice
                    );
                }
                return true;
            }else{
                return false;
            }
        } 
    }
    
    public function notify_task()
    {
        $what = get_config_item('task_what');
        $cmob = get_config_item('company_mobile');
        $cemail = get_config_item('company_email');
        $m = get_config_item('task_notified_minute');
        $sub = 'Task Notification';
        $emsg = $mmsg = '';
        
        $tasks = $this->Task_Model->get_all();
        if(isset($tasks) && !empty($tasks))
        {
            foreach($tasks as $t)
            {
                $sm = ($t->agent_id!=0) ? get_info_of('agent','agent_mobile',$t->agent_id,'agent_id') : $cmob;
                $se = ($t->agent_id!=0) ? get_info_of('agent','agent_email',$t->agent_id,'agent_id') : $cemail;
                
                // if(date("Y-m-d H:i", strtotime($t->task_date." -".$m." minutes")) == date("Y-m-d H:i") && $t->notified==0)
                // {
                //     $emsg = '
                //     <div style="padding:10px;border:1px solid lightgray;">
                //     <h3>Task Reminder</h3>
                //     <br/>
                //     <p>
                //     You have scheduled a task named <b>'.$t->task_name.'</b> on time - '.date("d-m-Y h:i:s A",strtotime($t->task_date)).'.
                //     <br/>
                //     <b>Task Description - </b><br/>
                //     '.$t->description.'
                //     </p>
                //     <a href="'.base_url().'task/add?task='.base64_encode($t->task_id).'">Goto task</a>
                //     </div>
                //     ';
                    
                //     $mmsg = 'Task Reminder : Task named '.$t->task_name.' is scheduled on '.date("d-m-Y h:i:s A",strtotime($t->task_date));
                // }
                
                // if($what=='email' || $what=='email-sms')
                // {
                //     $s = $this->Email_Model->send_email(
                //         get_config_item('support_email'),
                //         $se,
                //         get_config_item('company_name'),
                //         $sub,
                //         $emsg,
                //         0,
                //         0,
                //         ''
                //     );
                //     $this->Task_Model->update_task(base64_encode($t->task_id),array("notified"=>1),"yes");
                // }
                
                // if($what=='sms' || $what=='email-sms' && !empty($sm))
                // {
                //     $s = $this->SMS_Model->send_sms(
                //         $sm,
                //         '',
                //         $mmsg,
                //         0,
                //         0
                //     );
                // }
                
                $task = $t;
               
                if($task && date("Y-m-d H:i", strtotime($t->task_date)) == date("Y-m-d H:i") && $t->notified==0) {
                    
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
                    
                    $this->Task_Model->update_task(base64_encode($t->task_id),array("notified"=>1),"yes");
                }
                
            }
        }
        
        $this->Setting_Model->set_config('task_cron_run', date("d-m-Y h:i:s A"));
        echo "run";
    }
    
    public function notify_followup()
    {
        $what = get_config_item('followup_what');
        $cmob = get_config_item('company_mobile');
        $cemail = get_config_item('company_email');
        $m = get_config_item('followup_notified_minute');
        $sub = 'Followup Notification';
        $emsg = $mmsg = '';
        
        $leads = $this->Lead_Model->get_all_leads();
        if(isset($leads) && !empty($leads))
        {
            foreach($leads as $l)
            {
                $followups = $this->Lead_Model->get_all_followups(base64_encode($l->lead_id));
                if(is_array($followups)){    
                    foreach($followups as $f){
                        if($f->for_calender == 'yes'){
                            $sm = ($l->assign_to_agent!=0) ? get_info_of('agent','agent_mobile',$l->assign_to_agent,'agent_id') : $cmob;
                            $se = ($l->assign_to_agent!=0) ? get_info_of('agent','agent_email',$l->assign_to_agent,'agent_id') : $cemail;
                            
                            // if(date("Y-m-d H:i", strtotime($f->followup_date." -".$m." minutes")) == date("Y-m-d H:i") && $f->notified==0)
                            // {
                            //     $emsg = '
                            //     <div style="padding:10px;border:1px solid lightgray;">
                            //     <h3>Followup Reminder</h3>
                            //     <br/>
                            //     <p>
                            //     You have scheduled a <b>'.get_module_value($f->followup_status_id,'status').
                            //     '</b> followup with <b>'.$l->full_name.
                            //     '</b> on time - '.date("d-m-Y h:i:s A",strtotime($f->followup_date)).'.
                            //     <br/>
                            //     <b>Description - </b><br/>
                            //     '.$f->followup_desc.'
                            //     </p>
                            //     <a href="'.base_url().'follwoup?lead='.base64_encode($l->lead_id).'">Goto Followup</a>
                            //     </div>
                            //     ';
                                
                            //     $mmsg = 'Followup Reminder : '.get_module_value($f->followup_status_id,'status').
                            //     ' followup with '.$l->full_name.' is scheduled on '.date("d-m-Y h:i:s A",strtotime($f->followup_date));
                            // }
                            // if($what=='email' || $what=='email-sms')
                            // {
                            //     $s = $this->Email_Model->send_email(
                            //         get_config_item('support_email'),
                            //         $se,
                            //         get_config_item('company_name'),
                            //         $sub,
                            //         $emsg,
                            //         0,
                            //         0,
                            //         ''
                            //     );
                            //     $this->Lead_Model->update_followup_n($f->followup_id,array("notified"=>1));
                            // }
                            
                            // if($what=='sms' || $what=='email-sms' && !empty($sm))
                            // {
                            //     $s = $this->SMS_Model->send_sms(
                            //         $sm,
                            //         '',
                            //         $mmsg,
                            //         0,
                            //         0
                            //     );
                            // }
                           
                            if($f && date("Y-m-d H:i", strtotime($f->followup_date)) == date("Y-m-d H:i") && $f->notified==0) {
                                //send notification
                                $agent_token = get_agent_device_token($f->assign_to_agent);
                                
                                foreach([intval($f->assign_to_agent)==0 ? get_config_item("device_token") : $agent_token] as $token) {
                                    if(!empty($token)){
                                        $this->Firebase->sendNotification($token, [
                                            'title' => "Follow Up Reminder - ". (intval($f->assign_to_agent)==0 ? 'Admin' : get_info_of('agent','agent_name',$f->assign_to_agent,'agent_id')),
                                            'body'  => $f->followup_desc,
                                        ]);
                                    }
                                }
                                
                                $this->Lead_Model->update_followup_n($f->followup_id,array("notified"=>1));
                            }
                            
                        }
                    }
                }
            }
        }
        
        $this->Setting_Model->set_config('followup_cron_run', date("d-m-Y h:i:s A"));
        echo "run";
    }
    
    public function dump_database()
    {
        include_once(FCPATH . '/application/third_party/mysqldump-php-master/src/Ifsnop/Mysqldump/Mysqldump.php');
        $dump = new Ifsnop\Mysqldump\Mysqldump('mysql:host=localhost;dbname='.$this->db->database, $this->db->username, $this->db->password);
        $f = 'dbbackup_'.date("d_M_Y_H_i_s").'.sql';
        $file_name = FCPATH.'resource/dump_file/'.$f;
        $status = $dump->start($file_name);
    }
}

?>