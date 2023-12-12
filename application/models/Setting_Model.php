<?php
defined("BASEPATH") OR die("No direct script access allowed.");

class Setting_Model extends CI_Model {
    
    private static $d;
    
    public function __construct()
    {
        parent::__construct();
        $d = $this->db->dbprefix;
    }
    
    public function sort_crm_feild($id, $s, $index, $swap)
    {
        if(!empty($id))
        {
            $q = $this->db->select("feild_id")
                ->where("section_id", base64_decode($s))
                ->where("feild_index", $index)
                ->get(self::$d."lead_feilds");
                
            if($q->num_rows()!=0){
                $fid = $this->db->where("feild_id", $q->row()->feild_id)
                ->where("section_id", base64_decode($s))
                ->set("feild_index", $swap)
                ->update(self::$d."lead_feilds");
                
                $n = $this->db->where("feild_id", base64_decode($id))
                ->where("section_id", base64_decode($s))
                ->set("feild_index", $index)
                ->update(self::$d."lead_feilds");
            }
            return true;
        }else{
            return false;
        }
    }
    
    public function add_custom_field($data)
    {
        if(!empty($data))
        {
            $this->db->insert(self::$d."lead_feilds", $data);
            $id = $this->db->insert_id();
            return $this->db->where("feild_id", $id)->get(self::$d."lead_feilds")->row();
        }else{
            return false;
        }
    }
    
    public function add_etemplate($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d.'email_template'))
        {
            $this->db->insert(self::$d."email_template", $data);
            $id = $this->db->insert_id();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update_etemplate($id, $data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d.'email_template'))
        {
            $this->db->where("email_template_id", $id);
            $this->db->update(self::$d."email_template", $data);
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function get_etemplates()
    {
        if($this->db->table_exists(self::$d.'email_template'))
        {
            $q = $this->db->get(self::$d."email_template");
            return $q->num_rows() > 0 ? $q->result() : '';
        }else{
            return '';
        }
    }
    
    public function update_custom_field($id, $data)
    {
        if(!empty($id) && !empty($data))
        {
            $this->db->where("feild_id", $id);
            $this->db->update(self::$d."lead_feilds", $data);
            return $this->db->where("feild_id", $id)->get(self::$d."lead_feilds")->row();;
        }else{
            return false;
        }
    }
    
    public function get_field_show_by_id($id)
    {
        if(!empty($id)){
             $q = $this->db->where("feild_id", $id)->get(self::$d."lead_feilds");
             if($q->num_rows()!=0){
                 return $q->row();
             }else{
                 return '';
             }
        }else{
            return '';
        }
    }
    
    public function delete_feild($id)
    {
        $this->db->where("feild_id", $id)
        ->delete(self::$d."lead_feilds");
        
        return $this->db->affected_rows();
    }
    
    public function add_this_to_lead($col)
    {
        if(!$this->db->field_exists($col, self::$d."lead"))
        {
            $query = "ALTER TABLE crm_lead ADD COLUMN ".$col." VARCHAR(255) AFTER assign_to_agent";
            $this->db->query($query);
            return true;
        }
    }
    
    public function remove_this_to_lead($col)
    {
        if($this->db->field_exists($col, "crm_lead"))
        {
            $query = "ALTER TABLE crm_lead DROP ".$col;
            $this->db->query($query,true);
            return true;
        }
    }
    
    public function save_settings($data)
    {
        if(!empty($data))
        {
            $is = true;
            foreach($data as $key => $d){
                $sdata = array(
                    'value' => $d
                );
                
                $this->db->where("config_key", $key);
                $this->db->update(self::$d."config", $sdata);
            }
            
            return $is;
            
        }else{
            return false;
        }
    }
    
    public function add_new_section($name)
    {
        if(!empty($name))
        {
            $l=-1;
            $q = $this->db->order_by("section_id", 'desc')->get(self::$d."lead_sections");
            if($q->num_rows()!=0){
             $l = $q->row()->section_index;
            }
            
            $data = array(
              'section_name' => $name,
              'section_value_name' => str_replace(' ','_', strtolower($name)),
              'section_index' => intval($l) + 1,
              'section_status' => 1,
              'is_editable' => 0,
              'created' => date('Y-m-d'),
              'updated' => date('Y-m-d')
            );   
            $this->db->insert(self::$d."lead_sections", $data);
            return $this->db->insert_id();
        }else{
            return '-';
        }
    }
    
    public function save_login($data)
    {
        if(!empty($data) && $this->db->table_exists(self::$d.'login_history'))
        {
            $this->db->insert(self::$d."login_history", $data);
            $id = $this->db->insert_id();
            return $id;
        }else{
            return false;
        }
    }
    
    public function get_ld($token)
    {
        if(!empty($token) && $this->db->table_exists(self::$d.'login_history'))
        {
            $this->db->order_by("login_history_id", "desc");
            $this->db->limit(1);
            $this->db->where("login_email", $token[0]);
            $q = $this->db->get(self::$d."login_history");
            
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
    
    public function set_config($key, $value)
    {
        if($this->db->table_exists(self::$d.'config'))
        {
            $this->db->set('value', $value)
            ->where("config_key", $key)
            ->update(self::$d.'config');
            
            return true;
        }else{
            return false;
        }
    }
    
    public function is_same_place($coord, $email)
    {
        if(!empty($email))
        {
            if($this->db->table_exists(self::$d.'login_history'))
            {
                $this->db->where("login_ip", $_SERVER['REMOTE_ADDR']);
                $this->db->where("login_email", $email);
                $this->db->where("browser_used", $this->agent->browser());
                $this->db->where("platform", $this->agent->platform());
                $this->db->order_by("login_history_id", "desc");
                
                $q = $this->db->get(self::$d."login_history");
                if($q->num_rows() > 0)
                {
                    $d = $q->row()->login_coord;
                    if($d===$coord)
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
        }else{
            return false;
        }
    }
    
    public function set_attempt_action($email, $session, $what)
    {
        if($this->db->table_exists(self::$d.'login_history'))
        {
            $this->db->where("login_email", $email);
            $this->db->where("session_id", $session);
            $this->db->set("it_was_me", $what);
            $this->db->update(self::$d.'login_history');
        }
    }
    
    public function markRequired($id, $val)
    {
        if($this->db->table_exists(self::$d.'lead_feilds'))
        {
            $this->db->where("feild_id", base64_decode($id));
            $this->db->set("is_required", $val);
            $this->db->update(self::$d.'lead_feilds');
            return $this->db->affected_rows();
        }else{
            return false;
        }
    }
    
    public function get_lhistory($email)
    {
        if(!empty($email) && $this->db->table_exists(self::$d.'login_history'))
        {
            $this->db->where("login_email", $email);
            $this->db->order_by("login_history_id", "desc");
            $q = $this->db->get(self::$d.'login_history'); 
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
    
    public function clearLH($e)
    {
        if(!empty($e) && $this->db->table_exists(self::$d.'login_history'))
        {
            $this->db->where("login_email", base64_decode($e));
            $this->db->delete(self::$d.'login_history');
            return true;
        }else{
            return false;
        }
    }
    
    public function drop_tables()
    {
        $tables=$this->db->query("SHOW TABLES FROM ".$this->db->database)->result_array(); 
        foreach($tables as $key => $val) {
          $this->db->query("DROP TABLE ".$val['Tables_in_'.$this->db->database]);
        }
    }
}


?>