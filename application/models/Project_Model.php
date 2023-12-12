<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Project_Model extends CI_Model {
    
    private static $d;
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $d = $this->db->dbprefix;
    }
    
    public function add_new($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."project"))
        {
            $this->db->insert(self::$d."project", $data);
            $id = $this->db->insert_id();
            return $id;
        }else{
            return false;
        }
    }
    
    public function add_new_site_issue_category($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."site_issue_category"))
        {
            $this->db->insert(self::$d."site_issue_category", $data);
            $id = $this->db->insert_id();
            return $id;
        }else{
            return false;
        }
    }
    
    public function add_new_aaujar_name($data)
    {
       if(!empty($data) && $this->db->table_exists(self::$d."auzaar_name"))
        {
            $is = $this->db->where("name", trim(strtolower($data['name'])))->get(self::$d."auzaar_name");
            if($is->num_rows() === 0) {
                $this->db->insert(self::$d."auzaar_name", $data);
                $id = $this->db->insert_id();
                return $id;
            }else {
                return $is->row()->auzaar_name_id ?? '';   
            }
        }else{
            return false;
        } 
    }
    
    
    public function add_new_aaujar($data)
    {
       if(!empty($data) && $this->db->table_exists(self::$d."aaujar"))
        {
            $this->db->insert(self::$d."aaujar", $data);
            $id = $this->db->insert_id();
            return $id;
        }else{
            return false;
        } 
    }
    
    public function add_new_burning_report($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."burning_report"))
        {
            $this->db->insert(self::$d."burning_report", $data);
            $id = $this->db->insert_id();
            return $id;
        }else{
            return false;
        }
    }
    
    public function add_work_status($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."work_status"))
        {
            $this->db->insert(self::$d."work_status", $data);
            $id = $this->db->insert_id();
            return $id;
        }else{
            return false;
        }
    }
    
    public function updateClosingBal($date = '')
    {
        // if(!empty($date)) {
        //     $this->db->where("DATE(created) >=", $date);
        // }
        
        $q = $this->db
            ->get(self::$d."petty_cash");
        
        if($q->num_rows() > 0) {
            foreach($q->result() as $p) {
                
                $before = $this->db->where("agent_id", $p->agent_id)
                    ->where("DATE(created)", date('Y-m-d', strtotime($p->created . 'yesterday')))->get(self::$d."petty_cash");
                    
                $before = $before->row() ?? null;
                
                $totalExpense = $this->db->select("SUM(total_price) as total")
                ->where("created_by_id", $p->agent_id)->where("type !=", "credit")
                ->where("DATE(created)", date('Y-m-d', strtotime($p->created)))
                ->get(self::$d."project_expenses")->row()->total ?? 0;
                
                $newOpening = $before ? $before->closing_balance : $p->opening_balance;
                
                $this->db->where("petty_cash_id", $p->petty_cash_id)
                    ->update(self::$d."petty_cash", [
                        'opening_balance'   => $newOpening,//$p->opening_balance == 0 ? ($before ? $before->closing_balance : $p->opening_balance) : $p->opening_balance,
                        'total_expense'     => $totalExpense,
                        'closing_balance'   => ($newOpening + $p->total_received) - $totalExpense
                    ]);
            }
        }
    }
    
    public function initiateWorkStatus()
    {
        $date = isset($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : date('Y-m-d');
        
        $q = $this->db
            ->where("status", 1)
            ->get(self::$d."project");
            
        if($q->num_rows() > 0) {
            $projects = $q->result();
            
            foreach($projects as $a) {
                $pcash = $this->db->where("project_id", $a->project_id)
                    ->where("DATE(created)", $date)->get(self::$d."work_status");
                    
                if($pcash->num_rows() == 0) {
                    
                    $before = $this->db->where("project_id", $a->project_id)
                    ->where("DATE(created)", date('Y-m-d', strtotime('yesterday')))->get(self::$d."work_status");
                    
                    $before = $before->row() ?? null;
                    
                    $data = array(
                      'work_status_today' => '', //$before && $before->work_status_tomorrow ? '"'.$before->work_status_tomorrow.'" ' : '',
                      'work_status_tomorrow' => '', //$before && $before->day_after_status ? '"'.$before->day_after_status.'" ' : '',
                      'day_after_status' => '',
                      'client_id' => $a->client_id,
                      'project_id' => $a->project_id,
                      'created_by_id' => $before->created_by_id ?? 0,
                      'created' => date("Y-m-d H:i:s", strtotime($date)),
                      'updated' => date("Y-m-d H:i:s")
                    );
                    
                    $this->db->insert(self::$d."work_status", $data);
                }
            }
        }
    }
    
    public function initiateTool()
    {
        $date = date('Y-m-d');
        
        $q = $this->db
            ->get(self::$d."agent");
            
        if($q->num_rows() > 0) {
            $agents = $q->result();
            
            foreach($agents as $a) {
                $pcash = $this->db->where("agent_id", $a->agent_id)
                    ->where("DATE(created)", $date)->get(self::$d."aaujar");
                    
                if($pcash->num_rows() == 0) {
                    
                    $before = $this->db->where("agent_id", $a->agent_id)
                    ->where("DATE(created)", date('Y-m-d', strtotime($date . 'yesterday')))->get(self::$d."aaujar");
                    
                    $before = $before->row() ?? null;
                    
                    if($before) {
                        $data = [
                          'tool_name' => $before ? $before->tool_name: '',
                          'details' => $before ? $before->details: '',
                          'total_qty' => $before ? $before->closing_qty : 0,
                          'agent_id' => $a->agent_id,
                          'history'  => json_encode(['total qty: '. ($before ? $before->closing_qty : 0)])
                        ];
                        
                        $this->db->insert(self::$d."aaujar", $data);
                    }
                }
            }
        }
    }
    
    public function initiatePettyCash()
    {
        $date = date('Y-m-d');
        
        $q = $this->db
            ->get(self::$d."agent");
            
        if($q->num_rows() > 0) {
            $agents = $q->result();
            
            foreach($agents as $a) {
                $pcash = $this->db->where("agent_id", $a->agent_id)
                    ->where("DATE(created)", $date)->get(self::$d."petty_cash");
                    
                if($pcash->num_rows() == 0) {
                    
                    $before = $this->db->where("agent_id", $a->agent_id)
                    ->where("DATE(created)", date('Y-m-d', strtotime($date . 'yesterday')))->get(self::$d."petty_cash");
                    
                    $before = $before->row() ?? null;
                    
                    $data = [
                      'opening_balance' => $before ? $before->closing_balance : 0,
                      'agent_id' => $a->agent_id,
                      'total_received' => 0,
                      'total_expense' => 0,
                      'closing_balance' => 0
                    ];
                    
                    $this->db->insert(self::$d."petty_cash", $data);
                }
            }
        }
    }
    
    public function get_all_petty_cash($id = '')
    {
        if(isset($_GET['date']) && !empty($_GET['date'])) {
            $this->db->where("DATE(created)", date("Y-m-d", strtotime($_GET['date'])));
        }else if(empty($_GET['agent']) && $this->uri->segment(1) !== 'report'){
            $this->db->where("DATE(created)", date("Y-m-d"));
        }
        
        if(isset($_GET['agent']) && !empty($_GET['agent'])) {
            $this->db->where("agent_id", $_GET['agent']);
        }
        
        if(!empty($id)) {
            $this->db->where("agent_id", $id);
        }
        
       $q = $this->db->order_by("created", "desc")->get(self::$d."petty_cash");
        
        return $q->result();
    }
    
    public function get_all_aaujar_names()
    {
       $q = $this->db->order_by("name", "desc")->get(self::$d."auzaar_name");
        return $q->result();
    }
    
    public function get_all_aaujars($id = '')
    {
        if(isset($_GET['date']) && !empty($_GET['date'])) {
            $this->db->where("DATE(crm_aaujar.created)", date("Y-m-d", strtotime($_GET['date'])));
        }else if(empty($_GET['agent']) && $this->uri->segment(1) !== 'report'){
            $this->db->where("DATE(crm_aaujar.created)", date("Y-m-d"));
        }
        
        if(isset($_GET['agent']) && !empty($_GET['agent'])) {
            $this->db->where("crm_aaujar.agent_id", $_GET['agent']);
        }
        
        if(isset($_GET['tool_name']) && !empty($_GET['tool_name'])) {
            $this->db->where("crm_aaujar.tool_name", $_GET['tool_name']);
        }
        
        if(!empty($id)) {
            $this->db->where("crm_aaujar.agent_id", $id);
        }
        
        $this->db->select(self::$d."aaujar.*,".self::$d."agent.agent_name");
        $this->db->join(self::$d."agent", self::$d."agent.agent_id=".self::$d."aaujar.agent_id");
        $q = $this->db->get(self::$d."aaujar");
        
        return $q->result();
    }
    
    public function get_all_burning_report($id = '')
    {
        if(isset($_GET['date']) && !empty($_GET['date'])) {
            $this->db->where("DATE(crm_burning_report.created)", date("Y-m-d", strtotime($_GET['date'])));
        }
        
        if(isset($_GET['agent']) && !empty($_GET['agent'])) {
            $this->db->where("crm_burning_report.agent_id", $_GET['agent']);
        }
        
        if(isset($_GET['client']) && !empty($_GET['client'])) {
            $this->db->where("crm_burning_report.client_id", $_GET['client']);
        }
        
        if(isset($_GET['project']) && !empty($_GET['project'])) {
            $this->db->where("crm_burning_report.project_id", $_GET['project']);
        }
        
        if(isset($_GET['category_id']) && !empty($_GET['category_id'])) {
            $this->db->where("crm_burning_report.category_id", $_GET['category_id']);
        }
        
        // if(!empty($id)) {
        //     $this->db->where("crm_burning_report.agent_id", $id);
        // }
        
        $this->db->select(self::$d."burning_report.*,".self::$d."client.client_name,".self::$d."project.project_name,".self::$d."site_issue_category.name as category_name");
        $this->db->join(self::$d."client", self::$d."client.client_id=".self::$d."burning_report.client_id");
        // $this->db->join(self::$d."agent", self::$d."agent.agent_id=".self::$d."burning_report.agent_id");
        $this->db->join(self::$d."project", self::$d."project.project_id=".self::$d."burning_report.project_id");
        $this->db->join(self::$d."site_issue_category", self::$d."site_issue_category.issue_category_id=".self::$d."burning_report.category_id");
        $q = $this->db->order_by(self::$d."site_issue_category.name", "asc")->get(self::$d."burning_report");
        
        return $q->result();
    }
    
    public function getPetty($id, $date)
    {
        $row = null;
        
        if($id != 0) {
            $q = $this->db->where("agent_id", $id)->where("DATE(created)", $date)
                ->get(self::$d."petty_cash");
                
            $old = $this->db->where("agent_id", $id)->where("DATE(created)", date("Y-m-d", strtotime($date . "yesterday")))
                ->get(self::$d."petty_cash");
                
            if($q->num_rows() > 0) {
                $row = $q->row();
            }else {
                $oldRow = $old->num_rows() > 0 ? $old->row() : null;
                
                $data = [
                  'agent_id'    => $id,
                  'opening_balance' => $oldRow ? $oldRow->closing_balance : 0,
                  'created' => date('Y-m-d H:i:s', strtotime($date))
                ];
                
                $this->db->insert(self::$d."petty_cash", $data);
                $row = $this->db->where('petty_cash_id', $this->db->insert_id())->get(self::$d."petty_cash")->row();
            }
        }
        
        return $row;
    }
    
    public function get_petty_cash($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."petty_cash"))
        {
            $this->db->where("petty_cash_id", base64_decode($id));
            $q = $this->db->get(self::$d."petty_cash");
            
            if($q->num_rows() > 0)
            {
                return $q->row();
            }else{
                return '';
            }
            
        }else{
            return '';
        }
    }
    
    public function get_aaujar($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."aaujar"))
        {
            $this->db->where("aaujar_id", base64_decode($id));
            $q = $this->db->get(self::$d."aaujar");
            
            if($q->num_rows() > 0)
            {
                return $q->row();
            }else{
                return '';
            }
            
        }else{
            return '';
        }   
    }
    
    public function get_site_issue_category($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."site_issue_category"))
        {
            $this->db->where("issue_category_id", base64_decode($id));
            $q = $this->db->get(self::$d."site_issue_category");
            
            if($q->num_rows() > 0)
            {
                return $q->row();
            }else{
                return '';
            }
            
        }else{
            return '';
        }   
    }
    
    public function get_today_aaujar($id, $tool = '')
    {
        if(!empty($id) && $this->db->table_exists(self::$d."aaujar"))
        {
            $this->db->where("agent_id", $id);
            $this->db->where("tool_name", $tool);
            $this->db->where("DATE(created)", date('Y-m-d'));
            $q = $this->db->get(self::$d."aaujar");
            
            if($q->num_rows() > 0)
            {
                return $q->row();
            }else{
                return '';
            }
            
        }else{
            return '';
        }   
    }
    
    public function update_closing_aaujar($id = '')
    {
        if(!empty($id) && $this->db->table_exists(self::$d."aaujar"))
        {
            if(!empty($id)) {
                $this->db->where("agent_id", $id);
            }
            
            $this->db->where("DATE(created)", date('Y-m-d'));
            $q = $this->db->get(self::$d."aaujar");
            
            if($q->num_rows() > 0)
            {
                $result = $q->result();
                
                foreach($result as $r) {
                    $data = [
                        'closing_qty' => $r->total_qty - ($r->used_qty + $r->transfer_qty)  
                    ];
                    
                    $this->db->where("aaujar_id", $r->aaujar_id)->update(self::$d."aaujar", $data);
                }
            }else{
                return '';
            }
            
        }else{
            return '';
        }   
    }
    
    
    public function get_burning_report($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."burning_report"))
        {
            $this->db->select(self::$d."burning_report.*,".self::$d."client.client_name,".self::$d."agent.agent_name");
            $this->db->join(self::$d."client", self::$d."client.client_id=".self::$d."burning_report.client_id");
            $this->db->join(self::$d."agent", self::$d."agent.agent_id=".self::$d."burning_report.agent_id");
            $this->db->where("burning_report_id", base64_decode($id));
            $q = $this->db->get(self::$d."burning_report");
            
            if($q->num_rows() > 0)
            {
                return $q->row();
            }else{
                return '';
            }
            
        }else{
            return '';
        }
    }
    
    public function add_client_payment($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."client_passbook"))
        {
            $this->db->insert(self::$d."client_passbook", $data);
            $id = $this->db->insert_id();
            return $id;
        }else{
            return false;
        }
    }
    
    
    public function update_new($id, $data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."project"))
        {
            $this->db->where("project_id", base64_decode($id));
            $this->db->update(self::$d."project", $data);
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update_site_issue_category($id, $data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."site_issue_category"))
        {
            $this->db->where("issue_category_id", base64_decode($id));
            $this->db->update(self::$d."site_issue_category", $data);
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update_new_aaujar($id, $data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."aaujar"))
        {
            $this->db->where("aaujar_id", base64_decode($id));
            $this->db->update(self::$d."aaujar", $data);
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update_new_burning_report($id, $data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."burning_report"))
        {
            $this->db->where("burning_report_id", base64_decode($id));
            $this->db->update(self::$d."burning_report", $data);
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update_client_payment($id, $data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."client_passbook"))
        {
            $this->db->where("passbook_id", base64_decode($id));
            $this->db->update(self::$d."client_passbook", $data);
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update_work_status($id, $data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."work_status"))
        {
            $this->db->where("work_status_id", base64_decode($id));
            $this->db->update(self::$d."work_status", $data);
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function delete_project($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."project"))
        {
            $this->db->where("project_id", base64_decode($id));
            $this->db->delete(self::$d."project");
            $id = $this->db->affected_rows();
            return $id;
        }
    }
    
    public function delete_aaujar($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."aaujar"))
        {
            $this->db->where("aaujar_id", base64_decode($id));
            $this->db->delete(self::$d."aaujar");
            $id = $this->db->affected_rows();
            return $id;
        }   
    }
    
    public function del_site_issue_category($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."site_issue_category"))
        {
            $this->db->where("issue_category_id", base64_decode($id));
            $this->db->delete(self::$d."site_issue_category");
            $id = $this->db->affected_rows();
            return $id;
        }   
    }
    
    public function delete_petty_cash($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."petty_cash"))
        {
            $this->db->where("petty_cash_id", base64_decode($id));
            $this->db->delete(self::$d."petty_cash");
            $id = $this->db->affected_rows();
            return $id;
        }
    }
    
    public function del_work_status($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."work_status"))
        {
            $this->db->where("work_status_id", base64_decode($id));
            $this->db->delete(self::$d."work_status");
            $id = $this->db->affected_rows();
            return $id;
        }
    }
    
    public function del_burning_report($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."burning_report"))
        {
            $this->db->where("burning_report_id", base64_decode($id));
            $this->db->delete(self::$d."burning_report");
            $id = $this->db->affected_rows();
            return $id;
        }
    }
    
    public function del_payment($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."client_passbook"))
        {
            $this->db->where("passbook_id", base64_decode($id));
            $this->db->delete(self::$d."client_passbook");
            $id = $this->db->affected_rows();
            return $id;
        }
    }
    
    public function get_all_active()
    {
        $id = auth_id();
        
        if(isset($_GET['agent']) && $_GET['agent'] !== "") {
            $this->db->where("created_by_id", $_GET['agent']);
            $this->db->where("DATE(created)", date('Y-m-d'));
        }
        
        if(isset($_GET['project']) && !empty($_GET['project'])) {
            $this->db->where("project_id", $_GET['project']);
        }
        
        if(isset($_GET['client']) && !empty($_GET['client'])) {
            $this->db->where("client_id", $_GET['client']);
        }
        
        if($id!=0) {
            $this->db->where("created_by_id", $id);
            if(!isset($_GET['date'])){
                $this->db->where("DATE(created)", date('Y-m-d'));
            }else {
                $this->db->where("DATE(created)", date('Y-m-d', strtotime($_GET['date'])));
            }
        }
        
        $q = $this->db->select("GROUP_CONCAT(project_id) as ids")->get(self::$d."work_status");
        
        $projectIds = $q->num_rows() > 0 ? explode(",", $q->row()->ids) : [];
        
        $this->db->where("status", 1);
        
        /*if(count($projectIds) > 0) {
            $this->db->where_in(self::$d."project.project_id", array_unique($projectIds));
        }*/
        
        $this->db->select(self::$d."project.*,".self::$d."client.client_name");
        $this->db->join(self::$d."client", self::$d."client.client_id=".self::$d."project.client_id");
        $this->db->order_by(self::$d."project.project_name", "asc");
        $q2 = $this->db->get(self::$d."project");
        
        if($q2->num_rows() > 0)
        {
            return $q2->result();
        }else{
            return '';
        }
    }
    
    public function get_all_active_lead()
    {
        $id = auth_id();
     
        if(isset($_GET['agent']) && $_GET['agent'] !== "") {
            $this->db->where("commented_by", $_GET['agent']);
            $this->db->where("DATE(followup_date)", date('Y-m-d', strtotime('tomorrow')));
        }
        
        if($id!=0) {
            $this->db->where("commented_by", $id);
            if(!isset($_GET['date'])){
                $this->db->where("DATE(followup_date)", date('Y-m-d', strtotime('tomorrow')));
            }else {
                $this->db->where("DATE(followup_date)", date('Y-m-d', strtotime($_GET['date'])));
            }
        }
        
        $q = $this->db->select("GROUP_CONCAT(lead_id) as ids")->get(self::$d."followup");
        $leadIds = $q->num_rows() > 0 ? explode(",", $q->row()->ids) : [];
        
        $this->db->where("status", 16);
        
        if(count($leadIds) > 0) {
            $this->db->where_in(self::$d."lead.lead_id", array_unique($leadIds));
        }
        
        $this->db->select(self::$d."lead.*,");
        $this->db->order_by(self::$d."lead.full_name", "asc");
        $q2 = $this->db->get(self::$d."lead");
        
        if($q2->num_rows() > 0)
        {
            return $q2->result();
        }else{
            return '';
        }
    }
    
    public function get_all($activeOnly = false)
    {
        if($this->db->table_exists(self::$d."project"))
        {
            $this->db->order_by("project_name","asc");
            
            if(isset($_GET['project_status']) && $_GET['project_status']!=='') {
                $this->db->where("status", $_GET['project_status']);
            }else {
                $this->db->where("status", 1);
            }
            
            if(isset($_GET['client']) && !empty($_GET['client'])) {
                $this->db->where(self::$d."client.client_id", $_GET['client']);
            }
            
            if($activeOnly) {
                $this->db->where("status", 1);    
            }
            
            $this->db->select(self::$d."project.*,".self::$d."client.client_name");
            $this->db->join(self::$d."client", self::$d."client.client_id=".self::$d."project.client_id");
            $q = $this->db->get(self::$d."project");
            
            if($q->num_rows() > 0)
            {
                return $q->result();
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
    
    public function get_all_site_issue_category()
    {
        if($this->db->table_exists(self::$d."site_issue_category"))
        {
            $this->db->order_by("name","asc");
            
            $q = $this->db->get(self::$d."site_issue_category");
            
            if($q->num_rows() > 0)
            {
                return $q->result();
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
    
    public function get_project($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."project"))
        {
            $this->db->where("project_id", base64_decode($id));
            $q = $this->db->get(self::$d."project");
            
            if($q->num_rows() > 0)
            {
                return $q->row();
            }else{
                return '';
            }
            
        }else{
            return '';
        }
    }
    
    public function get_client_payment($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."client_passbook"))
        {
            $this->db->where("passbook_id", base64_decode($id));
            
            $this->db->select(self::$d."client_passbook.*,".self::$d."client.client_name,".self::$d."project.project_name");
            $this->db->join(self::$d."client", self::$d."client.client_id=".self::$d."client_passbook.client_id");
            $this->db->join(self::$d."project", self::$d."project.project_id=".self::$d."client_passbook.project_id");
            $q = $this->db->get(self::$d."client_passbook");
            
            if($q->num_rows() > 0)
            {
                return $q->row();
            }else{
                return '';
            }
            
        }else{
            return '';
        }
    }
    
    public function get_all_work_status($id = 0, $list = false)
    {
        if($this->db->table_exists(self::$d."work_status"))
        {
            // $this->db->order_by("work_status_id","desc");
            
            if(isset($_GET['from_date']) && !empty($_GET['from_date'])) {
                $this->db->where("DATE(crm_work_status.created) >=", date('Y-m-d', strtotime($_GET['from_date'])));
                
                if(isset($_GET['end_date']) && !empty($_GET['end_date'])) {
                    $this->db->where("DATE(crm_work_status.created) <=", date('Y-m-d', strtotime($_GET['end_date'])));
                }
            }else if($this->uri->segment(1) !== 'report') {
                /*if($list) {
                    $this->db->where("DATE(crm_work_status.created)", date('Y-m-d', strtotime('yesterday')));
                }else {*/
                    $this->db->where("DATE(crm_work_status.created)", date('Y-m-d'));
                //}
            }
            
            if(!empty($id)) {
                $this->db->where("DATE(crm_work_status.created) <=", date('Y-m-d'));
                $this->db->where(self::$d."work_status.created_by_id", $id);
            }
            
            if(isset($_GET['agent']) && !empty($_GET['agent'])) {
                $this->db->where(self::$d."work_status.created_by_id", $_GET['agent']);
            }
            
            if(isset($_GET['project']) && !empty($_GET['project'])) {
                $this->db->where(self::$d."work_status.project_id", $_GET['project']);
            }
            
            if(isset($_GET['client']) && !empty($_GET['client'])) {
                $this->db->where(self::$d."work_status.client_id", $_GET['client']);
            }
            
            $this->db->where(self::$d."project.status", 1);
            $this->db->select(self::$d."work_status.*,".self::$d."client.client_name,".self::$d."project.project_name");
            $this->db->join(self::$d."client", self::$d."client.client_id=".self::$d."work_status.client_id");
            $this->db->join(self::$d."project", self::$d."project.project_id=".self::$d."work_status.project_id");
            $this->db->order_by(self::$d."client.client_name", "asc");
            $q = $this->db->get(self::$d."work_status");
            
            if($q->num_rows() > 0)
            {
                return $q->result();
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
    
    public function get_all_client_payments($id = 0)
    {
        $id = auth_id();
        
        if($this->db->table_exists(self::$d."client_passbook"))
        {
            $this->db->order_by("date","desc");
            
            if(isset($_GET['date']) && !empty($_GET['date'])) {
                $this->db->where("DATE(crm_client_passbook.date)", date('Y-m-d', strtotime($_GET['date'])));
            }else {
                // $this->db->where("DATE(crm_client_passbook.date)", date('Y-m-d'));
            }
            
            if(isset($_GET['type']) && !empty($_GET['type'])) {
                $this->db->where(self::$d."client_passbook.type", $_GET['type']);
            }
            
            if(isset($_GET['agent']) && !empty($_GET['agent'])) {
                $this->db->where(self::$d."client_passbook.created_by_id", $_GET['agent']);
            }else {
                
                if($id!=0) {
                    $this->db->where(self::$d."client_passbook.created_by_id", $id);
                }
            }
            
            if(isset($_GET['project']) && !empty($_GET['project'])) {
                $this->db->where(self::$d."client_passbook.project_id", $_GET['project']);
            }
            
            if(isset($_GET['client']) && !empty($_GET['client'])) {
                $this->db->where(self::$d."client_passbook.client_id", $_GET['client']);
            }
            
            $this->db->select(self::$d."client_passbook.*,".self::$d."client.client_name,".self::$d."project.project_name");
            $this->db->join(self::$d."client", self::$d."client.client_id=".self::$d."client_passbook.client_id");
            $this->db->join(self::$d."project", self::$d."project.project_id=".self::$d."client_passbook.project_id");
            $q = $this->db->get(self::$d."client_passbook");
            if($q->num_rows() > 0)
            {
                return $q->result();
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
    
    public function get_work_status($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."work_status"))
        {
            $this->db->select(self::$d."work_status.*,".self::$d."client.client_name,".self::$d."project.project_name");
            $this->db->join(self::$d."client", self::$d."client.client_id=".self::$d."work_status.client_id");
            $this->db->join(self::$d."project", self::$d."project.project_id=".self::$d."work_status.project_id");
            $this->db->where("work_status_id", base64_decode($id));
            $q = $this->db->get(self::$d."work_status");
            
            if($q->num_rows() > 0)
            {
                return $q->row();
            }else{
                return '';
            }
            
        }else{
            return '';
        }
    }
    
    public function is_used($id)
    {
        $this->db->where("project_id", base64_decode($id));
        $q = $this->db->get(self::$d."project_expenses");
        
        if($q->num_rows() > 0)
        {
            return true;
        }else{
            return false;
        }
    }
}
?>
