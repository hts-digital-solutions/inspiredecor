<?php
defined("BASEPATH") OR die("No direct script access allowed.");

class Report_Model extends CI_Model {
    
    private static $d;
    
    public function __construct()
    {
        parent::__construct();
        $d = $this->db->dbprefix;
    }
    
    public function get_income_report()
    {
        if($this->db->table_exists(self::$d."transaction"))
        {
            $ir = array();
            $month = array("jan","feb","mar","apr","may","jun","jul","aug","sept","oct","nov","dec");
            if(isset($_GET['irdatef']) && isset($_GET['irdatet']) && !empty($_GET['irdatef']) && !empty($_GET['irdatet']))
            {
                $from = strtolower($_GET['irdatef']);
                $to = strtolower($_GET['irdatet']);
                if($from==$to)
                {
                    $this->session->set_flashdata("error","Date range is not valid!");
                    redirect($_SERVER['HTTP_REFERER']);
                }
                $mns = $this->getMonths($from, $to);
                if($mns > 11)
                {
                    $this->session->set_flashdata("error","Range can be selected only for 12months.");
                    redirect($_SERVER['HTTP_REFERER']);
                }
                $from = explode("-",$from); $from=$from[1]."-".$from[2];
                $to = explode("-",$to); $to = $to[1]."-".$to[2];
                $ir['from'] = ucfirst($from);
                $ir['to'] = ucfirst($to);
                $month = array();
                array_push($month, date('M-Y', strtotime($from)));
                for($i=0; $i<$mns;$i++)
                {
                    array_push($month, date('M-Y', strtotime("+1month",strtotime($from))));
                    $from = date("M-Y", strtotime("+1month",strtotime($from)));
                }
            }else{
                $y = date('Y');
            }
            foreach($month as $m)
            {
                $this->db->where('DATE_FORMAT(updated, "%Y-%m")=',date("Y-m", strtotime($m)));
                if(isset($_GET['employee']) && !empty($_GET['employee']))
                {
                    $this->db->where("agent_id",base64_decode($_GET['employee']));
                }
                if(isset($_GET['product']) && !empty($_GET['product']))
                {
                    $this->db->where("FIND_IN_SET('".base64_decode($_GET['product'])."',products)<>0");
                }
                if(isset($_GET['income_type']) && !empty($_GET['income_type']))
                {
                    if($_GET['income_type']=='fresh')
                    {
                        $this->db->where("is_recurring","");
                    }
                    if($_GET['income_type']=='client'){
                        $this->db->where("is_recurring","yes");
                    }
                }
                $q = $this->db->get(self::$d."invoice");
                if($q->num_rows() > 0)
                {
                    $t=0;
                    foreach($q->result() as $a)
                    {
                        if(isset($_GET['product']) && !empty($_GET['product']))
                        {
                            $invid = !empty($a->invoice_gid) ? $a->invoice_gid : $a->performa_id;
                            
                            $cpq = $this->db->where("invoice_id",$invid)->where("product_id",base64_decode($_GET['product']))->get(self::$d."client_products");
                            
                            if($cpq->num_rows() > 0){
                                if($cpq->row()->price_override==0){
                                    $t += $cpq->row()->amount;
                                }else{
                                    $t += $cpq->row()->price_override;
                                }
                            }
                            
                        }else{
                            if($a->paid_amount==0){
                                $t += $a->invoice_total;
                            }else{
                                $t += ($a->invoice_total + $a->paid_amount);
                            } 
                        }
                    }
                    $ir['a'][$m] = $t;
                }else{
                    $ir['a'][$m] = 0;
                }
            }
            return($ir);
        }else{
            return '';
        }
    }
    
