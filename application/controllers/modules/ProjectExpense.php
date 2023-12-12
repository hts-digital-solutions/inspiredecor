<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class ProjectExpense extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('security');
        $this->load->helper('sconfig_helper');
        $this->load->helper('client_helper');
        $this->load->model('Project_Expense_Model');
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
            
            $otherExpense = isset($_POST['expense_name']) ? sanitize($_POST['expense_name']) : '';
            
            if(isset($_POST['category']) && $_POST['category'] ==='other') {
                $this->Project_Expense_Model->add_new_category(['name'  => trim($otherExpense)]);
                $_POST['category'] = strtolower($otherExpense);
            }
            
            $data = array(
              'project_id' => isset($_POST['project_id']) ? sanitize($_POST['project_id']) : '',
              'client_id' => isset($_POST['client_id']) ? sanitize($_POST['client_id']) : '',
              'category' => isset($_POST['category']) ? sanitize(trim(strtolower($_POST['category']))) : '',
              'quantity' => isset($_POST['quantity']) ? sanitize($_POST['quantity']) : '',
              'total_price' => isset($_POST['total_price']) ? sanitize($_POST['quantity']*$_POST['price']) : '',
              'price' => isset($_POST['price']) ? sanitize($_POST['price']) : '',
              'type' => isset($_POST['type']) ? sanitize($_POST['type']) : '',
              'comment' => isset($_POST['comment']) ? ($_POST['comment']) : '',
              'updated_by_id' => $created_by_id,
              'updated' => date("Y-m-d H:i:s")
            );
            
            if(isset($_POST['pid']) && empty($_POST['pid']))
            {
                if(!empty($_POST['agent'])) {
                    $data['created_by_id'] = $_POST['agent'];
                }else {
                  $data['created_by_id'] = $created_by_id;
                }
                
                $data['created'] = isset($_POST['date']) && !empty($_POST['date']) ? date('Y-m-d H:i:s', strtotime($_POST['date'])) : date("Y-m-d H:i:s");
            }else if(!empty($_POST['date'])) {
                $data['created'] = isset($_POST['date']) && !empty($_POST['date']) ? date('Y-m-d H:i:s', strtotime($_POST['date'])) : date("Y-m-d H:i:s");
            }
            
            if(count($data)!=0)
            {
                if(isset($_POST['pid']) && !empty($_POST['pid']))
                {
                    $is = $this->Project_Expense_Model->update_new($_POST['pid'], $data);
                }else{
                    $is = $this->Project_Expense_Model->add_new($data);
                }
                if($is)
                {
                    $this->session->set_flashdata("success","Record has been updated.");
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
        }
        
        header("Location:". base_url('expenses'));
    }
    
    public function import_expense()
    {
        $file = isset($_FILES['expensefile']['name']) && !empty($_FILES['expensefile']['name']) ? $_FILES['expensefile'] : null;
        
        if($file) {
            $ext = pathinfo($_FILES['expensefile']['name'], PATHINFO_EXTENSION);
            if($ext==='csv'){
                $handle = fopen ($_FILES['expensefile']['tmp_name'],"r");
                $fileoph = fgetcsv($handle,0,",");
                
                $header = array_map(function($value) {
                    return str_replace(" ", "_", strtolower($value));
                }, $fileoph);
                
                $imported = 0;
                
                while(($fileop = fgetcsv($handle,0,",")) !==false){
                    $data = array_map(function($value) {
                        return trim($value);
                    }, $fileop);
                    
                    $row = array_combine($header, $data);
                    
                    if(!empty($row['client_name'])) {
                        $q = $this->db->where("client_name", $row['client_name'])->get("crm_client");
                        if($q->num_rows() > 0) {
                            $row['client_id'] = $q->row()->client_id;
                            unset($row['client_name']);
                        }
                    }
                    
                    if(!empty($row['project_name'])) {
                        $q = $this->db->where("project_name", $row['project_name'])->get("crm_project");
                        if($q->num_rows() > 0) {
                            $row['project_id'] = $q->row()->project_id;
                            unset($row['project_name']);
                        }
                    }
                    
                    if(!empty($row['agent_name'])) {
                        $q = $this->db->where("agent_name", $row['agent_name'])->get("crm_agent");
                        if($q->num_rows() > 0) {
                            $row['agent'] = $q->row()->agent_id;
                            unset($row['agent_name']);
                        }
                    }else {
                        $row['agent'] = '';
                        unset($row['agent_name']);
                    }
                    
                    $row['category'] = strtolower($row['category']);
                    $row['type'] = strtolower($row['type']);
                    
                    //add
                    $created_by_id = $this->Auth->_auth_id();
            
                    $data = array(
                      'project_id' => isset($row['project_id']) ? sanitize($row['project_id']) : '',
                      'client_id' => isset($row['client_id']) ? sanitize($row['client_id']) : '',
                      'category' => isset($row['category']) ? sanitize($row['category']) : '',
                      'quantity' => isset($row['quantity']) ? sanitize($row['quantity']) : '',
                      'total_price' => isset($row['price']) ? sanitize(intval($row['quantity'])*floatval($row['price'])) : '',
                      'price' => isset($row['price']) ? sanitize($row['price']) : '',
                      'type' => isset($row['type']) ? sanitize($row['type']) : '',
                      'comment' => isset($row['comments']) ? ($row['comments']) : '',
                      'updated_by_id' => $created_by_id,
                      'updated' => date("Y-m-d H:i:s")
                    );
                    
                    if(!empty($row['agent'])) {
                        $data['created_by_id'] = $row['agent'];
                    }else {
                      $data['created_by_id'] = $created_by_id;
                    }
                    
                    $data['created'] = isset($row['expense_date']) && !empty($row['expense_date']) ? date('Y-m-d H:i:s', strtotime($row['expense_date'])) : date("Y-m-d H:i:s");
                    
                    if(count($data)!=0)
                    {
                        $is = $this->Project_Expense_Model->add_new($data);
                        if($is) {
                            $imported ++;
                        }
                    }
                }
                
                $this->session->set_flashdata("success",$imported. " records has been imported.");
                header("Location:". base_url('import-expense'));
                exit();
            }
            
            $this->session->set_flashdata('error', 'File must be of type csv.');
            header("Location:". base_url('import-expense'));
            exit();
        }
        
        $this->session->set_flashdata('error', 'File is required.');
        header("Location:". base_url('import-expense'));
    }
    
    
    public function get_details()
    {
        $res = array("status"=>0,"data"=>"failed");
        if(isset($_POST['id']) && !empty($_POST['id']))
        {
            $data = $this->Project_Expense_Model->get_project($_POST['id']);
            if(!empty($data))
            {
                $res['status'] = 1;
                $res['data'] = "success";
                $res['a'] = $data;
            }
        }
        
        print_r(json_encode($res));
    }
    
    public function del_expense()
    {
        $this->Auth->_check_Aauth();
        if(isset($_GET['d']) && !empty($_GET['d']))
        {
            $is = $this->Project_Expense_Model->delete_project_expense($_GET['d']);
            $this->session->set_flashdata("success","Record has been updated.");
        }
        
        redirect('expenses');
    }
    
}
?>