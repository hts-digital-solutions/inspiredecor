<?php

if(!function_exists('get_client_services'))
{
    function get_client_services($id)
    {
        if(!empty($id))
        {
            $ci = &get_instance();
            if($ci->db->table_exists($ci->db->dbprefix."client_products"))
            {
                $q = $ci->db->where("client_id", $id)
                            ->get($ci->db->dbprefix."client_products");
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

if(!function_exists('get_client_services_name'))
{
    function get_client_services_name($id)
    {
        if(!empty($id))
        {
            $ci = &get_instance();
            if($ci->db->table_exists($ci->db->dbprefix."client_products"))
            {
                $q = $ci->db->where("client_id", $id)
                            ->get($ci->db->dbprefix."client_products");
                if($q->num_rows() != 0)
                {
                    $pids = $q->result();
                    $list = array();
                    foreach($pids as $p)
                    {
                        $list[] = $p->service_name;
                    //     $ci->db->join($ci->db->dbprefix."client_products", $ci->db->dbprefix."client_products.product_id = ".$ci->db->dbprefix."product_service.product_service_id");
                    //     $ci->db->where($ci->db->dbprefix."product_service.product_service_id", $p->product_id);
                    //     $ci->db->select($ci->db->dbprefix."client_products.service_name");
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

if(!function_exists('get_client_gst'))
{
    function get_client_gst($client_id)
    {
        $ci = &get_instance();
        if(!empty($client_id) && $ci->db->table_exists($ci->db->dbprefix."client"))
        {
            $q = $ci->db->where("client_id",$client_id)->get($ci->db->dbprefix."client");
            if($q->num_rows() > 0){
                return $q->row()->client_gst;
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
}

if(!function_exists('set_client_gst'))
{
    function set_client_gst($client_id, $gst)
    {
        $ci = &get_instance();
        if(!empty($client_id) && $ci->db->table_exists($ci->db->dbprefix."client"))
        {
            $ci->db->where("client_id",$client_id)->set("client_gst", $gst)
            ->update($ci->db->dbprefix."client");
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('get_client_services_no'))
{
    function get_client_services_no($cid, $inv="")
    {
        if(!empty($cid))
        {
            $ci = &get_instance();
            if($ci->db->table_exists($ci->db->dbprefix."client_products"))
            {
                if(!empty($inv))
                {
                    $ci->db->where("invoice_id",$inv);
                }
                $q = $ci->db->where("client_id", $cid)
                            ->get($ci->db->dbprefix."client_products");
                
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

if(!function_exists('get_client_name'))
{
    function get_client_name($id)
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix.'client'))
        {
            $ci->db->where("client_id", $id);
            $ci->db->select("client_name");
            $q = $ci->db->get($ci->db->dbprefix.'client');
            if($q->num_rows()!=0)
            {
                return $q->row()->client_name;
            }else
            {
                return '-';
            }
        }
    }
}

if(!function_exists('get_client_paid'))
{
    function get_client_paid($id)
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix.'invoice'))
        {
            $ci->db->where("client_id", $id);
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

if(!function_exists('get_client_paid_no'))
{
    function get_client_paid_no($id)
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix.'invoice'))
        {
            $ci->db->where("client_id", $id);
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

if(!function_exists('get_client_unpaid'))
{
    function get_client_unpaid($id)
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix.'invoice'))
        {
            $ci->db->where("client_id", $id);
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

if(!function_exists('get_client_unpaid_no'))
{
    function get_client_unpaid_no($id)
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix.'invoice'))
        {
            $ci->db->where("client_id", $id);
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

if(!function_exists('get_client_info'))
{
    function get_client_info($id,$what)
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix.'client'))
        {
            $ci->db->where("client_id", $id);
            $ci->db->select($what);
            $q = $ci->db->get($ci->db->dbprefix.'client');
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
                    return count(explode(",",$q->row()->client_pid));
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

if(!function_exists('get_client_by_email'))
{
    function get_client_by_email($email)
    {
        if(!empty($email))
        {
            $ci = &get_instance();
            if($ci->db->table_exists($ci->db->dbprefix.'client'))
            {
                $ci->db->where("client_email", $email);
                $q = $ci->db->get($ci->db->dbprefix.'client');
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