    public function get_invoice_report()
    {
        if($this->db->table_exists(self::$d."invoice"))
        {
            if(isset($_GET['refid']) && !empty($_GET['refid']))
            {
                $this->db->where("client_id",$_GET['refid']);
            }
            
            if(isset($_GET['duedatef']) && !empty($_GET['duedatef'])
              && isset($_GET['duedatet']) && !empty($_GET['duedatet']) && $_GET['rangetype']=='duedate')
            {
                $this->db->where('invoice_due_date >=', date("Y-m-d",strtotime($_GET['duedatef'])));
                $this->db->where('invoice_due_date <=', date("Y-m-d",strtotime($_GET['duedatet'])));
                $this->db->where("order_status!=",'paid');
                $this->db->where("invoice_due_date >", date("Y-m-d"));
            }else if(isset($_GET['rangetype']) && $_GET['rangetype']=='duedate'){
                $this->db->where("order_status!=",'paid');
                $this->db->where("invoice_due_date >", date("Y-m-d"));
            }
            
            if(isset($_GET['cdatef']) && !empty($_GET['cdatef'])
              && isset($_GET['cdatet']) && !empty($_GET['cdatet']) && $_GET['rangetype']=='createdate')
            {
                $this->db->where('invoice_date >=', date("Y-m-d",strtotime($_GET['cdatef'])));
                $this->db->where('invoice_date <=', date("Y-m-d",strtotime($_GET['cdatet'])));
            }
            
            if(isset($_GET['pdatef']) && !empty($_GET['pdatef'])
              && isset($_GET['pdatet']) && !empty($_GET['pdatet']) && $_GET['rangetype']=='paiddate')
            {
                $this->db->where('updated >=', date("Y-m-d",strtotime($_GET['pdatef'])));
                $this->db->where('updated <=', date("Y-m-d",strtotime($_GET['pdatet'])));
                $this->db->where("order_status",'paid');
            }else if(isset($_GET['rangetype']) && $_GET['rangetype']=='paiddate'){
                $this->db->where("order_status","paid");
            }
            
            if(isset($_GET['pndatef']) && !empty($_GET['pndatef'])
              && isset($_GET['pndatet']) && !empty($_GET['pndatet']) && $_GET['rangetype']=='pendingdate')
            {
                $this->db->where('updated >=', date("Y-m-d",strtotime($_GET['pndatef'])));
                $this->db->where('updated <=', date("Y-m-d",strtotime($_GET['pndatet'])));
                $this->db->where("invoice_due_date <", date("Y-m-d"));
                $this->db->where("order_status!=",'paid');
            }else if(isset($_GET['rangetype']) &&  $_GET['rangetype']=='pendingdate'){
                $this->db->where("invoice_due_date <", date("Y-m-d"));
                $this->db->where("order_status!=",'paid');
            }
            
            if(isset($_GET['pay_method']) && !empty($_GET['pay_method']))
            {
                $this->db->where("payment_method",$_GET['pay_method']);
            }
            
            $q = $this->db->get(self::$d."invoice");
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
    
    public function get_client_report()
    {
        if($this->db->table_exists(self::$d."client"))
        {
            $ir = array();
            $month = array("jan","feb","mar","apr","may","jun","jul","aug","sept","oct","nov","dec");
            if(isset($_GET['crdf']) && isset($_GET['crdt']) && !empty($_GET['crdf']) && !empty($_GET['crdt']))
            {
                $from = strtolower($_GET['crdf']);
                $to = strtolower($_GET['crdt']);
                if($from==$to)
                {
                    $this->session->set_flashdata("error","Date range is not valid!");
                    redirect($_SERVER['HTTP_REFERER']);
                }
                $mns = $this->getMonths($from, $to);
                if($mns > 11)
                {
                    $this->session->set_flashdata("error","Range can be selected only for 12 months.");
                    redirect($_SERVER['HTTP_REFERER']);
                }
                $from = explode("-",$from); $from=$from[1]."-".$from[2];
                $to = explode("-",$to); $to = $to[1]."-".$to[2];
                $ir['from'] = ucfirst($from);
                $ir['to'] = ucfirst($to);
                $month = array();
                array_push($month, date('M-Y', strtotime($from)));
                for($i=0; $i<$mns;$i++)
                {
                    array_push($month, date('M-Y', strtotime("+1month",strtotime($from))));
                    $from = date("M-Y", strtotime("+1month",strtotime($from)));
                }
            }else{
                $y = date('Y');
            }
            foreach($month as $m)
            {
                $this->db->where('DATE_FORMAT(crm_client.created, "%Y-%m")=',date("Y-m", strtotime($m)));
                $q = $this->db->get(self::$d."client");
                if($q->num_rows() > 0)
                {
                   $ir['a'][$m] = $q->num_rows();
                }else{
                    $ir['a'][$m] = 0;
                }
            }
            return($ir);
        }else{
            return '';
        }
    }
    
    public function get_client_order_report()
    {
        if($this->db->table_exists(self::$d."invoice"))
        {
            $ir = array();
            $month = array("jan","feb","mar","apr","may","jun","jul","aug","sept","oct","nov","dec");
            if(isset($_GET['crdf']) && isset($_GET['crdt']) && !empty($_GET['crdf']) && !empty($_GET['crdt']))
            {
                $from = strtolower($_GET['crdf']);
                $to = strtolower($_GET['crdt']);
                if($from==$to)
                {
                    $this->session->set_flashdata("error","Date range is not valid!");
                    redirect($_SERVER['HTTP_REFERER']);
                }
                $mns = $this->getMonths($from, $to);
                if($mns > 11)
                {
                    $this->session->set_flashdata("error","Range can be selected only for 12 months.");
                    redirect($_SERVER['HTTP_REFERER']);
                }
                $from = explode("-",$from); $from=$from[1]."-".$from[2];
                $to = explode("-",$to); $to = $to[1]."-".$to[2];
                $ir['from'] = ucfirst($from);
                $ir['to'] = ucfirst($to);
                $month = array();
                array_push($month, date('M-Y', strtotime($from)));
                for($i=0; $i<$mns;$i++)
                {
                    array_push($month, date('M-Y', strtotime("+1month",strtotime($from))));
                    $from = date("M-Y", strtotime("+1month",strtotime($from)));
                }
            }else{
                $y = date('Y');
            }
            foreach($month as $m)
            {
                $this->db->group_by(self::$d."transaction.invoice_id");
                $this->db->join(self::$d."transaction",self::$d."invoice.invoice_id=".self::$d."transaction.invoice_id");
                $this->db->where('DATE_FORMAT(crm_transaction.created, "%Y-%m")=',date("Y-m", strtotime($m)));
                $this->db->where("order_status","paid");
                $q = $this->db->get(self::$d."invoice");
                if($q->num_rows() > 0)
                {
                   $ir[$m] = $q->num_rows();
                }else{
                    $ir[$m] = 0;
                }
            }
            return($ir);
        }else{
            return '';
        }
    }
    
    public function get_refined_services()
    {
        if($this->db->table_exists(self::$d."client_products"))
        {
            $s = array();
            if(isset($_GET) && count($_GET) > 0)
            {
                foreach($_GET as $k=>$v){
                    if($k=='service_name'){
                        $k = 'product_service_name';
                    }
                    if($k=='client_id'){
                        $k = 'client_uid';
                    }
                    array_push($s, $k);
                }
                $this->db->select(implode(",",$s) . ', add_date, bill_status');
                $this->db->join(self::$d."product_service",self::$d."product_service.product_service_id=".self::$d."client_products.product_id");
                $this->db->join(self::$d."client",self::$d."client.client_id=".self::$d."client_products.client_id");
                $q = $this->db->get(self::$d."client_products");
                
                if($q->num_rows() > 0)
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
    
    public function get_custom_income_l_report()
    {
        if($this->db->table_exists(self::$d."transaction"))
        {
            $ir = array();
            $month = array("jan","feb","mar","apr","may","jun","jul","aug","sept","oct","nov","dec");
            if(isset($_GET['rtype']) && $_GET['rtype']=='daily')
            {
                $y = $_GET['year'];
                $mn = $_GET['month'];
                $sitr = 1;
                $eitr = date('d', strtotime('last day of this month '.$mn));
                $month = array();
                for($k = $sitr; $k<=$eitr; $k++)
                {
                    array_push($month, $k."-".date('m', strtotime($mn))."-".$y);
                }
            }else{
                $y = isset($_GET['year'])?$_GET['year']:date("Y");
            }
            foreach($month as $m)
            {
                if(isset($_GET['rtype']) && $_GET['rtype']=='monthly'){
                    $this->db->where('DATE_FORMAT(crm_transaction.created, "%Y-%m")=',date("Y-m", strtotime($y."-".$m)));
                }else if(isset($_GET['rtype']) && $_GET['rtype']=='daily'){
                    $this->db->where('DATE_FORMAT(crm_transaction.created, "%Y-%m-%d")=',date("Y-m-d", strtotime($m)));
                }else{
                    $this->db->where('DATE_FORMAT(crm_transaction.created, "%Y-%m")=',date("Y-m", strtotime($m)));
                }
                $this->db->join(self::$d."invoice", self::$d."invoice.invoice_id=".self::$d."transaction.invoice_id");
                $this->db->where(self::$d."invoice.is_recurring","");
                $this->db->select(self::$d."transaction.amount");
                $q = $this->db->get(self::$d."transaction");
                if($q->num_rows() > 0)
                {
                    $t=0;
                    foreach($q->result() as $a)
                    {
                        $t += $a->amount;
                    }
                    $ir['a'][$m] = $t;
                }else{
                    $ir['a'][$m] = 0;
                }
            }
            return($ir);
        }else{
            return '';
        }
    }
    
    public function get_custom_income_c_report()
    {
        if($this->db->table_exists(self::$d."transaction"))
        {
            $ir = array();
            $month = array("jan","feb","mar","apr","may","jun","jul","aug","sept","oct","nov","dec");
            if(isset($_GET['rtype']) && $_GET['rtype']=='daily')
            {
                $y = $_GET['year'];
                $mn = $_GET['month'];
                $sitr = 1;
                $eitr = date('d', strtotime('last day of this month '.$mn));
                $month = array();
                for($k = $sitr; $k<=$eitr; $k++)
                {
                    array_push($month, $k."-".date('m', strtotime($mn))."-".$y);
                }
            }else{
                $y = isset($_GET['year'])?$_GET['year']:date("Y");
            }
            foreach($month as $m)
            {
                if(isset($_GET['rtype']) && $_GET['rtype']=='monthly'){
                    $this->db->where('DATE_FORMAT(crm_transaction.created, "%Y-%m")=',date("Y-m", strtotime($y."-".$m)));
                }else if(isset($_GET['rtype']) && $_GET['rtype']=='daily'){
                    $this->db->where('DATE_FORMAT(crm_transaction.created, "%Y-%m-%d")=',date("Y-m-d", strtotime($m)));
                }else{
                    $this->db->where('DATE_FORMAT(crm_transaction.created, "%Y-%m")=',date("Y-m", strtotime($m)));
                }
                $this->db->join(self::$d."invoice", self::$d."invoice.invoice_id=".self::$d."transaction.invoice_id");
                $this->db->where(self::$d."invoice.is_recurring","yes");
                $this->db->select(self::$d."transaction.amount");
                $q = $this->db->get(self::$d."transaction");
                if($q->num_rows() > 0)
                {
                    $t=0;
                    foreach($q->result() as $a)
                    {
                        $t += $a->amount;
                    }
                    $ir['a'][$m] = $t;
                }else{
                    $ir['a'][$m] = 0;
                }
            }
            return($ir);
        }else{
            return '';
        }
    }
    
    public function get_all_report_of_emp()
    {
        if($this->db->table_exists(self::$d."agent"))
        {
            $r['d'] = $r['w'] = $r['m'] = $r['y'] = $r['filter'] = array();
            $wdfrom = date("Y-m-d", strtotime('-7days'));
            $mfrom = date("Y-m-d", strtotime('-30days'));
            $yfrom = date("Y-m-d", strtotime('-1year'));
            
            $agents = get_module_values('agent');
            if(isset($agents) && !empty($agents))
            {
                $wstatus = get_info_of('status','status_id','won','status_name');
                
                foreach($agents as $a){
                    $invtotal = 0;
                    $this->db->where("assign_to_agent", $a->agent_id);
                    $this->db->where("status",$wstatus);
                    $q = $this->db->get("lead");
                    $l = ($q->num_rows() > 0) ? $q->result() : '';
                    $clients = array();
                    if(!empty($l)){
                        foreach($l as $fl){
                            $c_id = get_info_of('client','client_id',$fl->assign_to_agent,'by_agent');
                            $c_id = $c_id == '-' || $c_id == '' ? get_info_of('client','client_id',$fl->email_id,'client_email') : $c_id;
                            array_push($clients, $c_id);
                        }
                    }
                    //daily
                    foreach($clients as $c){
                        $this->db->where('DATE_FORMAT(updated, "%Y-%m-%d")=', date("Y-m-d"));
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
                    $r['d'][$a->agent_name] = $invtotal;
                    
                    //find weekly
                    $invtotal = 0;
                    foreach($clients as $c){
                        $this->db->where('DATE_FORMAT(updated, "%Y-%m-%d")>=', $wdfrom);
                        $this->db->where('DATE_FORMAT(updated, "%Y-%m-%d")<=', date("Y-m-d"));
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
                    $r['w'][$a->agent_name] = $invtotal;
                    
                    //find monthly
                    $invtotal = 0;
                    foreach($clients as $c){
                        $this->db->where('DATE_FORMAT(updated, "%Y-%m-%d")>=', $mfrom);
                        $this->db->where('DATE_FORMAT(updated, "%Y-%m-%d")<=', date("Y-m-d"));
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
                    $r['m'][$a->agent_name] = $invtotal;
                    
                    //find yearly
                    $invtotal = 0;
                    foreach($clients as $c){
                        $this->db->where('DATE_FORMAT(updated, "%Y-%m-%d")>=', $yfrom);
                        $this->db->where('DATE_FORMAT(updated, "%Y-%m-%d")<=', date("Y-m-d"));
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
                    $r['y'][$a->agent_name] = $invtotal;
                    
                    //if using filter
                    if(isset($_GET) && count($_GET) > 0){
                        $invtotal = 0;
                        $from = strtolower($_GET['erdatef']);
                        $to = strtolower($_GET['erdatet']);
                        if(!empty($from) && !empty($to)){
                            if($from==$to)
                            {
                                $this->session->set_flashdata("error","Date range is not valid!");
                                redirect($_SERVER['HTTP_REFERER']);
                            }
                            $mns = $this->getMonths($from, $to);
                            if($mns > 11)
                            {
                                $this->session->set_flashdata("error","Range can be selected only for 12 months.");
                                redirect($_SERVER['HTTP_REFERER']);
                            }
                        }  
                        if(isset($_GET['ps']) && !empty($_GET['ps']))
                        {
                            $this->db->where("service", base64_decode($_GET['ps']));
                        }
                        if(isset($_GET['employee']) && !empty($_GET['employee']))
                        {
                            $this->db->where("assign_to_agent", base64_decode($_GET['employee']));
                        }
                        if(isset($_GET['status']) && !empty($_GET['status']))
                        {
                            $this->db->where("status", $_GET['status']);
                        }
                        if(!empty($from) && !empty($to))
                        {
                            $this->db->where('DATE_FORMAT(created, "%Y-%m-%d")>=', date("Y-m-d", strtotime($from)));
                            $this->db->where('DATE_FORMAT(created, "%Y-%m-%d")<=', date("Y-m-d", strtotime($to)));
                        }
                        $ql = $this->db->get(self::$d."lead");
                        if($ql->num_rows() > 0){
                            return $ql->result();
                        }else{
                            return '';
                        }
                    }
                }
                
                $er = array("d"=>$r['d'],"w"=>$r['w'],"m"=>$r['m'],"y"=>$r['y']);
                return $er;
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
    
    public function get_client_resource()
    {
        if($this->db->table_exists(self::$d."lead_source"))
        {
            $lsource = get_module_values('lead_source');
            if(!empty($lsource))
            {
                $month = array("jan","feb","mar","apr","may","jun","jul","aug","sept","oct","nov","dec");
                $from = isset($_GET['crsrcdatef']) ? strtolower($_GET['crsrcdatef']) :'';
                $to = isset($_GET['crsrcdatet']) ? strtolower($_GET['crsrcdatet']) :'';
                if(!empty($from) && !empty($to)){
                    if($from==$to)
                    {
                        $this->session->set_flashdata("error","Date range is not valid!");
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                    $mns = $this->getMonths($from, $to);
                    if($mns > 11)
                    {
                        $this->session->set_flashdata("error","Range can be selected only for 12 months.");
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                    $from = explode("-",$from); $from=$from[1]."-".$from[2];
                    $to = explode("-",$to); $to = $to[1]."-".$to[2];
                    $er['from'] = ucfirst($from);
                    $er['to'] = ucfirst($to);
                    $month = array();
                    array_push($month, date('M-Y', strtotime($from)));
                    for($i=0; $i<$mns;$i++)
                    {
                        array_push($month, date('M-Y', strtotime("+1month",strtotime($from))));
                        $from = date("M-Y", strtotime("+1month",strtotime($from)));
                    }
                }
                foreach($month as $m){
                    foreach($lsource as $src)
                    {
                        $wstatus = get_info_of('status','status_id','won','status_name');
                        $invtotal = 0;
                        
                        $this->db->where('DATE_FORMAT(created, "%Y-%m")>=', date("Y-m", strtotime($m)));
                        $this->db->where('DATE_FORMAT(created, "%Y-%m")<=', date("Y-m", strtotime($m)));
                        
                        $this->db->where("lead_source", $src->lead_source_id);
                        $this->db->where("status",$wstatus);
                        $q = $this->db->get("lead");
                        $l = ($q->num_rows() > 0) ? $q->result() : '';
                        $count = $q->num_rows();
                        $clients = array();
                        if(!empty($l)){
                            foreach($l as $fl){
                                array_push($clients, get_info_of('client','client_id',$fl->lead_id,'lead_id'));
                            }
                        }
                        //daily
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
                       $r['count'][$src->lead_source_name] = $count;
                       $r['income'][$src->lead_source_name] = $invtotal; 
                    }
                    $r[$m] = array("c"=>$r['count'],"i"=>$r['income']);
                }
                unset($r['income']);unset($r['count']);
                return $r;
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
    
    public function get_all_clients()
    {
        if($this->db->table_exists(self::$d."client"))
        {
            $this->db->select(
            self::$d."client.client_id,".    
            self::$d."client.client_name,"
            .self::$d."client.client_email,"
            .self::$d."client.client_mobile,".self::$d."client.client_state");
            
            if(isset($_GET['service']) && !empty($_GET['service'])){
                $this->db->where(self::$d."client_products.product_id", base64_decode($_GET['service']));
            }
            if(isset($_GET['state']) && !empty($_GET['state'])){
                $this->db->where(self::$d."client.client_state", base64_decode($_GET['state']));
            }
            if(isset($_GET['ccrdatef']) && !empty($_GET['ccrdatef'])
            && isset($_GET['ccrdatet']) && !empty($_GET['ccrdatet'])){
                $this->db->where(self::$d."client.created >=", date("Y-m-d", strtotime($_GET['ccrdatef'])));
                $this->db->where(self::$d."client.created <=", date("Y-m-d", strtotime($_GET['ccrdatet'])));
            }
            if(isset($_GET['service']) && !empty($_GET['service'])){
                $this->db->join(self::$d."client_products",self::$d."client_products.client_id=".self::$d."client.client_id");
                $this->db->group_by(self::$d."client_products.client_id");
            }
            $q = $this->db->get(self::$d."client");
            
            if($q->num_rows() > 0)
            {
                return($q->result());
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
    
    public function getMonths($d1, $d2)
    {
        $date1 = $d1;
        $date2 = $d2;
        
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);
        
        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);
        
        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);
        
        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
        return $diff;
    }
   
}

?>