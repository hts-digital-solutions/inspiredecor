<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Client_Model extends CI_Model {
    
    private static $d;
    public function __construct()
    {
        parent::__construct(); 
        date_default_timezone_set("Asia/Kolkata");
        $d = $this->db->dbprefix;
        $this->load->helper("security");
        $this->load->helper("sconfig_helper");
    }
 
    public function add_new($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."client"))
        {
            $this->db->insert(self::$d."client", $data);
            $id = $this->db->insert_id();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update($id,$data)
    {
        if(!empty($data) && !empty($id) && $this->db->table_exists(self::$d."client"))
        {
            $this->db->where("client_id", $id);
            $this->db->update(self::$d."client", $data);
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function get_all()
    {
        if($this->db->table_exists(self::$d."client"))
        {
            //search
            $lid = decrypt_me($_SESSION['login_id']);
            if(isset($_GET['c_name']) && !empty($_GET['c_name']))
            {
                $this->db->like("client_name", $_GET['c_name']);
            }
            if(isset($_GET['c_company']) && !empty($_GET['c_company']))
            {
                $this->db->like("client_company", $_GET['c_company']);
            }
            if(isset($_GET['c_mobile']) && !empty($_GET['c_mobile']))
            {
                $this->db->like("client_mobile", $_GET['c_mobile']);
            }
            if(isset($_GET['product']) && !empty($_GET['product']))
            {
                $this->db->join(self::$d."client_products", self::$d."client_products.client_id=".self::$d."client.client_id");
                $this->db->group_by(self::$d."client_products.client_id");
                $this->db->where(self::$d."client_products.product_id", base64_decode($_GET['product']));
            }
            // if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
            // && $_SESSION['roll']!=='admin')
            // {
            //     $this->db->where("by_agent", $lid);
            // }
            
            if(auth_id() !== 0 && $this->uri->segment(1) === 'clients') {
                $this->db->where("by_agent", auth_id());
            }
            
            $this->db->order_by(self::$d."client.client_name", "asc");
            $q = $this->db->get(self::$d."client");
            if($q->num_rows() != 0)
            {
                return $q->result();   
            }else{
                return '';
            }
        }else{
            return false;
        }
    }
    
    public function get_client_by_id($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."client"))
        {
            $this->db->where("client_id", base64_decode($id));
            $q = $this->db->get(self::$d."client");
            if($q->num_rows() != 0)
            {
                return $q->row();   
            }else{
                return '';
            } 
        }else{
            return '';
        }
    }
    
    public function get_all_products($id="")
    {
        if($this->db->table_exists(self::$d."client_products"))
        {
            if(!empty($id)){
                $this->db->where(self::$d.'client_products.client_id', base64_decode($id));
            }
            $this->db->join(self::$d."product_service", self::$d.'product_service.product_service_id='.self::$d.'client_products.product_id');
            $q = $this->db->get(self::$d."client_products");
            if($q->num_rows() != 0)
            {
                return $q->result();   
            }else{
                return '';
            } 
        }else{
            return '';
        }
    }
    
    public function delete_client($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."client"))
        {
            $this->db->where("client_id", base64_decode($id));
            $this->db->delete(self::$d."client");
            
            $this->db->where("client_id", base64_decode($id));
            $this->db->delete(self::$d."client_products");
            
            $this->db->where("client_id", base64_decode($id));
            $this->db->delete(self::$d."invoice");
            
            return $this->db->affected_rows();
        }
    }
    
    public function delete_client_product($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."client_products"))
        {
            $this->db->where("client_product_id", base64_decode($id));
            $this->db->delete(self::$d."client_products");
            return $this->db->affected_rows();
        }
    }
    
    public function search_match($s)
    {
        if(!empty($s) && $this->db->table_exists(self::$d."client"))
        {
            $this->db->like("client_name", $s);
            $this->db->or_like("client_company", $s);
            $this->db->or_where("client_uid", $s);
            $q = $this->db->get(self::$d."client");
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
    
    public function get_client_emails($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."client_email_history"))
        {
            $this->db->order_by("client_eh_id","desc");
            $this->db->where("client_id", base64_decode($id));
            $q = $this->db->get(self::$d."client_email_history");
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
    
    public function get_client_sms($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."client_sms_history"))
        {
            $this->db->order_by("client_sh_id","desc");
            $this->db->where("client_id", base64_decode($id));
            $q = $this->db->get(self::$d."client_sms_history");
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
    
    public function get_cproduct($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."client_products"))
        {
            $this->db->where("client_product_id", base64_decode($id));
            $this->db->join(self::$d."product_service",self::$d."product_service.product_service_id =".self::$d."client_products.product_id");
            $q = $this->db->get(self::$d."client_products");
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
    
    public function update_cproduct($id, $data)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."client_products"))
        {
          $this->db->where("client_product_id", $id);
          $this->db->update(self::$d."client_products", $data);
          
          return $this->db->affected_rows();
        }else{
            return false;
        }
    }
    
    public function delete_clients($ids)
    {
        if(!empty($ids) && $this->db->table_exists(self::$d."client"))
        {
            $is = 0;
            foreach($ids as $id){
                $this->db->where("client_id", base64_decode($id));
                $this->db->delete(self::$d."client");
                
                $this->db->where("client_id", base64_decode($id));
                $this->db->delete(self::$d."client_products");
                
                $this->db->where("client_id", base64_decode($id));
                $this->db->delete(self::$d."invoice");
                
                $is = $this->db->affected_rows();
            }
            return $is;
        }
    }
    
    public function delete_clients_emails($ids)
    {
        if(!empty($ids) && $this->db->table_exists(self::$d."client_email_history"))
        {
            $is = 0;
            foreach($ids as $id){
                $this->db->where("client_eh_id", base64_decode($id));
                $this->db->delete(self::$d."client_email_history");
                $is = $this->db->affected_rows();
            }
            return $is;
        }
    }
    
    public function delete_clients_sms_selected($ids)
    {
        if(!empty($ids) && $this->db->table_exists(self::$d."client_sms_history"))
        {
            $is = 0;
            foreach($ids as $id){
                $this->db->where("client_sh_id", base64_decode($id));
                $this->db->delete(self::$d."client_sms_history");
                $is = $this->db->affected_rows();
            }
            return $is;
        }
    }
    
    public function delete_clients_sms($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."client_sms_history"))
        {
           $this->db->where("client_sh_id", base64_decode($id));
           $this->db->delete(self::$d."client_sms_history");
           return $this->db->affected_rows();
        }else{
            return false;
        }
    }
    
    public function delete_clients_email($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."client_email_history"))
        {
           $this->db->where("client_eh_id", base64_decode($id));
           $this->db->delete(self::$d."client_email_history");
           return $this->db->affected_rows();
        }else{
            return false;
        }
    }
    
    public function get_sms_data($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."client_sms_history"))
        {
           $this->db->where("client_sh_id", base64_decode($id));
           $this->db->select("sms_content");
           $q = $this->db->get(self::$d."client_sms_history");
           if($q->num_rows() != 0)
           {
               return $q->row()->sms_content;
           }else{
               return '';
           }
        }else{
            return '';
        }
    }
    
    public function get_email_data($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."client_email_history"))
        {
           $this->db->where("client_eh_id", base64_decode($id));
           $this->db->select("email_content");
           $q = $this->db->get(self::$d."client_email_history");
           if($q->num_rows() != 0)
           {
               return $q->row()->email_content;
           }else{
               return '';
           }
        }else{
            return '';
        }
    }
    
    public function get_best_employee($d="month")
    {
        if($this->db->table_exists(self::$d."agent"))
        {
           $emps = array();
           $a = get_module_values('agent');
           if(isset($a) && !empty($a))
           {
               foreach($a as $be){
                   $this->db->where("agent_id", $be->agent_id);
                   if($d=='month')
                   {
                       $this->db->where("DATE_FORMAT(updated, '%Y-%m')=",date("Y-m"));
                   }
                   if($d=='year')
                   {
                       $this->db->where("DATE_FORMAT(updated, '%Y')=",date("Y"));
                   }
                   $q = $this->db->get(self::$d."invoice");
                   if($q->num_rows() > 0)
                   {
                      $pt = 0;
                      foreach($q->result() as $am){
                          if($am->paid_amount==0){
                              $pt += $am->invoice_total;
                          }else{
                              $pt += ($am->invoice_total + $am->paid_amount);
                          }
                      }
                      $emps[$be->agent_name] = $pt; 
                   }else{
                       $emps[$be->agent_name] = 0;
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
    
    public function get_revenue_of_year()
    {
        if($this->db->table_exists(self::$d."invoice"))
        {
            $y = date('Y');
            $revenue = array();
            $month = array("jan","feb","mar","apr","may","jun","jul","aug","sept","oct","nov","dec");
            $revenue['m'] = $month;
            foreach($month as $m)
            {
                if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) && $_SESSION['roll']!=='admin'){
                    $this->db->where("agent_id", decrypt_me($_SESSION['login_id']));
                }
                $this->db->where('DATE_FORMAT(updated, "%Y-%m")=',date("Y-m", strtotime($m)));
                $this->db->select("paid_amount,invoice_total");
                $q = $this->db->get(self::$d."invoice");
                if($q->num_rows() > 0)
                {
                    $t=0;
                    foreach($q->result() as $a)
                    {
                        if($a->invoice_total==0){
                            $t += $a->paid_amount;
                        }else{
                            $t += ($a->paid_amount + $a->invoice_total);   
                        }
                    }
                    $revenue['a'][$m] = $t;
                }else{
                    $revenue['a'][$m] = 0;
                }
            }
            
            return($revenue);
        }else{
            return '';
        }
    }
    
    public function get_income_source()
    {
        $y = date('Y');
        $isource = array();
        if($this->db->table_exists(self::$d."lead"))
        {
            $s = get_module_values('lead_source');
            if(!empty($s)){
                $isource['s'] = array();
                $isource['v'] = array();
                foreach($s as $is){
                    array_push($isource['s'], $is->lead_source_name);
                    if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
                    {
                        $this->db->where("assign_to_agent", decrypt_me($_SESSION['login_id']));
                    }
                    $this->db->where("lead_source", $is->lead_source_id);
                    $q = $this->db->get(self::$d."lead");
                    array_push($isource['v'], $q->num_rows());
                }
            }
            return $isource;
        }else{
            return '';
        }
    }
}

?>