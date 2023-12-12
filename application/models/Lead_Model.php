<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Lead_Model extends CI_Model {
    
    private static $d;
    
    public function __construct()
    {
        parent::__construct();
        $d = $this->db->dbprefix;
        $_SESSION['dp'] = $d;
        $this->load->helper("security");
    }
    
    public function add_new_lead($data)
    {
        if(!empty($data))
        {
            $this->db->insert(self::$d."lead", $data);
            $id = $this->db->insert_id();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update_lead($id, $data)
    {
        if(!empty($data) && !empty($id))
        {
            $this->db->where("lead_id", $id);
            $this->db->update(self::$d."lead", $data);
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update_followup($leads, $d)
    {
        if(!empty($leads) && !empty($d))
        {
            foreach($leads as $l)
            {
                $this->db->where("lead_id", base64_decode($l));
                $this->db->update(self::$d."followup", $d);
            }
            return true;
        }
    }
    
    public function get_all_leads()
    {
        if($this->db->table_exists(self::$d."lead"))
        {
            $lid = isset($_SESSION['login_id']) ? decrypt_me($_SESSION['login_id']) : '';
            if(isset($_GET['name']) && !empty($_GET['name']))
            {
                $this->db->like("full_name", $_GET['name']);
            }
            if(isset($_GET['contact']) && !empty($_GET['contact']))
            {
                $this->db->like("contact_no", $_GET['contact']);
            }
            if(isset($_GET['service']) && !empty($_GET['service']))
            {
                $this->db->where("service", $_GET['service']);
            }
            if(isset($_GET['status']) && !empty($_GET['status']) && $_GET['status']!=10)
            {
                $this->db->where("status", $_GET['status']);
            }else {
                $this->db->where("status!=", 10);
            }
            if(isset($_GET['fcal']) && !empty($_GET['fcal']))
            {
                $this->db->where('STR_TO_DATE(crm_followup.followup_date, "%Y-%m-%d %H:%i:%s") >', date("Y-m-d H:i:s"));
                $this->db->group_by(self::$d."followup.lead_id");
                $this->db->join(self::$d."followup",self::$d."followup.lead_id=".self::$d."lead.lead_id");
                $this->db->where(self::$d."followup.for_calender", $_GET['fcal']);
            }
            if(isset($_GET['agent']) && !empty($_GET['agent']))
            {
                $this->db->where("assign_to_agent", base64_decode($_GET['agent']));
            }
            if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
            {
                $this->db->where("assign_to_agent", $lid);
            }
            if(isset($_GET['group']) && !empty($_GET['group']))
            {
                $this->db->where("group_id", $_GET['group']);
            }
            
            if(isset($_GET['dfrom']) && !empty($_GET['dfrom']) && isset($_GET['dto']) && !empty($_GET['dto']))
            {
                $this->db->where('STR_TO_DATE(`created`, "%Y-%m-%d") >=', date("Y-m-d", strtotime($_GET['dfrom'])));
                $this->db->where('STR_TO_DATE(`created`, "%Y-%m-%d") <=', date("Y-m-d", strtotime($_GET['dto'])));
            }
            $this->db->order_by(self::$d."lead.followup_date","asc");
            $this->db->where(self::$d."lead.deleted", NULL);
            $q = $this->db->get(self::$d."lead");
            if($q->num_rows() != 0)
            {
                return $q->result();
            }else{
                return '';
            }
        }
    }
    
    public function get_lead_by_id($id)
    {
        if(!empty($id))
        {
            if($this->db->table_exists(self::$d."lead"))
            {
                $lid = decrypt_me($_SESSION['login_id']);
                if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
                {
                    $this->db->where("assign_to_agent", $lid);
                }
                $this->db->where("lead_id", base64_decode($id));
                $this->db->where("deleted", NULL);
                $q = $this->db->get(self::$d."lead");
                if($q->num_rows() != 0)
                {
                    return $q->row();
                }else{
                    return '';
                }
            }
            
        }else{
            return '';
        }
    }
    
     public function get_lead_docs_id($id)
    {
        if(!empty($id))
        {
            if($this->db->table_exists(self::$d."lead_doc"))
            {
                $this->db->where("lead_id", base64_decode($id));
                $this->db->where("deleted", NULL);
                $q = $this->db->get(self::$d."lead_doc");
                if($q->num_rows() != 0)
                {
                    return $q->result();
                }else{
                    return '';
                }
            }
            
        }else{
            return '';
        }
    }
    
    public function delete_lead($id)
    {
        if(!empty($id))
        {
           $this->db->where("lead_id", base64_decode($id));
           $this->db->delete(self::$d."lead");
           
           $this->db->where("lead_id", base64_decode($id));
           $this->db->delete(self::$d."followup");
           
           $this->db->where("lead_id", base64_decode($id));
           $this->db->delete(self::$d."lead_doc");
           
           $is = $this->db->affected_rows();
           
           return $is;
        }else{
            return false;
        }
    }
    
    public function save_lead_doc($data)
    {
        if(!empty($data))
        {
            $this->db->insert(self::$d."lead_doc", $data);   
            $id = $this->db->insert_id();
            return $id;
        }else{
            return false;
        }
    }
    
    public function delete_file($id)
    {
        if(!empty($id))
        {
            $this->db->where("lead_doc_id", base64_decode($id));
            $this->db->delete(self::$d."lead_doc");  
            return $this->db->affected_rows();
        }else{
            return false;
        }
    }
    
    public function add_followup($data)
    {
        if(!empty($data))
        {
            if($this->db->table_exists(self::$d."followup")){
                $this->db->insert(self::$d."followup", $data);
                $id = $this->db->insert_id();
                return $id;
            }
        }else{
            return false;
        }
    }
    
    public function update_followup_n($id, $data)
    {
        if(!empty($id) && !empty($data))
        {
            if($this->db->table_exists(self::$d."followup")){
                $this->db->where("followup_id", $id);
                $this->db->update(self::$d."followup", $data);
                $id = $this->db->affected_rows();
                return $id;
            }
        }else{
            return false;
        }
    }
    
    public function get_all_followups($id)
    {
        if(!empty($id))
        {
            if($this->db->table_exists(self::$d."followup"))
            {
                $this->db->where("lead_id", base64_decode($id));
                $this->db->where("deleted", NULL);
                $this->db->order_by("followup_id","desc");
                $q = $this->db->get(self::$d."followup");
                if($q->num_rows() != 0)
                {
                    return $q->result();
                }else{
                    return '';
                }
            }
            
        }else{
            return '';
        }
    }
    
    public function get_all_f_notification($date)
    {
        if(!empty($date))
        {   $date = date("Y-m-d H:i").":00";
            if($this->db->table_exists(self::$d."followup"))
            {
                $lid = decrypt_me($_SESSION['login_id']);
                if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
                {
                    $this->db->where("assign_to_agent", $lid);
                }
                $this->db->where('STR_TO_DATE(`followup_date`, "%Y-%m-%d %H:%i") =',date("Y-m-d H:i",strtotime($date)));
                $this->db->where("desktop_notified", 0);
                $q = $this->db->get(self::$d."followup");
                if($q->num_rows() != 0)
                {
                    return $q->result();
                }else{
                    return '';
                }
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
    
    public function get_expired_f()
    {
        $date = date("Y-m-d H:i:s");
        if($this->db->table_exists(self::$d."followup"))
        {
            $this->db->select("followup_id");
            $this->db->where('STR_TO_DATE(`followup_date`, "%Y-%m-%d %H:%i:%s") <',$date);
            $q = $this->db->get(self::$d."followup");
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
    
    public function change_status($leads, $s)
    {
        if(!empty($leads))
        {
            $st = false;
            if($this->db->table_exists(self::$d."lead"))
            {
                foreach($leads as $l){
                    $this->db->where('lead_id', base64_decode($l));
                    $this->db->update(self::$d."lead", array(
                        "status" => $s
                    ));
                    $st = $this->db->affected_rows();
                }
                return $st;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    
    public function transfer_to_agent($leads, $a)
    {
        if(!empty($leads))
        {
            $st = false;
            if($this->db->table_exists(self::$d."lead"))
            {
                foreach($leads as $l){
                    $this->db->where('lead_id', base64_decode($l));
                    $this->db->update(self::$d."lead", array(
                        "assign_to_agent" => $a
                    ));
                    $st = $this->db->affected_rows();
                }
                return $st;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    public function deleteSelected($leads)
    {
        if(!empty($leads))
        {
            if($this->db->table_exists(self::$d."lead"))
            {
                foreach($leads as $l){
                    
                    $this->db->where('lead_id', base64_decode($l));
                    $this->db->delete(self::$d."followup");
                    
                    $this->db->where('lead_id', base64_decode($l));
                    $this->db->delete(self::$d."lead");
                    $st = $this->db->affected_rows();
                }
                return $st;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    public function get_won_sales($type='')
    {
        $from = $to = date("Y-m-d");
        $won = get_id_by_value('won', 'status');
        
        //code
        $lid = decrypt_me($_SESSION['login_id']);
        if($this->db->table_exists(self::$d."lead"))
        {
            if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
            {
                $this->db->where(self::$d."lead.assign_to_agent", $lid);
            }
            if($type==='year')
            {
                 $this->db->where('DATE_FORMAT('.$_SESSION['dp'].'lead.updated, "%Y") >=', date("Y"));
            }
            if($type==='month')
            {
                 $this->db->where('DATE_FORMAT('.$_SESSION['dp'].'lead.updated, "%Y-%m") >=', date("Y-m"));
            }
            $this->db->join(self::$d."followup", self::$d."followup.lead_id=".self::$d."lead.lead_id");
            $this->db->group_by(self::$d.'followup.lead_id');
            $this->db->where(self::$d.'followup.followup_status_id', $won);
            $q = $this->db->get(self::$d."lead");
            
            $count = $q->num_rows();
            $clients = array();
            $invtotal = 0;
            if($q->num_rows() > 0){
                foreach($q->result() as $r){
                    $cid = get_info_of('client','client_id',$r->lead_id,'lead_id');
                    array_push($clients, $cid);
                }
                foreach($clients as $c){
                    $this->db->where("client_id",$c);
                    $iq = $this->db->get("invoice");
                    $invd = $iq->num_rows()>0 ? $iq->result() : '';
                    
                    if($invd!==''){
                        foreach($invd as $inv){
                            if($inv->invoice_total==0){
                                $invtotal += $inv->paid_amount;
                            }else{
                                $invtotal += ($inv->paid_amount + $inv->invoice_total);
                            }
                        }
                    }
                }
                return array("count"=>$count,"amount"=>$invtotal);
            }else{
                return array("count"=>0,"amount"=>0);
            }
        }else{
            return array("count"=>0,"amount"=>0);
        }
    }
    
    public function get_missed_ones()
    {
        $lost = get_id_by_value('lost', 'status');
        if($this->db->table_exists(self::$d."lead"))
        {
            $from = $to = date("Y-m-d");
            $from = date("Y-m-d", strtotime("-1 month"));
            if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
            {
                $this->db->where(self::$d."lead.assign_to_agent", decrypt_me($_SESSION['login_id']));
            }
            $this->db->where('STR_TO_DATE('.$_SESSION['dp'].'lead.updated, "%Y-%m-%d") >=', $from);
            $this->db->where('STR_TO_DATE('.$_SESSION['dp'].'lead.updated, "%Y-%m-%d") <=', $to);
            $this->db->where("status",$lost);
            $q = $this->db->get(self::$d."lead");
            $count = $q->num_rows();
            $amount = 0;
            
            if($q->num_rows() > 0){
                foreach($q->result() as $f){
                    $amount += (floatval(get_info_of('product_service','payment',$f->service,'product_service_id')) + 
                            floatval(get_info_of('product_service','set_up_fee',$f->service,'product_service_id')));
                }
                return array("count"=>$count, "amount"=>$amount);
            }else{
                return array("count"=>$count, "amount"=>$amount);
            }
            
        }else{
            return false;
        }
    }
    
    public function reserveForthis($id, $l)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."lead_feilds"))
        {
            $this->db->where("feild_id", $id);
            $this->db->set("for_lead_only", $l);
            $this->db->set("for_ip", '');
            $this->db->update(self::$d."lead_feilds");
            
            return $this->db->affected_rows();
        }else{
            return false;
        }
    }
    
    public function add_group($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."group"))
        {
            $this->db->insert(self::$d."group", $data);
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    
    public function update_group($id,$data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."group"))
        {
            $this->db->where("group_id", $id);
            $this->db->update(self::$d."group", $data);
            return $this->db->affected_rows();
        }else{
            return false;
        }
    }
    
    public function delete_group($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."group"))
        {
            $this->db->where("group_id", base64_decode($id));
            $this->db->delete(self::$d."group");
            return true;
        }else{
            return false;
        }
    }
    
    public function delete_grouplist($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."group"))
        {
            $this->db->where("group_id", base64_decode($id));
            $q = $this->db->get(self::$d."lead");
            if($q->num_rows() > 0)
            {
                foreach($q->result() as $l)
                {
                    $this->delete_lead(base64_encode($l->lead_id));
                }
            }
            
            return true;
        }else{
            return false;
        }
    }
    
    public function get_groups($id="")
    {
        if($this->db->table_exists(self::$d."group"))
        {
            $this->db->order_by("group_id","desc");
            if(!empty($id))
            {
                $this->db->where("group_id",base64_decode($id));
            }
            $this->db->where("group_status",1);
            $q = $this->db->get(self::$d."group");
            if($q->num_rows() > 0)
            {
                if(!empty($id))
                {
                    return $q->row();
                }else{
                    return $q->result();
                }
            }else{
                return "";
            }
        }else{
            return "";
        }
    }
    
    public function get_events()
    {
        $this->load->helper("task_helper");
        $monthly = array();
        if($this->db->table_exists(self::$d."followup"))
        {
            $this->db->where("for_calender","yes");
            $this->db->where('STR_TO_DATE(followup_date, "%Y-%m-%d %H:%i:%s") >=',date("Y-m-d H:i:s"));
            $q =$this->db->get(self::$d."followup");
            if($q->num_rows() > 0)
            {
                $i=1;
                foreach($q->result() as $e)
                {
                    array_push($monthly, array(
                       "id" => $i,
                       "name" => "<b>Followup</b><br/>".$e->followup_desc,
                       "startdate" => date("Y-m-d",strtotime($e->followup_date)),
                       "enddate" => date("Y-m-d",strtotime($e->followup_date)),
                       "starttime" => date("H:i",strtotime($e->followup_date)),
                       "endtime" => date("H:i",strtotime($e->followup_date)),
                       "color" => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
                       "url" => base_url('followup?lead=').base64_encode($e->lead_id)
                     ));
                    $i++;
                }
            }
        }
        
        if($this->db->table_exists(self::$d."task"))
        {
            $this->db->where("task_status!=",get_task_status_id('completed'));
            $this->db->where('STR_TO_DATE(task_date, "%Y-%m-%d %H:%i:%s") >=',date("Y-m-d H:i:s"));
            $this->db->order_by("task_priority","desc");
            $q =$this->db->get(self::$d."task");
            if($q->num_rows() > 0)
            {
                $i=1;
                foreach($q->result() as $t)
                {
                    array_push($monthly, array(
                       "id" => $i,
                       "name" => "<b>Task</b> <br/>".$t->task_name,
                       "startdate" => date("Y-m-d",strtotime($t->task_date)),
                       "enddate" => date("Y-m-d",strtotime($t->task_date)),
                       "starttime" => date("H:i",strtotime($t->task_date)),
                       "endtime" => date("H:i",strtotime($t->task_date)),
                       "color" => $t->task_priority==10 ? '#E5343D' :($t->task_priority==5 ? '#ffc751' : '#009688') ,
                       "url" => base_url('task/add?task=').base64_encode($t->task_id)
                     ));
                    $i++;
                }
            }
        }
        
        $monthly = array("monthly" => $monthly);
        
        return json_encode($monthly);
    }
}

?>