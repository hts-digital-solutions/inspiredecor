<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Task_Model extends CI_Model {
    
    private static $d;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("task_helper");
        $this->load->helper("lead_helper");
        $this->load->helper("security");
        date_default_timezone_set("Asia/Kolkata");
        $d = $this->db->dbprefix;
    }
    
    public function add_new($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."task"))
        {
            $this->db->insert(self::$d."task", $data);
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    
    public function add_task_comment($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."task_comment"))
        {
            $this->db->where("task_id", $data['task_id']);
            $this->db->set("task_status", $data['status']);
            $this->db->update(self::$d."task");
            
            $this->db->insert(self::$d."task_comment", $data);
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    
    public function update_task($id,$data,$n="")
    {
        if(!empty($id) && $this->db->table_exists(self::$d."task"))
        {
            $c = isset($data['task_status']) ? $data['task_status'] : '';
            $u = $_SESSION['roll']!='admin' ? get_module_value(decrypt_me($_SESSION['login_id']),'agent') : 'Admin';
            if($n==''){
                $cdata = array(
                  "commented_by" => decrypt_me($_SESSION['login_id']),
                  "status" => $c,
                  "task_id" => base64_decode($id),
                  "dateandtime" => date("Y-m-d h:i:s"),
                  "comments" => $data['description'],
                  "created" => date("Y-m-d h:i:s"),
                  "updated" => date("Y-m-d h:i:s")
                );
                $this->db->insert(self::$d."task_comment",$cdata);
            }
            $this->db->where("task_id", base64_decode($id));
            $this->db->update(self::$d."task", $data);
            return $this->db->affected_rows();
        }else{
            return false;
        }
    }
    
    public function get_all($opt="")
    {
        if($this->db->table_exists(self::$d."task"))
        {
            $tc = get_task_status_id('task completed');
            if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
            {
                $id = decrypt_me($_SESSION['login_id']);
                
                $this->db->where("agent_id", $id)
                    ->or_where("FIND_IN_SET('$id', access_to_id)");
            }
            
            if(isset($_GET['agent']) && !empty($_GET['agent'])){
                $this->db->where("agent_id", base64_decode($_GET['agent']));
            }
            
            if(isset($_GET['status']) && !empty($_GET['status'])){
                $this->db->where("task_status", base64_decode($_GET['status']));
            }
            if(isset($_GET['name']) && !empty($_GET['name'])){
                $this->db->like("task_name", $_GET['name']);
            }
            if($opt=="dashboard" || !isset($_GET['status']))
            {
                $this->db->where("task_status!=",$tc);
            }
            $this->db->order_by('created',"desc");
            $q = $this->db->get(self::$d."task");
           
            return $q->num_rows() > 0 ? $q->result() : '';
        }else{
            return '';
        }
    }
    
    public function get_all_comments($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."task_comment"))
        {
            $this->db->where("task_id", base64_decode($id));
            $this->db->order_by("task_comment_id","desc");
            $q = $this->db->get(self::$d."task_comment");
            return $q->num_rows() > 0 ? $q->result() : '';
        }else{
            return '';
        }
    }
    
    public function remove($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."task"))
        {
            $this->db->where("task_id", base64_decode($id));
            $this->db->delete(self::$d."task_comment");
            
            $this->db->where("task_id", base64_decode($id));
            $this->db->delete(self::$d."task");
            return $this->db->affected_rows();
        }else{
            return false;
        }
    }
    
    public function get_single_task($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."task"))
        {
            $this->db->where("task_id", base64_decode($id));
            $q = $this->db->get(self::$d."task");
            return $q->num_rows() > 0 ? $q->row() : '';
        }else{
            return false;
        }
    }
    
    public function mark_complete($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."task"))
        {
            $c = get_task_status_id('completed');
            $u = $_SESSION['roll']!='admin' ? get_module_value(decrypt_me($_SESSION['login_id']),'agent') : 'Admin';
            if($c!=get_task_last_status(base64_decode($id))){
                $data = array(
                  "commented_by" => decrypt_me($_SESSION['login_id']),
                  "status" => $c,
                  "task_id" => base64_decode($id),
                  "dateandtime" => date("Y-m-d h:i:s"),
                  "comments" => "Status changed from <b>".get_module_value(get_task_last_status(base64_decode($id)),'task_status').
                  "</b> to <b>".get_module_value($c,'task_status')."</b> by ".$u,
                  "created" => date("Y-m-d h:i:s"),
                  "updated" => date("Y-m-d h:i:s")
                );
                $this->db->insert(self::$d."task_comment",$data);
            }
            $this->db->where("task_id", base64_decode($id));
            $this->db->set("task_status", $c);
            $this->db->update(self::$d."task");
            return $this->db->affected_rows();
        }else{
            return false;
        }
    }
    
    public function change_status($tasks, $s)
    {
        if(!empty($s) && !empty($tasks))
        {
            foreach($tasks as $t)
            {
                $u = $_SESSION['roll']!='admin' ? get_module_value(decrypt_me($_SESSION['login_id']),'agent') : 'Admin';
                $ls = get_task_last_status(base64_decode($t));
                if($s!=$ls){
                    $cdata = array(
                      "commented_by" => decrypt_me($_SESSION['login_id']),
                      "status" => $s,
                      "task_id" => base64_decode($t),
                      "dateandtime" => date("Y-m-d h:i:s"),
                      "comments" => "Status changed from <b>".get_module_value($ls,'task_status').
                      "</b> to <b>".get_module_value($s,'task_status')."</b> by ".$u,
                      "created" => date("Y-m-d h:i:s"),
                      "updated" => date("Y-m-d h:i:s")
                    );
                    
                    $this->db->insert(self::$d."task_comment",$cdata);
                }
                $this->db->where("task_id", base64_decode($t));
                $this->db->set("task_status", $s);
                $this->db->update(self::$d."task");
            }
            return $this->db->affected_rows();
        }else{
            return false;
        }
    }
    
    public function transfer_to_agent($tasks, $a)
    {
        if(!empty($a) && !empty($tasks))
        {
            foreach($tasks as $t)
            {
                $this->db->where("task_id", base64_decode($t));
                $this->db->set("agent_id", $a);
                $this->db->update(self::$d."task");
            }
            return $this->db->affected_rows();
        }else{
            return false;
        }
    }
    
    public function get_task_notification($date)
    {
        if(!empty($date))
        {   $date = date("Y-m-d H:i").":00";
            if($this->db->table_exists(self::$d."task"))
            {
                if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
                {
                    $this->db->where("agent_id", decrypt_me($_SESSION['login_id']));
                }
                $this->db->where('STR_TO_DATE(`task_date`, "%Y-%m-%d %H:%i") =',date("Y-m-d H:i",strtotime($date)));
                $this->db->where("desktop_notified", 0);
                $q = $this->db->get(self::$d."task");
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
}
?>