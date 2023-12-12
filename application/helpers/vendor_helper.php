<?php

if(!function_exists('get_vendor_services'))
{
    function get_vendor_services($id)
    {
        if(!empty($id))
        {
            $ci = &get_instance();
            if($ci->db->table_exists($ci->db->dbprefix."vendor_products"))
            {
                $q = $ci->db->where("vendor_id", $id)
                            ->get($ci->db->dbprefix."vendor_products");
                if($q->num_rows() != 0)
                {
                    $pids = $q->result();
                    $list = '';
                    foreach($pids as $p)
                    {
                        $ci->db->where("product_service_id", $p->product_id);
                        $ci->db->select("product_service_name");
                        $q2 = $ci->db->get($ci->db->dbprefix."product_service");
                        if($q2->num_rows() != 0)
                        {
                            $list .= '<li>'.$q2->row()->product_service_name.'</li>';
                        }
                    }
                    return $list;
                }else
                {
                    return '-';
                }
            }
        }else
        {
            return '-';
        }
    }
}

if(!function_exists('get_vendor_services_name'))
{
    function get_vendor_services_name($id)
    {
        if(!empty($id))
        {
            $ci = &get_instance();
            if($ci->db->table_exists($ci->db->dbprefix."vendor_products"))
            {
                $q = $ci->db->where("vendor_id", $id)
                            ->get($ci->db->dbprefix."vendor_products");
                if($q->num_rows() != 0)
                {
                    $pids = $q->result();
                    $list = array();
                    foreach($pids as $p)
                    {
                        $list[] = $p->service_name;
                    //     $ci->db->join($ci->db->dbprefix."vendor_products", $ci->db->dbprefix."vendor_products.product_id = ".$ci->db->dbprefix."product_service.product_service_id");
                    //     $ci->db->where($ci->db->dbprefix."product_service.product_service_id", $p->product_id);
                    //     $ci->db->select($ci->db->dbprefix."vendor_products.service_name");
                    //     $q2 = $ci->db->get($ci->db->dbprefix."product_service");
                    //     if($q2->num_rows() != 0)
                    //     {
                    //         $list .= '<li>'.$q2->row()->service_name.'</li>';
                    //     }
                    }
                    return array_unique($list);
                }else
                {
                    return '-';
                }
            }
        }else
        {
            return '-';
        }
    }
}

