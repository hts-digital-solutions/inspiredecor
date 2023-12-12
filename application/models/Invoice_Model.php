<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Invoice_Model extends CI_Model {
    
    private static $d;
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $d = $this->db->dbprefix;
        $this->load->helper("security");
    }
    
    public function add_c_product($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."client_products"))
        {
            $this->db->insert(self::$d."client_products", $data);
            $id = $this->db->insert_id();
            return $id;
        }else
        {
            return false;
        }
    }
    
    public function update_c_product($id,$data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."client_products"))
        {
            $this->db->where("client_product_id", $id);
            $this->db->update(self::$d."client_products", $data);
            $id = $this->db->affected_rows();
            return $id;
        }else
        {
            return false;
        }
    }
    
    public function create_new_invoice($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."invoice"))
        {
            $this->db->insert(self::$d."invoice", $data);
            $id = $this->db->insert_id();
            return $id;
        }else
        {
            return false;
        }
    }
    
    public function add_txn($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."transaction"))
        {
            $this->db->insert(self::$d."transaction", $data);
            $id = $this->db->insert_id();
            return $id;
        }else
        {
            return false;
        }
    }
    
    public function update_new_invoice($id,$data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."invoice"))
        {
            $this->db->where("invoice_id",$id);
            $this->db->update(self::$d."invoice", $data);
            $id = $this->db->affected_rows();
            return $id;
        }else
        {
            return false;
        }
    }
    
    public function get_all_invoices($client="")
    {
        if($this->db->table_exists(self::$d."invoice"))
        {
            /*if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
            {
                $this->db->where("agent_id", decrypt_me($_SESSION['login_id']));
            }*/
            if($client!='')
            {
                $this->db->where("client_id", base64_decode($client));
            }
            if(isset($_GET['client_name']) && !empty($_GET['client_name']))
            {
                $this->db->like("client_name",$_GET['client_name']);
            }
            if(isset($_GET['service']) && !empty($_GET['service']))
            {
                $this->db->where("FIND_IN_SET('".$_GET['service']."',products)<>0");
            }
            if(isset($_GET['is_recurring']) && $_GET['is_recurring']!='no')
            {
                $this->db->where("is_recurring",$_GET['is_recurring']);
            }
            //pending date 
            if(isset($_GET['status']) && $_GET['status']=='pending'){
                if(isset($_GET['due_date_from']) && !empty($_GET['due_date_from'])
                  && isset($_GET['due_date_to']) && !empty($_GET['due_date_to']))
                {
                    $this->db->where('updated >=', date("Y-m-d",strtotime($_GET['due_date_from'])));
                    $this->db->where('updated <=', date("Y-m-d",strtotime($_GET['due_date_to'])));
                }
                $this->db->where("invoice_due_date <", date("Y-m-d"));
                $this->db->where("order_status!=",'paid');
            }
            //paid date 
            if(isset($_GET['status']) && $_GET['status']=='paid'){
                if(isset($_GET['due_date_from']) && !empty($_GET['due_date_from'])
                  && isset($_GET['due_date_to']) && !empty($_GET['due_date_to']))
                {
                    $this->db->where('updated >=', date("Y-m-d",strtotime($_GET['due_date_from'])));
                    $this->db->where('updated <=', date("Y-m-d",strtotime($_GET['due_date_to'])));
                }
                $this->db->where("order_status",$_GET['status']);
            }
            //due date 
            if(isset($_GET['status']) && $_GET['status']=='due'){
                if(isset($_GET['due_date_from']) && !empty($_GET['due_date_from'])
                  && isset($_GET['due_date_to']) && !empty($_GET['due_date_to']))
                {
                    $this->db->where('invoice_due_date >=', date("Y-m-d",strtotime($_GET['due_date_from'])));
                    $this->db->where('invoice_due_date <=', date("Y-m-d",strtotime($_GET['due_date_to'])));
                }
                $this->db->where("order_status!=",'paid');
                $this->db->where("invoice_due_date >", date("Y-m-d"));
            }
            
            if(isset($_GET['pay_method']) && !empty($_GET['pay_method']))
            {
                $this->db->where("payment_method",$_GET['pay_method']);
            }
            
            $q = $this->db->get(self::$d."invoice");
            if($q->num_rows() != 0)
            {
                return $q->result();
            }else
            {
                return '';
            }
        }else
        {
            return '';
        }
    }
    
    public function delete_invoice_txn($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."transaction"))
        {
            $this->db->where("transaction_id", base64_decode($id));
            $this->db->delete(self::$d."transaction");
            return true;
        }else{
            return false;
        }
    }
    
    
    public function get_invoice_by_id($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."invoice"))
        {
            $this->db->where("invoice_id", base64_decode($id));
            $q = $this->db->get(self::$d."invoice");
            if($q->num_rows() != 0)
            {
                return $q->row();
            }else
            {
                return '';
            }
        }else
        {
            return '';
        }
    }
    
    public function get_txn($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."transaction"))
        {
            $this->db->where("invoice_id", base64_decode($id));
            $q = $this->db->get(self::$d."transaction");
            if($q->num_rows() != 0)
            {
                return $q->result();
            }else
            {
                return '';
            }
        }else
        {
            return '';
        }
    }
    
    public function get_products_of_invoice($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."invoice"))
        {
            $ps = array();
            $this->db->where("invoice_id", base64_decode($id));
            $q = $this->db->get(self::$d."invoice");
            if($q->num_rows() != 0)
            {
                $ids = $q->row()->products;
                $ids = explode(",", $ids);
                foreach($ids as $i)
                {
                    $this->db->where("product_service_id", $i);
                    $q2 = $this->db->get(self::$d."product_service");
                    if($q2->num_rows() != 0)
                    {
                        array_push($ps, $q2->row());
                    }
                }
                return $ps;
            }else
            {
                return '';
            }
        }else
        {
            return '';
        }
    }
    
    public function get_cproducts_of_invoice($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."invoice"))
        {
            $ps = array();
            $this->db->where("invoice_id", base64_decode($id));
            $q = $this->db->get(self::$d."invoice");
            if($q->num_rows() != 0)
            {
                $ids = $q->row()->client_pid;
                $ids = explode(",", $ids);
                foreach($ids as $i)
                {
                    $this->db->where("client_product_id", $i);
                    $this->db->join(self::$d."product_service",self::$d."product_service.product_service_id=".self::$d."client_products.product_id");
                    $q2 = $this->db->get(self::$d."client_products");
                    if($q2->num_rows() != 0)
                    {
                        array_push($ps, $q2->row());
                    }
                }
                return $ps;
            }else
            {
                return '';
            }
        }else
        {
            return '';
        }
    }
    
    public function delete_invoice($i)
    {
        if(!empty($i) && $this->db->table_exists(self::$d."invoice"))
        {
            $this->db->where("invoice_id", base64_decode($i));
            $this->db->delete(self::$d."invoice");
            return true;
        }else
        {
            return false;
        }
    }
    
    public function get_invoice_not_paid()
    {
        if($this->db->table_exists(self::$d."invoice"))
        {
            if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
            {
               $this->db->where("agent_id",decrypt_me($_SESSION['login_id']));
            }
            $this->db->where("order_status", 'pending');
            $q = $this->db->get(self::$d."invoice");
            if($q->num_rows() != 0)
            {
                $count = $q->num_rows();
                $amount = 0;
                foreach($q->result() as $inv){
                    $amount += $inv->invoice_total;
                }
                
                return array("count"=>$count,"amount"=>$amount);
            }else{
                return array("count"=>0,"amount"=>0);
            }
        }else
        {
            return false;
        }
    }
}
?>