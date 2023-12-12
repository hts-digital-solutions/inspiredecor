<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Product_Model extends CI_Model {
    
    private static $d;
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $d = $this->db->dbprefix;
    }
    
    public function add_new($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."product_service"))
        {
            $this->db->insert(self::$d."product_service", $data);
            $id = $this->db->insert_id();
            return $id;
        }else
        {
            return false;    
        }
    }
    
    public function get_all()
    {
        if($this->db->table_exists(self::$d."product_service"))
        {
            $this->db->order_by("product_service_id","desc");
            $q = $this->db->get(self::$d."product_service");
            if($q->num_rows() != 0)
            {
                return $q->result();
            }else
            {
                return '';
            }
        }else{
            return '';
        }
    }
    
    public function _delete($id)
    {
        if(!empty($id))
        {
            $this->db->where("product_service_id", base64_decode($id));
            $this->db->delete(self::$d."product_service");
            return $this->db->affected_rows();
        }else
        {
            return false;
        }
    }
    
    public function get_detail_by_id($id)
    {
        if($this->db->table_exists(self::$d."product_service"))
        {
            $this->db->where("product_service_id",base64_decode($id));
            $q = $this->db->get(self::$d."product_service");
            if($q->num_rows() != 0)
            {
                return $q->row();
            }else
            {
                return '';
            }
        }else{
            return '';
        }
    }
    
    public function update($id, $data)
    {
        if(!empty($id) && !empty($data) && $this->db->table_exists(self::$d."product_service"))
        {
            $this->db->where("product_service_id", base64_decode($id));
            $this->db->update(self::$d."product_service", $data);
            $is = $this->db->affected_rows();
            return $is;
        }else
        {
            return false;    
        }
    }
    
    public function getPdetails($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."product_service"))
        {
            $this->db->where("product_service_id", $id);
            $this->db->select("product_service_name,set_up_fee,payment,recurring,billing_cycle");
            $q = $this->db->get(self::$d."product_service");
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
    
    public function is_assigned_to_client($id)
    {
        if(!empty($id))
        {
            if($this->db->table_exists(self::$d."client_products"))
            {
                $this->db->where("product_id", base64_decode($id));
                $q = $this->db->get(self::$d."client_products");
                if($q->num_rows() > 0)
                {
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    public function get_best_service($d="month")
    {
        if($this->db->table_exists(self::$d."product_service"))
        {
           $emps = array();
           $a = get_module_values('product_service');
           $won = get_id_by_value('won', 'status');
           if(isset($a) && !empty($a))
           {
               $lid = decrypt_me($_SESSION['login_id']);
               foreach($a as $be){
                   $this->db->where("status",$won);
                   $this->db->where("service", $be->product_service_id);
                   if($d=='month')
                   {
                       $this->db->where("DATE_FORMAT(updated,'%Y-%m')=",date("Y-m"));
                   }
                   if($d=='year')
                   {
                       $this->db->where("DATE_FORMAT(updated,'%Y')=",date("Y"));
                   }
                   if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
                    {
                        $this->db->where("assign_to_agent", $lid);
                    }
                   $q = $this->db->get(self::$d."lead");
                   if($q->num_rows() > 0)
                   {
                      $pt = 0;
                      foreach($q->result() as $am){
                          $pt += ($be->payment + $be->set_up_fee);
                      }
                      $emps[$be->product_service_name] = $pt; 
                   }else{
                       $emps[$be->product_service_name] = 0;
                   }
               }
               arsort($emps);
               $remp = "";
               if(is_array($emps)){
                   $i=1;
                   foreach($emps as $k=>$v){
                       if($i<=10){
                        $remp .= '<li>'.$i.'. '.$k.' ('.get_formatted_price($v).')</li>';
                       }
                       $i++;
                   }
               }
               return $remp;
           }else{
               return '';
           }
        }else{
            return '';
        }
    }
}
?>