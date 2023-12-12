<?php
defined("BASEPATH") OR exit("No direct script access allowed!");


if(!function_exists('get_fields'))
{
    function get_fields()
    {
        $ci = &get_instance();
        
        $q = $ci->db->where('feild_status', 1)
                ->select("feild_value_name,feild_type,is_required")
                ->order_by("feild_index","asc")
                ->get($ci->db->dbprefix."lead_feilds");
        if($q->num_rows() != 0)
        {
            return $q->result();
        }else{
            return '';
        }
    }
}


if(!function_exists('get_field_options'))
{
    function get_field_options($f)
    {
        $ci = &get_instance();
        
        $q = $ci->db->where('feild_status', 1)
                ->select("feild_options,feild_options_value")
                ->where("feild_value_name","status")
                ->get($ci->db->dbprefix."lead_feilds");
        if($q->num_rows() != 0)
        {
            return $q->row();
            
        }else{
            return '-';
        }
    }
}

if(!function_exists('get_select_module'))
{
    function get_select_module($n)
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix.$n)){
            $q = $ci->db->where($n.'_status', 1)
                    ->select($n."_id,".$n."_name")
                    ->where($n."_status",1)
                    ->order_by($n."_index","asc")
                    ->where("deleted",NULL)
                    ->get($ci->db->dbprefix.$n);
            if($q->num_rows() != 0)
            {
                return $q->result();
            }else{
                return '-';
            }
        }else{
            return '-';
        }
    }
}

if(!function_exists('get_module_value'))
{
    function get_module_value($id,$n)
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix.$n)){
            $q = $ci->db->where($n.'_status', 1)
                    ->select($n."_name")
                    ->where($n."_id",$id)
                    ->where("deleted",NULL)
                    ->get($ci->db->dbprefix.$n);
            if($q->num_rows() != 0)
            {
                $v = $n."_name";
                return $q->row()->$v;
                
            }else{
                return '-';
            }
        }else{
            return '-';
        }
    }
}

if(!function_exists('get_lead_fdata'))
{
    function get_lead_fdata($id,$n,$c="")
    {
        $ci = &get_instance();
        
        if($ci->db->table_exists($ci->db->dbprefix."followup")){
            $q = $ci->db->select($n)
                    ->limit(1)
                    ->order_by("followup_id","desc")
                    ->where("lead_id",$id)
                    ->get($ci->db->dbprefix."followup");
            if($q->num_rows() != 0 && $q->row()->$n!=NULL)
            {
                return $q->row()->$n;
                
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
}

if(!function_exists('get_id_by_value'))
{
    function get_id_by_value($value, $table)
    {
        $ci = &get_instance();
        if(!empty($value) && !empty($table))
        {
            if($ci->db->table_exists($ci->db->dbprefix.$table)){
                $ci->db->where("LOWER(".$table."_name)", $value);
                $q = $ci->db->get($ci->db->dbprefix.$table);
                
                if($q->num_rows() > 0)
                {
                    $id = $table."_id";
                    return $q->row()->$id;
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
}

if(!function_exists('get_subscriber_count'))
{
    function get_subscriber_count($g)
    {
        $ci = &get_instance();
        if(!empty($g) && $ci->db->table_exists($ci->db->dbprefix."lead"))
        {
            $ci->db->where("group_id", $g);
            $q = $ci->db->get($ci->db->dbprefix."lead");
            
            return $q->num_rows();
        }else{
            return 0;
        }
    }
}

if(!function_exists('get_required_lfields'))
{
    function get_required_lfields()
    {
        $rf = array();
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix."lead_feilds"))
        {
            $ci->db->select("feild_value_name");
            $ci->db->where("is_required", 1);
            $q = $ci->db->get($ci->db->dbprefix."lead_feilds");
            
            if($q->num_rows() > 0)
            {
                foreach($q->result() as $r)
                {
                    array_push($rf, $r->feild_value_name);
                }
                return $rf;
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
}

if(!function_exists('get_lead_total'))
{
    function get_lead_total($service)
    {
        $ci = &get_instance();
        if(!empty($service))
        {
            $invtotal = 0;
            $payment = get_info_of('product_service','payment',$service,'product_service_id');
            $setup = get_info_of('product_service','set_up_fee',$service,'product_service_id');
            
            return $payment+$setup;
        }else{
            return 0;
        }
    }
}

?>