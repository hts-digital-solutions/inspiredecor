<?php
defined("BASEPATH") OR exit("No direct script access allowed.");

if(!function_exists('get_task_status_id'))
{
    function get_task_status_id($value="")
    {
        $ci = &get_instance();
        if(!empty($value) && $ci->db->table_exists($ci->db->dbprefix."task_status"))
        {
            $ci->db->like("task_status_name",$value);
            $ci->db->limit(1);
            $q = $ci->db->get($ci->db->dbprefix."task_status");
            if($q->num_rows() > 0)
            {
                return $q->row()->task_status_id;
            }else{
                return '-';
            }
        }else{
            return '-';
        }
    }
}

if(!function_exists('get_task_last_status'))
{
    function get_task_last_status($id="")
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix."task"))
        {
            $ci->db->where("task_id",$id);
            $q = $ci->db->get($ci->db->dbprefix."task");
            if($q->num_rows() > 0)
            {
                return $q->row()->task_status;
            }else{
                return '-';
            }
        }else{
            return '-';
        }
    }
}

if(!function_exists('get_task_card'))
{
    function get_task_card()
    {
        $ci = &get_instance();
        $complete = get_task_status_id('completed');
        if($ci->db->table_exists($ci->db->dbprefix."task"))
        {
            if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
            {
                $ci->db->where("agent_id", decrypt_me($_SESSION['login_id']));
            }
            $ci->db->where("task_status!=",$complete);
            $ci->db->where('STR_TO_DATE(`task_date`, "%Y-%m-%d %H:%i:%s") <',date("Y-m-d H:i:s"));
            $q = $ci->db->get($ci->db->dbprefix."task");
            
            return $q->num_rows();
        }else{
            return '0';
        }
    }
}

if(!function_exists('get_calendar_task'))
{
    function get_calendar_task()
    {
        $ci = &get_instance();
        $complete = get_task_status_id('completed');
        if($ci->db->table_exists($ci->db->dbprefix."task"))
        {
            if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
            {
                $ci->db->where("agent_id", decrypt_me($_SESSION['login_id']));
            }
            $ci->db->where("task_status!=",$complete);
            $ci->db->where('STR_TO_DATE(`task_date`, "%Y-%m-%d %H:%i:%s") >',date("Y-m-d H:i:s"));
            $q = $ci->db->get($ci->db->dbprefix."task");
            
            return $q->num_rows();
        }else{
            return '0';
        }
    }
}




if(!function_exists('get_task_total'))
{
    function get_task_total()
    {
        $ci = &get_instance();
        $complete = get_task_status_id('completed');
        if($ci->db->table_exists($ci->db->dbprefix."task"))
        {
            if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
            {
                $ci->db->where("agent_id", decrypt_me($_SESSION['login_id']));
            }
            $ci->db->where("task_status!=",$complete);
            $q = $ci->db->get($ci->db->dbprefix."task");
            
            return $q->num_rows();
        }else{
            return '0';
        }
    }
}
?>