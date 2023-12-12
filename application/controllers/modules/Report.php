<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

require_once('application/third_party/dompdf/dompdf_config.inc.php');

class Report extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('lead_helper');
        $this->load->helper('client_helper');
        $this->load->helper('security');
        $this->load->helper('sconfig_helper');
        $this->load->helper('task_helper');
        $this->load->model('Lead_Model');
        $this->load->model('Client_Model');
        $this->load->model('Report_Model');
        $this->load->model('Agent_Model');
        $this->load->model('Invoice_Model');
        $this->load->model('Project_Model');
        $this->load->model('Project_Expense_Model');
        $this->load->model('SMS_Model');
        $this->load->model('Task_Model');
        $this->load->library("Auth");
        $this->Auth = new Auth();
        $this->Auth->_check_Aauth();
        date_default_timezone_set("Asia/Kolkata");
    }
    
    
    public function income_report()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Income Report";
        $hdata['page_type'] = "income-report";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."report'>Report</a> / Income Report";
        
        $data['ps'] = get_module_values('product_service');
        $data['agent'] = get_module_values('agent');
        $data['ireport'] = $this->Report_Model->get_income_report();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/income_report", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function invoice_report()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Invoice Report";
        $hdata['page_type'] = "invoice-report";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."report'>Report</a> / Invoice Report";
        
        $data['invreport'] = $this->Report_Model->get_invoice_report();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/invoice_report", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function client_report()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Client Report";
        $hdata['page_type'] = "client-report";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."report'>Report</a> / Client Report";
        
        $data['creport'] = $this->Report_Model->get_client_report();
        $data['cro'] = $this->Report_Model->get_client_order_report();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/client_report", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function custom_income_report()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Custom Income Report";
        $hdata['page_type'] = "custom-income-report";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."report'>Report</a> / Custom Income Report";
        
        $data['cireport_l'] = $this->Report_Model->get_custom_income_l_report();
        $data['cireport_c'] = $this->Report_Model->get_custom_income_c_report();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/custom_income_report", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function employee()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Employee";
        $hdata['page_type'] = "employee";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."report'>Report</a> / Employee";
        
        $data['ereport'] = $this->Report_Model->get_all_report_of_emp();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/employee", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function client_resource()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Client Resource";
        $hdata['page_type'] = "client-resource";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."report'>Report</a> / Client Resource";
        
        $data['cresource'] = $this->Report_Model->get_client_resource();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/client_resource", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function custom_client_report()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Custom Client Report";
        $hdata['page_type'] = "custom-client-report";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."report'>Report</a> / Custom Client Report";
        
        $data['clients'] = $this->Report_Model->get_all_clients();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/custom_client_report", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function batch_pdf_invoice_export()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Batch Pdf Invoice Export";
        $hdata['page_type'] = "batch-pdf-invoice-export";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."report'>Report</a> / Batch Pdf Invoice Export";
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/batch_pdf_invoice_export");
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function services()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Services";
        $hdata['page_type'] = "services";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."report'>Report</a> / Services";
        
        $data['services'] = $this->Report_Model->get_refined_services();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/services", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function batch_inv_export()
    {
        $this->load->library("zip");
        if(isset($_GET['inv']) && !empty($_GET['inv']))
        {
            $html = '';
            $files = array();
            $invs = explode(",", $_GET['inv']);
            foreach($invs as $invid){
                $invdata['inv'] = $this->Invoice_Model->get_invoice_by_id($invid);
                $invdata['products'] = $this->Invoice_Model->get_products_of_invoice($invid);
                $invdata['cp'] = $this->Invoice_Model->get_cproducts_of_invoice($invid);
                
                $html = $this->load->view('scriptfiles/inv_email_template.php', $invdata,true);
                $invoiceid = !empty($invdata['inv']->invoice_gid) ? $invdata['inv']->invoice_gid : $invdata['inv']->performa_id;
                $dompdf = new DOMPDF();
        		$dompdf->load_html($html);
        		$dompdf->render();				
        		$invfile =   $dompdf->output();
    			$location = $invoiceid.".pdf";
    			array_push($files, $location);
    			$f=fopen(FCPATH."resource/tmp/".$location,'w');
                fwrite($f,$invfile);
                fclose($f);
            }
            $zip_folder = FCPATH."resource/tmp/";
            if(true){
                //converting to zip file
                $zip_name = time().".zip";
                //adding files
                foreach($files as $file){
                    $this->zip->read_file($zip_folder.$file);
                    if(file_exists($zip_folder.$file)){
                        unlink($zip_folder.$file);
                    }
                }
                $this->zip->archive($zip_folder.$zip_name);
                if(file_exists($zip_folder.$zip_name)){
                    unlink($zip_folder.$zip_name);
                }
                
                $this->zip->download("Batch_Invoice_PDF");
                
            }else{
                echo "not loaded.";
            }
        }   
    }
    
    public function export_client_data()
    {
        if(isset($_GET['c']) && !empty($_GET['c']))
        {
            $clients = (explode(",",$_GET['c']));
            
            $file = "./resource/tmp/clientsdata.csv";
            $table_columns = array("S. No.","Full Name","Company Name","Email Id","Full Address",
            "City","State","Pincode","Country","Status","SignUp Date","Duration","Paid","Unpaid/Due",
            "Income","Products and Services","Invoices");
            
            // $cproducts = $this->Client_Model->get_all_products($_GET['edit']);
            
            $fp = fopen($file,"w");
            fputcsv($fp,$table_columns);
               
            $i=1;
            foreach($clients as $c){
                $products=$invoices='';
             
                $cps = $this->Client_Model->get_all_products($c);
                $cinv = $this->Invoice_Model->get_all_invoices($c);
                $j=1;
                if(isset($cps) && !empty($cps)){
                foreach($cps as $cp){
                    
                    if($cp->price_override == '' || $cp->price_override == 0){
                        $price = get_formatted_price($cp->set_up_fee + $cp->payment);
                    }else{
                        $price = get_formatted_price($cp->price_override);
                    }
                    $due = $cp->billing_cycle !== 'onetime' ? get_formatted_date($cp->next_due_date) : '-';
                    $products .= '('.$j.'): '.str_replace('&amp;','and',$cp->product_service_name).' (Amount): '.$price.' (Billing Cycle): '.ucfirst($cp->billing_cycle).' (Signup Date): '.get_formatted_date($cp->add_date).' (Next Due Date): '.$due.' (Status): '.ucfirst($cp->bill_status).'/ ';
                    $j++;
                }}
                $k=1;
                if(isset($cinv) && !empty($cinv)){
                foreach($cinv as $inv){
                    
                    $invoices .= '('.$k.'): '.$inv->invoice_gid.' (Payment Method): '.ucfirst($inv->payment_method).' (Due Date): '.get_formatted_date($inv->invoice_due_date).' (Service): '.get_invoice_services_no($inv->invoice_id).' (Amount): '.get_formatted_price($inv->invoice_total).' (Status): '.ucfirst($inv->order_status).'/ ';
                    $k++;
                }}
                
                $c = base64_decode($c);
                $s = get_client_info($c,'client_status') ==1 ? 'Active' : 'De-active';
                
                fputcsv($fp,array(
                 $i,get_client_info($c,'client_name'),get_client_info($c,'client_company'),
                 get_client_info($c,'client_email'),get_client_info($c,'client_fulladdress'),
                 get_client_info($c,'client_city'),get_module_value(get_client_info($c,'client_state'),'state'),
                 get_client_info($c,'client_pincode'),get_module_value(get_client_info($c,'client_country'),'country'),
                 $s,get_formatted_date(get_client_info($c,'created')),dateDiffInDays(get_client_info($c,'created')),
                 get_client_paid_no($c).'('.get_formatted_price(get_client_paid($c)).')',
                 get_client_unpaid_no($c).'('.get_formatted_price(get_client_unpaid($c)).')',
                 get_formatted_price(get_client_paid($c)), $products, $invoices
                ));
        
                $i++;
            }
            
            fclose($fp);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="clientsdata.csv"');
            readfile($file);
            
        }else{
            $this->session->set_flashdata("error","Data not found to export.");
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function export_project_data()
    {
        $projects = $this->Project_Model->get_all();
            
        $file = "./resource/tmp/projects.csv";
        $table_columns = array("S. No.","Project Name","Client Name","Status");
        
        $fp = fopen($file,"w");
        fputcsv($fp,$table_columns);
           
        $i=1;
        if(is_array($projects)){
            foreach($projects as $c){
             
                fputcsv($fp,array(
                 $i,$c->project_name,$c->client_name,$c->status == 1 ? 'Active' : 'Completed'
                ));
        
                $i++;
            }
        }
        
        fclose($fp);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="projects.csv"');
        readfile($file);
        
    }
    
    public function export_auzaar_data()
    {
        $projects = $this->Project_Model->get_all_aaujars();
            
        $file = "./resource/tmp/tools.csv";
        $table_columns = array("S. No.","Business Associate Name","Tool","Total", "Used", "Transferred", "Closing", "Date", "Details");
        
        $fp = fopen($file,"w");
        fputcsv($fp,$table_columns);
           
        $i=1;
        if(is_array($projects)){
            foreach($projects as $c){
             
                fputcsv($fp,array(
                 $i,$c->agent_name,$c->tool_name,$c->total_qty,$c->used_qty,$c->transfer_qty,$c->closing_qty,date('d-m-Y', strtotime($c->created)),$c->details
                ));
        
                $i++;
            }
        }
        
        fclose($fp);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="tools.csv"');
        readfile($file);
        
    }
    
    public function export_burning_report_data()
    {
        $burning_reports = $this->Project_Model->get_all_burning_report();
            
        $file = "./resource/tmp/site-issues-reports.csv";
        $table_columns = array("S. No.","Business Associate","Client Name","Project","Category","Report", "Date");
        
        $fp = fopen($file,"w");
        fputcsv($fp,$table_columns);
           
        $i=1;
        if(is_array($burning_reports)){
            foreach($burning_reports as $c){
             
                fputcsv($fp,array(
                 $i,($c->agent_id==0 ? 'admin' : get_info_of('agent', 'agent_name', $c->agent_id, 'agent_id')),$c->client_name,$c->project_name,$c->category_name,$c->text,date('d-m-Y', strtotime($c->created))
                ));
        
                $i++;
            }
        }
        
        fclose($fp);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="site-issues-report.csv"');
        readfile($file);
    }
    
    public function export_site_issue_category_data()
    {
        $categories = $this->Project_Model->get_all_site_issue_category();
            
        $file = "./resource/tmp/site-issue-category.csv";
        $table_columns = array("S. No.","Name");
        
        $fp = fopen($file,"w");
        fputcsv($fp,$table_columns);
           
        $i=1;
        if(is_array($categories)){
            foreach($categories as $c){
             
                fputcsv($fp,array(
                 $i,$c->name
                ));
        
                $i++;
            }
        }
        
        fclose($fp);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="site-issue-category.csv"');
        readfile($file);
    }
    
    
    public function export_task_data()
    {
        $tasks = $this->Task_Model->get_all();
            
        $file = "./resource/tmp/tasks.csv";
        $table_columns = array("S. No.","Subject","Status","Follow Up Date", "Comments", "Business Associate Name", "Priority");
        
        $fp = fopen($file,"w");
        fputcsv($fp,$table_columns);
           
        $i=1;
        if(is_array($tasks)){
            foreach($tasks as $t){
             
                fputcsv($fp,array(
                 $i,$t->task_name,get_module_value($t->task_status,'task_status'),date(get_config_item('date_php_datetime_format'),strtotime($t->task_date))
                 ,$t->description, get_module_value($t->agent_id, 'agent')=='-' ? 'Admin' :
                  get_module_value($t->agent_id, 'agent'), ($t->task_priority==10) ? 'High' 
                  : ($t->task_priority == 5 ? 'Medium' : 
                  'Low')
                ));
        
                $i++;
            }
        }
        
        fclose($fp);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="tasks.csv"');
        readfile($file);
    }
    
    public function export_petty_cash_data()
    {
        $petty = $this->Project_Model->get_all_petty_cash();
            
        $file = "./resource/tmp/cash-flow.csv";
        $table_columns = array("S. No.","Business Associate", "Received From", "Date","Opening Balance", "Total Received", "Total Expense", "Closing Balance");
        
        $fp = fopen($file,"w");
        fputcsv($fp,$table_columns);
           
        $i=1;
        if(is_array($petty)){
            foreach($petty as $c){
             
                fputcsv($fp,array(
                 $i,get_info_of('agent', 'agent_name', $c->agent_id, 'agent_id'), $c->received_history, date('d-m-Y', strtotime($c->created)),
                 $c->opening_balance, $c->total_received, $c->total_expense, $c->closing_balance
                ));
        
                $i++;
            }
        }
        
        fclose($fp);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="cash-flow.csv"');
        readfile($file);
    }
    
    public function export_expense_data()
    {
        $expenses = $this->Project_Expense_Model->get_all();
       
        $file = "./resource/tmp/expenses.csv";
        $table_columns = array("S. No.","Project Name","Client Name","Category", "Expense Date", "Comment", "Quantity", "Price", "Total Price", "Type", "Created By");
        
        $fp = fopen($file,"w");
        fputcsv($fp,$table_columns);
           
        $i=1;
        if(is_array($expenses)){
            foreach($expenses as $c){
             
                fputcsv($fp,array(
                 $i,$c->project_name,$c->client_name,$c->category, date('d-m-Y', strtotime($c->created)), $c->comment ,$c->quantity,$c->price, $c->total_price, $c->type, get_info_of('agent', 'agent_name', $c->created_by_id, 'agent_id')
                ));
        
                $i++;
            }
        }
        
        fclose($fp);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="expenses.csv"');
        readfile($file);
        
    }
    
    public function export_work_status_data()
    {
        $work_statuses = $this->Project_Model->get_all_work_status();
       
        $file = "./resource/tmp/work-status.csv";
        $table_columns = array("S. No.","Project Name","Client Name","Date", "Today", "Tomorrow", "Day After Tomorrow", "Created By");
        
        $fp = fopen($file,"w");
        fputcsv($fp,$table_columns);
           
        $i=1;
        if(is_array($work_statuses)){
            foreach($work_statuses as $c){
                
                fputcsv($fp,array(
                 $i,$c->project_name,$c->client_name,date('d-m-Y', strtotime($c->created)),$c->work_status_today,$c->work_status_tomorrow, $c->day_after_status, get_info_of('agent', 'agent_name', $c->created_by_id, 'agent_id')
                )); 
        
                $i++;
            }
        }
        
        fclose($fp);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="work-status.csv"');
        readfile($file);
        
    }
    
    public function export_payment_data()
    {
        $payments = $this->Project_Model->get_all_client_payments();
       
        $file = "./resource/tmp/client-payments.csv";
        $table_columns = array("S. No.","Project Name","Client Name","Amount", "Type", "Date", "Comment");
        
        $fp = fopen($file,"w");
        fputcsv($fp,$table_columns);
           
        $i=1;
        if(is_array($payments)){
            foreach($payments as $c){
                
                fputcsv($fp,array(
                 $i,$c->project_name,$c->client_name,$c->amount,$c->type, date('d-M-Y', strtotime($c->date), $c->comment)
                )); 
        
                $i++;
            }
        }
        
        fclose($fp);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="client-payments.csv"');
        readfile($file);
    }
    
    public function expense_report()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Expenses Report";
        $hdata['page_type'] = "expsense_reports";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."report'>Report</a> / Expenses";
        
        $data['expenses'] = $this->Project_Expense_Model->get_all();
        $data['projects'] = $this->Project_Model->get_all();
        $data['agents'] = $this->Agent_Model->get_all();
        $data['clients'] = $this->Client_Model->get_all();
        $data['categories'] = $this->Project_Expense_Model->get_all_category();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/expenses_report", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function work_status_report()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Work Status Report";
        $hdata['page_type'] = "work_status_report";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."report'>Report</a> / Work Status";
        
        $data['work_status'] = $this->Project_Model->get_all_work_status();
        $data['projects'] = $this->Project_Model->get_all();
        $data['agents'] = $this->Agent_Model->get_all();
        $data['clients'] = $this->Client_Model->get_all();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/work_status_report", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function financial_report()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Financial Report";
        $hdata['page_type'] = "financial_report";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."report'>Report</a> / Financial";
        
        $data['projects'] = $this->Project_Model->get_all();
        $data['clients'] = $this->Client_Model->get_all();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/financial_report", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function petty_cash()
    {
        $this->Auth->_check_Aauth();
        $hdata['title'] = "Petty Cash Report";
        $hdata['page_type'] = "petty_cash";
        $hdata['rurl'] = base_url('resource/');
        $hdata['track'] = "<a href='".base_url()."report'>Report</a> / Petty Cash";
        
        $data['petty_cash'] = $this->Project_Model->get_all_petty_cash();
        $data['agents'] = $this->Agent_Model->get_all();
        
        $this->load->view("includes/global_header", $hdata);
        $this->load->view("includes/side_nav", $hdata);
        $this->load->view("modules/pages/petty_cash", $data);
        $this->load->view("includes/global_footer", $hdata);
    }
    
    public function update_closing_balance()
    {
        $date = isset($_GET['date']) && !empty($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : date("Y-m-d");
        $this->Project_Model->updateClosingBal($date);
        
        header("Location:". base_url('report/petty_cash?'. http_build_query($_GET)));
    }
    
}

?>