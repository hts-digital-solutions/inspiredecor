<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Agent_Model extends CI_Model {
    
    private static $d;
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $d = $this->db->dbprefix;
    }
    
    public function add_new($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."agent"))
        {
            $this->db->insert(self::$d."agent", $data);
            $id = $this->db->insert_id();
            return $id;
        }else{
            return false;
        }
    }
    
    public function transfer_all_lead($of, $to)
    {
        if(!empty($of) && !empty($to) && $this->db->table_exists(self::$d."lead")){
            $data = $this->db->where("assign_to_agent", base64_decode($of))->get(self::$d."lead")->result();
            if(is_array($data)){
                foreach($data as $l){
                    if($l->status==5 || $l->status==10){
                        $this->db->set("assign_to_agent",0)->where("lead_id",$l->lead_id)->update(self::$d."lead");
                    }else{
                        $this->db->set("assign_to_agent",base64_decode($to))->where("lead_id",$l->lead_id)->update(self::$d."lead");
                    }
                }
                return true;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
    
    public function update_new($id, $data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d."agent"))
        {
            $this->db->where("agent_id", base64_decode($id));
            $this->db->update(self::$d."agent", $data);
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function match_password($id, $password)
    {
        if(!empty($id) && !empty($password) && $this->db->table_exists(self::$d."agent")){
            $this->db->where("agent_id", base64_decode($id));
            $this->db->where("agent_password", md5($password));
            $q = $this->db->get(self::$d."agent");
            
            return $q->num_rows() > 0 ? true : false;
        }else{
            return false;
        }     
    }
    
    public function get_profile_img($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."agent"))
        {
            $this->db->select("profile_image");
            $this->db->where("agent_id", base64_decode($id));
            $q = $this->db->get(self::$d."agent");
            return $q->num_rows() > 0 ? $q->row()->profile_image : '';
        }
    }
    
    public function delete_agent($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."agent"))
        {
            $this->db->where("agent_id", base64_decode($id));
            $this->db->delete(self::$d."agent");
            $id = $this->db->affected_rows();
            return $id;
        }
    }
    
    public function login_validate($email, $password)
    {
        if(!empty($email) && !empty($password))
        {
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->db->where("agent_email", $email);
            }else {
                $this->db->where("agent_name", $email);
            }
            
            $this->db->where("agent_status", 1);
            $this->db->where("agent_password", $password);
            $q = $this->db->get(self::$d."agent");
            if($q->num_rows() > 0)
            {
                return $q->row();
            }else{
                $this->load->model('Email_Model');
                
                $html = "
                <div style='border:1px solid red; padding:10px;'>
                <h4>Attemped a new login using wrong password.</h4>
                <hr>
                <p>System IP encountered is: ".$_SERVER['REMOTE_ADDR']."</p>
                <p>Date & Time: ".date('d-m-Y h:i:s A')."</p>
                </div>
                ";
                
                $sq = $this->db->where("agent_email", $email)->get(self::$d."agent");
                if($sq->num_rows()>0){
                    $this->Email_Model->send_email(
                        get_config_item('support_email'),
                        $email,
                        get_config_item("company_name"),
                        "Login attempt with wrong password",
                        $html,
                        "","","","php"
                    );
                }
                return false;
            }
        }else{
            return false;
        }
    }
    
    public function get_all()
    {
        if($this->db->table_exists(self::$d."agent"))
        {
            $this->db->order_by("agent_name","asc");
            $q = $this->db->get(self::$d."agent");
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
    
    public function access_control($id, $access)
    {
        if(!empty($id) && !empty($access))
        {
            if($this->db->table_exists(self::$d."agent"))
            {
                $this->db->where("agent_id", base64_decode($id));
                $this->db->update(self::$d."agent", array(
                    "client_access" => $access
                ));
                $id = $this->db->affected_rows();
                return $id;
            }else{
                return false;
            }
            
        }else{
            return false;
        }
    }
    
    public function get_profile(){
        if(isset($_SESSION['login_id']) && !empty($_SESSION['login_id'])){
            $agent = decrypt_me($_SESSION['login_id']);
            if(!empty($agent) && $this->db->table_exists(self::$d."agent"))
            {
                $this->db->where("agent_id", $agent);
                $q = $this->db->get(self::$d."agent");
                
                if($q->num_rows() > 0)
                {
                    return $q->row();
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
    
    public function get_agent($id)
    {
        if(!empty($id) && $this->db->table_exists(self::$d."agent"))
        {
            $this->db->where("agent_id", base64_decode($id));
            $q = $this->db->get(self::$d."agent");
            
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
}
?>
