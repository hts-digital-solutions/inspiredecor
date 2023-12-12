<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Project extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('security');
        $this->load->helper('sconfig_helper');
        $this->load->helper('client_helper');
        $this->load->model('Project_Model');
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
            $created_by_id = $this->Auth->_auth_id();
            
            $data = array(
              'project_name' => isset($_POST['project_name']) ? sanitize($_POST['project_name']) : '',
              'client_id' => isset($_POST['client_id']) ? sanitize($_POST['client_id']) : '',
              'status' => isset($_POST['status']) ? sanitize($_POST['status']) : '',
              'updated' => date("Y-m-d H:i:s")
            );
            
            if(isset($_POST['pid']) && empty($_POST['pid']))
            {
              $data['created'] = date("Y-m-d H:i:s");
              $data['created_by_id'] = $created_by_id;
            }
            
            if(count($data)!=0)
            {
                if(isset($_POST['pid']) && !empty($_POST['pid']))
                {
                    $is = $this->Project_Model->update_new($_POST['pid'], $data);
                }else{
                    $is = $this->Project_Model->add_new($data);
                }
                if($is)
                {
                    $this->session->set_flashdata("success","Record has been updated.");
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
        }
        
        header("Location:". base_url('projects'));
    }
    
    //add_new_site_issue_category
    public function add_new_site_issue_category()
    {
        $res = array("status"=>0, "data"=>"success");
        if(isset($_POST) && !empty($_POST))
        {
            $data = array(
              'name' => isset($_POST['name']) ? sanitize($_POST['name']) : '',
              'updated' => date("Y-m-d H:i:s")
            );
            
            if(isset($_POST['pid']) && empty($_POST['pid']))
            {
              $data['created'] = date("Y-m-d H:i:s");
            }
            
            if(count($data)!=0)
            {
                if(isset($_POST['pid']) && !empty($_POST['pid']))
                {
                    $is = $this->Project_Model->update_site_issue_category($_POST['pid'], $data);
                }else{
                    $is = $this->Project_Model->add_new_site_issue_category($data);
                }
                if($is)
                {
                    $this->session->set_flashdata("success","Record has been updated.");
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
        }
        
        header("Location:". base_url('site-issue-category'));
    }
    
    public function add_new_burning_report()
    {
        $res = array("status"=>0, "data"=>"success");
        if(isset($_POST) && !empty($_POST))
        {
            $created_by_id = $this->Auth->_auth_id();
            
            $data = array(
              'text' => isset($_POST['text']) ? $_POST['text'] : '',
              'client_id' => isset($_POST['client_id']) ? sanitize($_POST['client_id']) : '',
              'project_id' => isset($_POST['project_id']) ? sanitize($_POST['project_id']) : '',
              'category_id' => isset($_POST['category_id']) ? sanitize($_POST['category_id']) : '',
              'agent_id' => $_POST['agent_id'] ?? $created_by_id,
              'updated' => date("Y-m-d H:i:s")
            );
            
            if(isset($_POST['pid']) && empty($_POST['pid']))
            {
              $data['created'] = isset($_POST['date']) && !empty($_POST['date']) ? date('Y-m-d H:i:s', strtotime($_POST['date'])) : date("Y-m-d H:i:s");
              $data['created_by_id'] = $created_by_id;
            }
            
            if(count($data)!=0)
            {
                if(isset($_POST['pid']) && !empty($_POST['pid']))
                {
                    $is = $this->Project_Model->update_new_burning_report($_POST['pid'], $data);
                }else{
                    $is = $this->Project_Model->add_new_burning_report($data);
                }
                if($is)
                {
                    $this->session->set_flashdata("success","Record has been updated.");
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
        }
        
        header("Location:". base_url('burning-report'));
    }
    
    public function add_new_aaujar()
    {
        $res = array("status"=>0, "data"=>"success");
        if(isset($_POST) && !empty($_POST))
        {
            $created_by_id = $this->Auth->_auth_id();
            
            if(isset($_POST['auzaar_name']) && !empty($_POST['auzaar_name'])) {
                $this->Project_Model->add_new_aaujar_name(['name' => strtolower($_POST['auzaar_name'])]);
                $_POST['auzaar'] = $_POST['auzaar_name'];
            }
            
            $data = array(
              'details' => isset($_POST['details']) ? $_POST['details'] : '',
              'tool_name' => isset($_POST['auzaar']) ? strtolower($_POST['auzaar']) : '',
              'total_qty' => isset($_POST['total_qty']) ? intval($_POST['total_qty']) : 0,
              'used_qty' => isset($_POST['used_qty']) ? intval($_POST['used_qty']) : 0,
              'closing_qty' => intval($_POST['total_qty']) - intval($_POST['used_qty']) - intval($_POST['transfer_qty'] ?? 0),
              'agent_id' => $created_by_id == 0 ? (isset($_POST['agent_id']) ? sanitize($_POST['agent_id']) : '') : $created_by_id,
              'updated' => date("Y-m-d H:i:s")
            );
            
            if(isset($_POST['pid']) && empty($_POST['pid']))
            {
              $history = "added ". $_POST['total_qty']. " quantity and used ". $_POST['used_qty'];
              $data['history'] = json_encode([$history]);
              $data['created'] = isset($_POST['date']) && !empty($_POST['date']) ? date('Y-m-d H:i:s', strtotime($_POST['date'])) : date("Y-m-d H:i:s");
            }else if(!empty($_POST['date'])) {
                $data['created'] = isset($_POST['date']) && !empty($_POST['date']) ? date('Y-m-d H:i:s', strtotime($_POST['date'])): date("Y-m-d H:i:s");
            }
            
            if(isset($_POST['pid']) && !empty($_POST['pid'])) {
                $history = "total ". $_POST['total_qty']. " quantity and used ". $_POST['used_qty'];
                
                $previous = $this->Project_Model->get_aaujar($_POST['pid']);
                $ph = json_decode($previous->history) ?? [];
                $history = array_merge($ph, [$history]);
                
                $data['history'] = json_encode($history);
            }
            
            if(count($data)!=0)
            {
                if(isset($_POST['pid']) && !empty($_POST['pid']))
                {
                    $is = $this->Project_Model->update_new_aaujar($_POST['pid'], $data);
                }else{
                    $is = $this->Project_Model->add_new_aaujar($data);
                }
                if($is)
                {
                    $this->session->set_flashdata("success","Record has been updated.");
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
        }
        
        header("Location:". base_url('auzaar'));
    }
    
    public function verify_aaujar()
    {
        $has = $this->Project_Model->get_today_aaujar($_POST['agent_id'], $_POST['tool']);
        
        if($has) {
            $history = "received ". $_POST['qty']. " quantity from ". get_info_of('agent', 'agent_name', $_POST['from_agent'], 'agent_id');
                
            $ph = json_decode($has->history) ?? [];
            $history = array_merge($ph, [$history]);
            
            $data = array(
              'total_qty' => isset($_POST['qty']) ? $has->total_qty + intval($_POST['qty']) : $has->total_qty,
              'updated' => date("Y-m-d H:i:s"),
              'history' => json_encode($history)
            );
            
            $this->db->where("agent_id", $_POST['agent_id'])
                ->where("tool_name", $_POST['tool'])
                ->where("DATE(created)", date('Y-m-d'))->update("crm_aaujar", $data);
            
            $this->Project_Model->update_closing_aaujar($_POST['agent_id']);
                
        }else {
            $data = array(
              'details' => '',
              'tool_name' => isset($_POST['tool']) ? strtolower($_POST['tool']) : '',
              'total_qty' => isset($_POST['qty']) ? intval($_POST['qty']) : 0,
              'used_qty' => 0,
              'closing_qty' => isset($_POST['qty']) ? intval($_POST['qty']) : 0,
              'agent_id' => $_POST['agent_id'],
              'created' => date("Y-m-d H:i:s"),
              'updated' => date("Y-m-d H:i:s")
            );
            
            $history = "received ". $_POST['qty']. " quantity from ". get_info_of('agent', 'agent_name', $_POST['from_agent'], 'agent_id');
            $data['history'] = json_encode([$history]);
            
            $this->db->insert("crm_aaujar", $data);
        }
        
        //update of from agent tool
        $has_from = $this->Project_Model->get_today_aaujar($_POST['from_agent'], $_POST['tool']);
        if($has_from) {
            
            $history = "transferred ". $_POST['qty']. " quantity to ". get_info_of('agent', 'agent_name', $_POST['agent_id'], 'agent_id');
            
            $ph = json_decode($has_from->history) ?? [];
            $history = array_merge($ph, [$history]);
            
            $data = array(
              'transfer_qty' => isset($_POST['qty']) ? $has_from->transfer_qty + intval($_POST['qty']) : $has_from->transfer_qty,
              'updated' => date("Y-m-d H:i:s"),
              'history' => json_encode($history)
            );
            
            $this->db->where("agent_id", $_POST['from_agent'])
                ->where("tool_name", $_POST['tool'])
                ->where("DATE(created)", date('Y-m-d'))->update("crm_aaujar", $data);
                
            $this->Project_Model->update_closing_aaujar($_POST['from_agent']);
        }
        
        $this->session->set_flashdata("success","Record has been updated.");
        $res['status'] = 1;
        $res['data'] = "success";
        
        header("Location:". base_url('auzaar'));
    }
    
    public function add_new_petty_cash()
    {
        $total_received = 0;
        $received_from = [];
        
        $date = isset($_POST['date']) && !empty($_POST['date']) ? date('Y-m-d', strtotime($_POST['date'])) : date('Y-m-d');
        
        $row = $this->Project_Model->getPetty($this->Auth->_auth_id() != 0 ? $this->Auth->_auth_id() : $_POST['agent_id'], $date);
        
        if(isset($_POST['pid']) && !empty($_POST['pid'])) {
            $row = $this->Project_Model->get_petty_cash($_POST['pid']);
            $received_from_old = [];
        }else {
            $received_from_old = !empty($row->received_history) ? json_decode($row->received_history) : [];
        } 
      
        
        foreach($_POST['received_from'] as $key => $rf) {
            $d = ['from'    => $rf, 'amount'    => $_POST['received_amount'][$key], 'type' => $_POST['type'][$key]];
            $received_from[] = $d;
            
            $total_received += floatval($_POST['received_amount'][$key]);
        }
        
        $data = [
            'received_history'  => json_encode(array_merge($received_from_old, $received_from)),
            'total_received'    => $total_received
        ];
        
        if(!empty($_POST['agent_id'])) {
            $data['agent_id']  = $this->Auth->_auth_id() != 0 ? $this->Auth->_auth_id() : ($_POST['agent_id']);
        }else if(!empty($this->Auth->_auth_id())) {
            $data['agent_id']  = $this->Auth->_auth_id();
        }
        
        if(isset($_POST['opening_balance']) && !empty($_POST['opening_balance'])) {
            $data['opening_balance'] = $_POST['opening_balance'];
        }
        
        $this->db->where("petty_cash_id", $row->petty_cash_id)->update("crm_petty_cash", $data);
        
        if($row){
            $this->Project_Model->updateClosingBal(date('Y-m-d', strtotime($row->created)));
        }
        
        $this->session->set_flashdata("success","Record has been updated.");
        $res['status'] = 1;
        $res['data'] = "success";
        
        header("Location:". base_url('petty-cash'));
    }
    
    public function add_new_payment()
    {
        $res = array("status"=>0, "data"=>"success");
        $id = null;
        $created_by_id = 0;
        
        if(isset($_POST) && !empty($_POST))
        {
            $created_by_id = $this->Auth->_auth_id();
            
            $data = array(
              'client_id' => isset($_POST['client_id']) ? sanitize($_POST['client_id']) : '',
              'project_id' => isset($_POST['project_id']) ? sanitize($_POST['project_id']) : '',
              'amount' => isset($_POST['amount']) ? sanitize($_POST['amount']) : '',
              'date' => isset($_POST['date']) ? date('Y-m-d', strtotime($_POST['date'])) : '',
              'type' => isset($_POST['type']) ? sanitize($_POST['type']) : '',
              'comment' => isset($_POST['comment']) ? sanitize($_POST['comment']) : '',
            );
            
            if(isset($_POST['pid']) && empty($_POST['pid']))
            {
              $data['created'] = date("Y-m-d H:i:s");
              $data['created_by_id'] = $created_by_id;
            }
            
            if(count($data)!=0)
            {
                if(isset($_POST['pid']) && !empty($_POST['pid']))
                {
                    $is = $this->Project_Model->update_client_payment($_POST['pid'], $data);
                }else{
                    $is = $this->Project_Model->add_client_payment($data);
                    $id = $is;
                }
                
                if($is)
                {
                    $this->session->set_flashdata("success","Record has been updated.");
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
            
            //send email if agent added payment
            if($created_by_id != 0 && $id) {
                $this->load->model('Email_Model');
                
                $payment = $this->db
                    ->select("crm_client_passbook.*,crm_project.project_name,crm_client.client_name,crm_agent.agent_name")
                    ->join("crm_client", "crm_client.client_id=crm_client_passbook.client_id")
                    ->join("crm_project", "crm_project.project_id=crm_client_passbook.project_id")
                    ->join("crm_agent", "crm_agent.agent_id=crm_client_passbook.created_by_id")
                    ->where("crm_client_passbook.passbook_id", $id)
                    ->get("crm_client_passbook")->row() ?? null;
                
                $html = "
                <div style='padding:10px;'>
                <h4>New payment entry has been added.</h4>
                <hr>
                <p>Client: ".($payment->client_name ?? '')."</p>
                <p>Project: ".($payment->project_name ?? '')."</p>
                <p>Type: ".($payment->type ?? '')."</p>
                <p>Amount: ₹".(number_format($payment->amount ?? 0, 2))."</p>
                <p>Added by agent: ".($payment->agent_name ?? '')."</p>
                <p>Created At: ".(date('d-m-Y h:i:s a', strtotime($payment->created)) ?? '')."</p>
                </div>
                ";
                
                $this->Email_Model->send_email(
                    get_config_item('support_email'),
                    get_config_item("company_email"),
                    get_config_item("company_name"),
                    ($payment->agent_name ?? '') ." added new payment",
                    $html,
                    "","","","php"
                );
            }
        }
        
        header("Location:". base_url($created_by_id == 0 ? 'client-payments' : 'add-payment'));
    }
    
    public function add_work_status()
    {
        $res = array("status"=>0, "data"=>"success");
        if(isset($_POST) && !empty($_POST))
        {
            $created_by_id = $this->Auth->_auth_id();
            $date = isset($_POST['date']) && !empty($_POST['date']) ? date("Y-m-d", strtotime($_POST['date'])) : date("Y-m-d");
            
            if(isset($_POST['pid']) && empty($_POST['pid'])) {
                $hasSame = $this->db->where("project_id", $_POST['project_id'])
                        ->where("DATE(created)", $date)->get("crm_work_status");
                  
                if($hasSame->num_rows() > 0) {
                    $this->session->set_flashdata("error","Already exist work status for this project for give date.");
                    header("Location:". base_url('add-work-status'));
                    exit();
                }
            }
            
            $before = $this->db->where("project_id", $_POST['project_id'])
                    ->where("created_by_id", isset($_POST['agent_id']) ? $_POST['agent_id'] : $created_by_id)
                    ->where("DATE(created)", date('Y-m-d', strtotime($date. 'yesterday')))->get("crm_work_status");
                    
            $before = $before->row() ?? null;
            
            $data = array(
              'work_status_today' => $_POST['work_status_today'] ?? '', // isset($_POST['work_status_today']) ? ($before && $before->work_status_tomorrow ? '"'.preg_replace('/"([^"]+)"/', "", $before->work_status_today).'" ' : "") . ($_POST['work_status_today']) : '',
              'work_status_tomorrow' => $_POST['work_status_tomorrow'] ?? '', //isset($_POST['work_status_tomorrow']) ? ($before && $before->day_after_status ?'"'.preg_replace('/"([^"]+)"/', "", $before->day_after_status).'" ' : "") . ($_POST['work_status_tomorrow']) : '',
              'day_after_status' => isset($_POST['day_after_status']) ? ($_POST['day_after_status']) : '',
              'client_id' => isset($_POST['client_id']) ? sanitize($_POST['client_id']) : '',
              'project_id' => isset($_POST['project_id']) ? sanitize($_POST['project_id']) : '',
              'updated' => date("Y-m-d H:i:s")
            );
            
            if(isset($_POST['pid']) && empty($_POST['pid']))
            {
              $data['created'] = isset($_POST['date']) && !empty($_POST['date']) ? date("Y-m-d H:i:s", strtotime($_POST['date'])) : date("Y-m-d H:i:s");
              $data['created_by_id'] = isset($_POST['agent_id']) ? $_POST['agent_id'] : $created_by_id;
            }
            
            if(count($data)!=0)
            {
                if(isset($_POST['pid']) && !empty($_POST['pid']))
                {
                    $is = $this->Project_Model->update_work_status($_POST['pid'], $data);
                }else{
                    $is = $this->Project_Model->add_work_status($data);
                }
                if($is)
                {
                    $this->session->set_flashdata("success","Record has been updated.");
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
        }
        
        header("Location:". base_url('work-status'));
    }
    
    
    public function get_details()
    {
        $res = array("status"=>0,"data"=>"failed");
        if(isset($_POST['id']) && !empty($_POST['id']))
        {
            $data = $this->Project_Model->get_project($_POST['id']);
            if(!empty($data))
            {
                $res['status'] = 1;
                $res['data'] = "success";
                $res['a'] = $data;
            }
        }
        
        print_r(json_encode($res));
    }
    
    public function del_project()
    {
        $this->Auth->_check_Aauth();
        if(isset($_GET['d']) && !empty($_GET['d']))
        {
            $id = $_GET['d'];
            $this->db->where("project_id", base64_decode($id));
            $q = $this->db->get("crm_project_expenses");
            
            if($q->num_rows() === 0){
                $is = $this->Project_Model->delete_project($_GET['d']);
                $this->session->set_flashdata("success","Record has been updated.");
            }else{
                $this->session->set_flashdata("error","Project is used so can not be deleted!");
            }
        }
        
        redirect('projects');
    }
    
    public function del_auzaar()
    {
        $this->Auth->_check_auth();
        if(isset($_GET['d']) && !empty($_GET['d']))
        {
            $is = $this->Project_Model->delete_aaujar($_GET['d']);
            $this->session->set_flashdata("success","Record has been updated.");
        }
        
        redirect('auzaar');
    }
    
    public function del_site_issue_category()
    {
        $this->Auth->_check_Aauth();
        if(isset($_GET['d']) && !empty($_GET['d']))
        {
            $is = $this->Project_Model->del_site_issue_category($_GET['d']);
            $this->session->set_flashdata("success","Record has been updated.");
        }
        
        redirect('site-issue-category');
    }
    
    public function del_petty_cash()
    {
        $this->Auth->_check_auth();
        if(isset($_GET['d']) && !empty($_GET['d']))
        {
            $is = $this->Project_Model->delete_petty_cash($_GET['d']);
            $this->session->set_flashdata("success","Record has been updated.");
        }
        
        redirect('petty-cash');
    }
    
    public function del_payment()
    {
        $this->Auth->_check_Aauth();
        if(isset($_GET['d']) && !empty($_GET['d']))
        {
            $is = $this->Project_Model->del_payment($_GET['d']);
            $this->session->set_flashdata("success","Record has been updated.");
        }
        
        redirect('client-payments');
    }
    
    public function del_work_status()
    {
        // $this->Auth->_check_Aauth();
        if(isset($_GET['d']) && !empty($_GET['d']))
        {
            $is = $this->Project_Model->del_work_status($_GET['d']);
            $this->session->set_flashdata("success","Record has been updated.");
        }
        
        redirect('work-status');
    }
    
    public function del_burning_report()
    {
        $this->Auth->_check_auth();
        if(isset($_GET['d']) && !empty($_GET['d']))
        {
            $is = $this->Project_Model->del_burning_report($_GET['d']);
            $this->session->set_flashdata("success","Record has been updated.");
        }
        
        redirect('burning-report');
    }
}
?>