if(!function_exists('get_vendor_gst'))
{
    function get_vendor_gst($vendor_id)
    {
        $ci = &get_instance();
        if(!empty($vendor_id) && $ci->db->table_exists($ci->db->dbprefix."vendor"))
        {
            $q = $ci->db->where("vendor_id",$vendor_id)->get($ci->db->dbprefix."vendor");
            if($q->num_rows() > 0){
                return $q->row()->vendor_gst;
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
}

if(!function_exists('set_vendor_gst'))
{
    function set_vendor_gst($vendor_id, $gst)
    {
        $ci = &get_instance();
        if(!empty($vendor_id) && $ci->db->table_exists($ci->db->dbprefix."vendor"))
        {
            $ci->db->where("vendor_id",$vendor_id)->set("vendor_gst", $gst)
            ->update($ci->db->dbprefix."vendor");
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('get_vendor_services_no'))
{
    function get_vendor_services_no($cid, $inv="")
    {
        if(!empty($cid))
        {
            $ci = &get_instance();
            if($ci->db->table_exists($ci->db->dbprefix."vendor_products"))
            {
                if(!empty($inv))
                {
                    $ci->db->where("invoice_id",$inv);
                }
                $q = $ci->db->where("vendor_id", $cid)
                            ->get($ci->db->dbprefix."vendor_products");
                
                if($q->num_rows() != 0)
                {
                    return $q->num_rows();
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

if(!function_exists('get_vendor_name'))
{
    function get_vendor_name($id)
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix.'vendor'))
        {
            $ci->db->where("vendor_id", $id);
            $ci->db->select("vendor_name");
            $q = $ci->db->get($ci->db->dbprefix.'vendor');
            if($q->num_rows()!=0)
            {
                return $q->row()->vendor_name;
            }else
            {
                return '-';
            }
        }
    }
}

if(!function_exists('get_vendor_paid'))
{
    function get_vendor_paid($id)
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix.'invoice'))
        {
            $ci->db->where("vendor_id", $id);
            $ci->db->where("order_status", "paid");
            $ci->db->where("paid_amount!=", 0);
            $ci->db->select("paid_amount");
            $q = $ci->db->get($ci->db->dbprefix.'invoice');
            if($q->num_rows()!=0)
            {
                $total = 0;
                foreach($q->result() as $t)
                {
                    $total += $t->paid_amount;
                }
                return $total;
            }else
            {
                return '0';
            }
        }
    }
}

if(!function_exists('get_vendor_paid_no'))
{
    function get_vendor_paid_no($id)
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix.'invoice'))
        {
            $ci->db->where("vendor_id", $id);
            $ci->db->where("order_status", "paid");
            $ci->db->where("paid_amount!=", 0);
            $q = $ci->db->get($ci->db->dbprefix.'invoice');
            if($q->num_rows()!=0)
            {
                return $q->num_rows();
            }else
            {
                return '0';
            }
        }
    }
}

if(!function_exists('get_vendor_unpaid'))
{
    function get_vendor_unpaid($id)
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix.'invoice'))
        {
            $ci->db->where("vendor_id", $id);
            $ci->db->where_in("order_status", array("pending","due"));
            $ci->db->select("invoice_total");
            $q = $ci->db->get($ci->db->dbprefix.'invoice');
            if($q->num_rows()!=0)
            {
                $total = 0;
                foreach($q->result() as $t)
                {
                    $total += $t->invoice_total;
                }
                return $total;
            }else
            {
                return '0';
            }
        }
    }
}

if(!function_exists('get_vendor_unpaid_no'))
{
    function get_vendor_unpaid_no($id)
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix.'invoice'))
        {
            $ci->db->where("vendor_id", $id);
            $ci->db->where_in("order_status", array("pending","due"));
            $ci->db->select("invoice_total");
            $q = $ci->db->get($ci->db->dbprefix.'invoice');
            if($q->num_rows()!=0)
            {
                return $q->num_rows();
            }else
            {
                return '0';
            }
        }
    }
}


if(!function_exists('dateDiffInDays')){
    function dateDiffInDays($date)  
    {  
        $diff = strtotime(date('Y-m-d')) - strtotime($date);
        $days = abs(round($diff / 86400));
        if($days==0){
            return "Joined Today";   
        }else{
            return $days . " days";
        } 
    } 
}

if(!function_exists('get_vendor_info'))
{
    function get_vendor_info($id,$what)
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix.'vendor'))
        {
            $ci->db->where("vendor_id", $id);
            $ci->db->select($what);
            $q = $ci->db->get($ci->db->dbprefix.'vendor');
            if($q->num_rows()!=0)
            {
                return $q->row()->$what;
            }else
            {
                return '-';
            }
        }
    }
}

if(!function_exists('get_invoice_services_no'))
{
    function get_invoice_services_no($inv)
    {
        if(!empty($inv))
        {
            $ci = &get_instance();
            if($ci->db->table_exists($ci->db->dbprefix."invoice"))
            {
                $ci->db->where("invoice_id",$inv);
                $q = $ci->db->get($ci->db->dbprefix."invoice");
                
                if($q->num_rows() != 0)
                {
                    return count(explode(",",$q->row()->vendor_pid));
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

if(!function_exists('get_vendor_by_email'))
{
    function get_vendor_by_email($email)
    {
        if(!empty($email))
        {
            $ci = &get_instance();
            if($ci->db->table_exists($ci->db->dbprefix.'vendor'))
            {
                $ci->db->where("vendor_email", $email);
                $q = $ci->db->get($ci->db->dbprefix.'vendor');
                if($q->num_rows()!=0)
                {
                    return $q->row();
                }else
                {
                    return '';
                }
            }   
        }else{
            return '';
        }
    }
}

?>