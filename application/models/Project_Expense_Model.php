<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Project_Expense_Model extends CI_Model {
    
    private static $d;
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $d = $this->db->dbprefix;
    }
    
    public function add_new($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."project_expenses"))
        {
            $totalExpense = $this->db->where("created_by_id", $data['created_by_id'])
                ->select("SUM(total_price) as total_expense")
                ->where("DATE(created)", date('Y-m-d', strtotime('2023-08-28')))
                ->where("type!=", "credit")
                ->get(self::$d."project_expenses");
                
            if($totalExpense->num_rows() > 0) {
                $totalExpense = $totalExpense->row()->total_expense ?? 0;
            }else {
                $totalExpense = 0;
            }
            
            $this->db->insert(self::$d."project_expenses", $data);
            $id = $this->db->insert_id();
            
            if($id) {
                //save it to petty cash
                if(!empty($data['created_by_id']) && $data['created_by_id'] != 0) {
                    $q = $this->db->where("agent_id", $data['created_by_id'])
                        ->where("DATE(created)", date('Y-m-d'))->get(self::$d."petty_cash");
                    
                    if($q->num_rows() > 0) {
                        $pc = $q->row();
                        
                        $this->db->where("petty_cash_id", $pc->petty_cash_id)->update(self::$d."petty_cash", [
                            'total_expense' => $totalExpense > 0 ? $totalExpense + ($data['type'] != 'credit' ? $data['total_price'] : 0) : ($pc->total_expense + ($data['type'] != 'credit' ? $data['total_price'] : 0))
                        ]);
                    }else {
                        $opening_bal = 0;
                        
                        $qp = $this->db->where("agent_id", $data['created_by_id'])
                        ->where("DATE(created)", date('Y-m-d', strtotime('yesterday')))->get(self::$d."petty_cash");
                        
                        if($qp->num_rows() > 0) {
                            $opening_bal = $qp->row()->closing_balace ?? 0;
                        }
                        
                        $this->db->insert(self::$d."petty_cash", [
                            'opening_balance' => $opening_bal ?? 0,
                            'agent_id'  => $data['created_by_id'],
                            'total_expense' => $data['type'] != 'credit' ? $data['total_price'] : 0
                        ]);
                    }
                }
            }
            
            return $id;
        }else{
            return false;
        }
    }
    
    public function add_new_category($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."crm_expense_category"))
        {
            $this->db->insert(self::$d."crm_expense_category", $data);
            $id = $this->db->insert_id();
            return $id;
        }else{
            return false;
        }
    }
    
    
    public function update_new($id, $data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."project_expenses"))
        {
            $exp = $this->db->where("expense_id", base64_decode($id))->get(self::$d."project_expenses")->row();
            
            if($exp) {
                //update it to petty cash
                if(!empty($exp->created_by_id) && $exp->created_by_id != 0) {
                    $q = $this->db->where("agent_id", $exp->created_by_id)
                        ->where("DATE(created)", date('Y-m-d', strtotime($exp->created)))
                        ->get(self::$d."petty_cash");
                    
                    if($q->num_rows() > 0) {
                        $pc = $q->row();
                        
                        $this->db->where("petty_cash_id", $pc->petty_cash_id)->update(self::$d."petty_cash", [
                            'total_expense' => ($pc->total_expense - $exp->total_price) + ($data['type'] != 'credit' ? $data['total_price'] : 0)
                        ]);
                    }
                }
            }
            
            $this->db->where("expense_id", base64_decode($id));
            $this->db->update(self::$d."project_expenses", $data);
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function delete_project_expense($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."project_expenses"))
        {
            $expense = $this->db->where("expense_id", base64_decode($id))->get(self::$d."project_expenses");
            if($expense->num_rows() > 0) {
                $row = $expense->row();
                
                $q = $this->db->where("agent_id", $row->created_by_id)
                            ->where("DATE(created)", date('Y-m-d', strtotime($row->created)))
                            ->get(self::$d."petty_cash");
                
                if($q->num_rows() > 0) {
                    $pc = $q->row();
                    
                    $this->db->where("petty_cash_id", $pc->petty_cash_id)->update(self::$d."petty_cash", [
                        'total_expense' => $pc->total_expense - $row->total_price
                    ]);
                }
            }
            
            $this->db->where("expense_id", base64_decode($id));
            $this->db->delete(self::$d."project_expenses");
            $id = $this->db->affected_rows();
            return $id;
        }
    }
    
    public function get_all($id = 0)
    {
        if($this->db->table_exists(self::$d."project_expenses"))
        {
            $this->db->order_by("created","desc");
            
            if(!empty($id)) {
                $this->db->where("DATE(crm_project_expenses.created) <=", date('Y-m-d'));
                $this->db->where(self::$d."project_expenses.created_by_id", $id);
            }
            
            if(isset($_GET['agent']) && !empty($_GET['agent'])) {
                $this->db->where(self::$d."project_expenses.created_by_id", $_GET['agent']);
            }
            
            if(isset($_GET['project']) && !empty($_GET['project'])) {
                $this->db->where(self::$d."project_expenses.project_id", $_GET['project']);
            }
            
            if(isset($_GET['client']) && !empty($_GET['client'])) {
                $this->db->where(self::$d."project_expenses.client_id", $_GET['client']);
            }
            
            if(isset($_GET['category']) && !empty($_GET['category'])) {
                $this->db->where(self::$d."project_expenses.category", $_GET['category']);
            }
            
            if(isset($_GET['type']) && !empty($_GET['type'])) {
                $this->db->where_in(self::$d."project_expenses.type", $_GET['type']);
            }
            
            if(isset($_GET['date']) && !empty($_GET['date'])) {
                $this->db->where("DATE(crm_project_expenses.created)", date('Y-m-d', strtotime($_GET['date'])));
            }else {
                if(count($_GET) === 0 && $this->uri->segment(1) !== 'report') {
                    $this->db->where("DATE(crm_project_expenses.created)", date('Y-m-d'));
                }
            }
            
            if(isset($_GET['from_date']) && !empty($_GET['from_date'])) {
                $this->db->where("DATE(crm_project_expenses.created) >=", date('Y-m-d', strtotime($_GET['from_date'])));
            }
            
            if(isset($_GET['to_date']) && !empty($_GET['to_date'])) {
                $this->db->where("DATE(crm_project_expenses.created) <=", date('Y-m-d', strtotime($_GET['to_date'])));
            }
            
            if(isset($_GET['month']) && !empty($_GET['month'])) {
                $this->db->where("MONTH(crm_project_expenses.created)", $_GET['month']);
            }
            
            if(isset($_GET['project_status']) && $_GET['project_status']!=='') {
                $this->db->where(self::$d."project.status", $_GET['project_status']);
            }else {
                $this->db->where(self::$d."project.status", 1);
            }
            
            $this->db->select(self::$d."project_expenses.*,".self::$d."client.client_name,".self::$d."project.project_name");
            $this->db->join(self::$d."client", self::$d."client.client_id=".self::$d."project_expenses.client_id");
            $this->db->join(self::$d."project", self::$d."project.project_id=".self::$d."project_expenses.project_id");
            $q = $this->db->get(self::$d."project_expenses");
            
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
    
    public function get_all_category($id = 0)
    {
        if($this->db->table_exists(self::$d."crm_expense_category"))
        {
            $this->db->order_by("name","asc");
            $q = $this->db->get(self::$d."crm_expense_category");
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
    
    public function get_project_expense($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."project_expenses"))
        {
            $this->db->where("expense_id", base64_decode($id));
            $this->db->select(self::$d."project_expenses.*,".self::$d."client.client_name,".self::$d."project.project_name");
            $this->db->join(self::$d."client", self::$d."client.client_id=".self::$d."project_expenses.client_id");
            $this->db->join(self::$d."project", self::$d."project.project_id=".self::$d."project_expenses.project_id");
            $q = $this->db->get(self::$d."project_expenses");
            
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
        $this->db->where("project_expenses_id", base64_decode($id));
        $q = $this->db->get(self::$d."project_expenses_expenses");
        
        if($q->num_rows() > 0)
        {
            return true;
        }else{
            return false;
        }
    }
}
?>
