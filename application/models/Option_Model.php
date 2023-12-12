<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Option_Model extends CI_Model {
    private static $d;
    public function __construct()
    {
        parent::__construct();
        $d = $this->db->dbprefix;
        date_default_timezone_set("Asia/Kolkata");
    }
    
    public function add_lead_source($data)
    {
        if(!empty($data))
        {
            $o = -1;
            $q = $this->db->select("lead_source_index")
                ->order_by("lead_source_index","desc")
                ->get(self::$d."lead_source");
            if($q->num_rows() > 0){
                $o = $q->row()->lead_source_index;
            }
            $data['lead_source_index'] = intval($o) + 1;
            $this->db->insert(self::$d."lead_source", $data);
            $i = $this->db->insert_id();
            $id = $this->db->where("lead_source_id", $i)->get(self::$d."lead_source")->row();
            return $id;
        }else{
            return false;
        }
    }
    
    public function delete_lead_source($id)
    {
        if(!empty($id))
        {
            $this->db->where("lead_source_id", base64_decode($id));
            $this->db->delete(self::$d."lead_source");
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update_lead_source($id, $data)
    {
        if(!empty($id))
        {
            $this->db->where("lead_source_id", base64_decode($id));
            $this->db->update(self::$d."lead_source", $data);
            $id = $this->db->where("lead_source_id", base64_decode($id))->get(self::$d."lead_source")->row();
            return $id;
        }else{
            return false;
        }
    }
    
    public function add_service($data)
    {
        if(!empty($data))
        {
            $o = -1;
            $q = $this->db->select("service_index")
                ->order_by("service_index","desc")
                ->get(self::$d."service");
            if($q->num_rows() > 0){
                $o = $q->row()->service_index;
            }
            $data['service_index'] = intval($o) + 1;
            $this->db->insert(self::$d."service", $data);
            $i = $this->db->insert_id();
            return $this->db->where("service_id", $i)->get(self::$d."service")->row();
        }else{
            return false;
        }
    }
    
    public function delete_service($id)
    {
        if(!empty($id))
        {
            $this->db->where("service_id", base64_decode($id));
            $this->db->delete(self::$d."service");
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update_service($id, $data)
    {
        if(!empty($id))
        {
            $this->db->where("service_id", base64_decode($id));
            $this->db->update(self::$d."service", $data);
            $id = $this->db->where("service_id", base64_decode($id))->get(self::$d."service")->row();
            return $id;
        }else{
            return false;
        }
    }
    
    public function add_status($data)
    {
        if(!empty($data))
        {
            $o = -1;
            $q = $this->db->select("status_index")
                ->order_by("status_index","desc")
                ->get(self::$d."status");
            if($q->num_rows() > 0){
                $o = $q->row()->status_index;
            }
            $data['status_index'] = intval($o) + 1;
            $this->db->insert(self::$d."status", $data);
            $id = $this->db->insert_id();
            return $this->db->where("status_id", $id)->get(self::$d."status")->row();
        }else{
            return false;
        }
    }
    
    public function delete_status($id)
    {
        if(!empty($id))
        {
            $this->db->where("status_id", base64_decode($id));
            $this->db->delete(self::$d."status");
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update_status($id, $data)
    {
        if(!empty($id))
        {
            $this->db->where("status_id", base64_decode($id));
            $this->db->update(self::$d."status", $data);
            $id = $this->db->where("status_id", base64_decode($id))->get(self::$d."status")->row();
            return $id;
        }else{
            return false;
        }
    }
    
    public function add_lost_reason($data)
    {
        if(!empty($data))
        {
            $o = -1;
            $q = $this->db->select("lost_reason_index")
                ->order_by("lost_reason_index","desc")
                ->get(self::$d."lost_reason");
            if($q->num_rows() > 0){
                $o = $q->row()->lost_reason_index;
            }
            $data['lost_reason_index'] = intval($o) + 1;
            $this->db->insert(self::$d."lost_reason", $data);
            $i = $this->db->insert_id();
            $id = $this->db->where("lost_reason_id", $i)->get(self::$d."lost_reason")->row();
            return $id;
        }else{
            return false;
        }
    }
    
    public function delete_lost_reason($id)
    {
        if(!empty($id))
        {
            $this->db->where("lost_reason_id", base64_decode($id));
            $this->db->delete(self::$d."lost_reason");
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update_lost_reason($id, $data)
    {
        if(!empty($id))
        {
            $this->db->where("lost_reason_id", base64_decode($id));
            $this->db->update(self::$d."lost_reason", $data);
            $id = $this->db->where("lost_reason_id", base64_decode($id))->get(self::$d."lost_reason")->row();
            return $id;
        }else{
            return false;
        }
    }
    
    public function delete_expense_category($id)
    {
        if(!empty($id))
        {
            $this->db->where("id", base64_decode($id));
            $this->db->delete(self::$d."expense_category");
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function add_expense_category($data)
    {
        if(!empty($data))
        {
            $this->db->insert(self::$d."expense_category", $data);
            $i = $this->db->insert_id();
            $id = $this->db->where("id", $i)->get(self::$d."expense_category")->row();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update_expense_category($id, $data)
    {
        if(!empty($id))
        {
            $this->db->where("id", base64_decode($id));
            $this->db->update(self::$d."expense_category", $data);
            $id = $this->db->where("id", base64_decode($id))->get(self::$d."expense_category")->row();
            return $id;
        }else{
            return false;
        }
    }
    
    public function add_task_status($data)
    {
        if(!empty($data))
        {
            $o = -1;
            $q = $this->db->select("task_status_index")
                ->order_by("task_status_index","desc")
                ->get(self::$d."task_status");
            if($q->num_rows() > 0){
                $o = $q->row()->task_status_index;
            }
            $data['task_status_index'] = intval($o) + 1;
            $this->db->insert(self::$d."task_status", $data);
            $i = $this->db->insert_id();
            $id = $this->db->where("task_status_id", $i)->get(self::$d."task_status")->row();
            return $id;
        }else{
            return false;
        }
    }
    
    public function delete_task_status($id)
    {
        if(!empty($id))
        {
            $this->db->where("task_status_id", base64_decode($id));
            $this->db->delete(self::$d."task_status");
            $id = $this->db->affected_rows();
            return $id;
        }else{
            return false;
        }
    }
    
    public function update_task_status($id, $data)
    {
        if(!empty($id))
        {
            $this->db->where("task_status_id", base64_decode($id));
            $this->db->update(self::$d."task_status", $data);
            $id = $this->db->where("task_status_id", base64_decode($id))->get(self::$d."task_status")->row();
            return $id;
        }else{
            return false;
        }
    }
    
    public function sort_option($of, $id, $index)
    {
        for($i=0; $i<count($id); $i++){
            $q = $this->db->where($of."_id", base64_decode($id[$i]))
                ->set($of."_index", $index[$i])
                ->update(self::$d.$of);
        }
        return true;
    }
    
    public function sort_feild($section, $id, $index)
    {
        for($i=0; $i<count($id); $i++){
            $q = $this->db->where("feild_id", base64_decode($id[$i]))
                ->where("section_id", base64_decode($section))
                ->set("feild_index", $index[$i])
                ->update(self::$d.'lead_feilds');
        }
        return true;
    }
}
?>