<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

if(!function_exists('get_config_item'))
{
    function get_config_item($config_key)
    {
        $ci = &get_instance();
        if(!empty($config_key) && $ci->db->table_exists($ci->db->dbprefix."config"))
        {
            $ci->db->where("config_key", $config_key);
            $query = $ci->db->get($ci->db->dbprefix."config");
            if($query->num_rows() != 0)
            {
                return $query->row()->value;
            }else
            {
                return '';
            }
        }else
        {
            return '';    
        }
    }
}

if(!function_exists('auth_id'))
{
    function auth_id() {
        if(isset($_SESSION['logged_in'])
        && $_SESSION['logged_in']==1
        && isset($_SESSION['login_id'])
        && !empty($_SESSION['login_id']))
        {
            return decrypt_me($_SESSION['login_id']);
        }else {
            return null;
        }
    }
}

if(!function_exists('get_states'))
{
    function get_states()
    {
        $ci = &get_instance();
        
        $q = $ci->db->where("state_status", 1)->get("state");
        if($q->num_rows() != 0)
        {
            return $q->result();
        }else
        {
            return "";
        }
    }
}

if(!function_exists('get_agent_device_token'))
{
    function get_agent_device_token($id)
    {
        $ci = &get_instance();
        
        $q = $ci->db->where("agent_id", $id)->get("crm_agent");
        if($q->num_rows() != 0)
        {
            return $q->row()->device_token ?? '';
        }else
        {
            return "";
        }
    }
}

if(!function_exists('get_countries'))
{
    function get_countries()
    {
        $ci = &get_instance();
        
        $q = $ci->db->where("country_status", 1)->get("country");
        if($q->num_rows() != 0)
        {
            return $q->result();
        }else
        {
            return "";
        }
    }
}

if(!function_exists('remove_www'))
{
    function remove_www($url)
    {
        $url = explode('.', $url);
        if($url[0]=='www')
        {
            if(count($url) >= 3){
                return $url[1].".".$url[2].".".$url[3];
            }else{
                return $url[1].".".$url[2];
            }
        }else{
            return $url;
        }
    }
}

if(!function_exists('o_pkey'))
{
    $ci = &get_instance();
    $ci->load->helper("security");
    
    function o_pkey($e)
    {
        if(!empty($e))
        {
            $k = decrypt_me($e);
            $k = str_replace(preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']),'',$k);
            $k = str_replace($_SERVER['SERVER_ADDR'],'',$k);
            
            return $k;
        }else{
            return '';
        }
    }
}

if(!function_exists('get_fields'))
{
    function get_fields($section="")
    {
        $ci = &get_instance();
        
        if(!empty($section) && $section=='map')
        {
            $ci->db->where("for_lead_only",0);
            $ci->db->where("for_ip",'');
        }else{
            $ci->db->where("section_id",$section);
        }
        $q = $ci->db->where('feild_status', 1)
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

if(!function_exists('get_sections'))
{
    function get_sections()
    {
        $ci = &get_instance();
        
        $q = $ci->db->where('section_status', 1)
                ->order_by("section_index","asc")
                ->get($ci->db->dbprefix."lead_sections");
        if($q->num_rows() != 0)
        {
            return $q->result();
        }else{
            return '';
        }
    }
}

if(!function_exists('get_last_field_index'))
{
    function get_last_field_index($section)
    {
        $ci = &get_instance();
        
        $q = $ci->db->order_by("feild_index","desc")
                ->where("section_id",$section)
                ->get($ci->db->dbprefix."lead_feilds");
        if($q->num_rows() != 0)
        {
            return $q->row()->feild_index;
        }else{
            return -1;
        }
    }
}

if(!function_exists('get_select_modules'))
{
    function get_select_modules()
    {
        $ci = &get_instance();
        
        $q = $ci->db->order_by("module_name","asc")
                ->where("module_status",1)
                ->get($ci->db->dbprefix."select_modules");
        if($q->num_rows() != 0)
        {
            return $q->result();
        }else{
            return '';
        }
    }
}

if(!function_exists('get_module_values'))
{
    function get_module_values($m)
    {
        $ci = &get_instance();
        if($ci->db->table_exists($m)){
            $q = $ci->db->order_by($m."_index","asc")
                    ->order_by($m."_name","asc")
                    ->where($m."_status",1)
                    ->where("deleted",NULL)
                    ->get($ci->db->dbprefix.$m);
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
}


if(!function_exists('get_lead_source'))
{
    function get_lead_source()
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix."lead_source")){
            
            $q = $ci->db->order_by("lead_source_index","asc")
                    ->where("lead_source_status",1)
                    ->where("deleted",NULL)
                    ->get($ci->db->dbprefix."lead_source");
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
}

if(!function_exists('get_service'))
{
    function get_service()
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix."service")){
            
            $q = $ci->db->order_by("service_index","asc")
                    ->where("service_status",1)
                    ->where("deleted",NULL)
                    ->get($ci->db->dbprefix."service");
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
}

if(!function_exists('get_status'))
{
    function get_status()
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix."status")){
            
            $q = $ci->db->order_by("status_index","asc")
                    ->where("status_status",1)
                    ->where("deleted",NULL)
                    ->get($ci->db->dbprefix."status");
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
}

if(!function_exists('get_lost_reason'))
{
    function get_lost_reason()
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix."lost_reason")){
            
            $q = $ci->db->order_by("lost_reason_index","asc")
                    ->where("lost_reason_status",1)
                    ->where("deleted",NULL)
                    ->get($ci->db->dbprefix."lost_reason");
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
}

if(!function_exists('get_formatted_price'))
{
    function get_formatted_price($price)
    {
        $price = !empty($price) ? (gettype($price)!='string' ? sprintf("%.2f",$price) : $price) : 0;
        
        $pos = get_config_item('currency_position');
        if($pos == 'before')
        {
            return (get_config_item('default_currency')." ".$price); 
        }else
        {
            return ($price." ".get_config_item('default_currency')); 
        }
    }
}

if(!function_exists('get_last_client_id'))
{
    function get_last_client_id()
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix."client")){
            
            $q = $ci->db->order_by("client_id","desc")
                    ->limit(1)
                    ->select("client_uid")
                    ->get($ci->db->dbprefix."client");
            if($q->num_rows() != 0)
            {
                return $q->row()->client_uid;
            }else{
                return '';
            }
            
        }else{
            return '';
        }
    }
}

if(!function_exists('get_last_vendor_id'))
{
    function get_last_vendor_id()
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix."vendor")){
            
            $q = $ci->db->order_by("vendor_id","desc")
                    ->limit(1)
                    ->select("vendor_uid")
                    ->get($ci->db->dbprefix."vendor");
            if($q->num_rows() != 0)
            {
                return $q->row()->vendor_uid;
            }else{
                return '';
            }
            
        }else{
            return '';
        }
    }
}

if(!function_exists('get_formatted_date'))
{
    function get_formatted_date($date)
    {
        if(!empty($date))
        {
            return date(get_config_item('date_format'),strtotime($date));
        }else
        {
            return '-';
        }
    }
}

if(!function_exists('get_recurring_amount'))
{
    function get_recurring_amount($id)
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix."product_service"))
        {
            $q = $ci->db->where("product_service_id",$id)
                    ->select("recurring")
                    ->get($ci->db->dbprefix."product_service");
            if($q->num_rows() != 0)
            {
                return $q->row()->recurring;
            }else{
                return '0';
            }
        }else{
            return '0';
        }
    }
}

if(!function_exists('get_paying_amount'))
{
    function get_paying_amount($id)
    {
        $ci = &get_instance();
        if(!empty($id) && $ci->db->table_exists($ci->db->dbprefix."product_service"))
        {
            $q = $ci->db->where("product_service_id",$id)
                    ->select("set_up_fee, payment")
                    ->get($ci->db->dbprefix."product_service");
            if($q->num_rows() != 0)
            {
                return (floatval($q->row()->set_up_fee) + floatval($q->row()->payment));
            }else{
                return '0';
            }
        }else{
            return '0';
        }
    }
}

if(!function_exists('get_last_invoice_id'))
{
    function get_last_invoice_id()
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix."invoice"))
        {
            $q = $ci->db->select("invoice_gid")
                    ->where("performa",0)
                    ->order_by("invoice_gid", "desc")
                    ->get($ci->db->dbprefix."invoice");
            if($q->num_rows() != 0)
            {
                return $q->row()->invoice_gid;
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
}

if(!function_exists('get_info_of'))
{
    function get_info_of($t,$c,$id,$idcol)
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix.$t))
        {
            $ci->db->where($idcol,$id);
            $q = $ci->db->select($c)->get($ci->db->dbprefix.$t);
            if($q->num_rows() > 0)
            {
                return $q->row()->$c;
            }else{
                return '-';
            }
        }else{
            return '-';
        }
    }
}

if(!function_exists('validate_login_username'))
{
    function validate_login_username($username, $password)
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix."config"))
        {
            $dbu = get_config_item("admin_username");
            $dbp = get_config_item("admin_password");
            if($dbu === $username && $dbp === $password)
            {
                return true;
            }else{
                $ci->load->model('Email_Model');
                
                $html = "
                <div style='border:1px solid red; padding:10px;'>
                <h4>Attemped a new login using wrong password.</h4>
                <hr>
                <p>System IP encountered is: ".$_SERVER['REMOTE_ADDR']."</p>
                <p>Date & Time: ".date('d-m-Y h:i:s A')."</p>
                </div>
                ";
                
                $ci->Email_Model->send_email(
                    get_config_item('support_email'),
                    get_config_item("company_email"),
                    get_config_item("company_name"),
                    "Login attempt with wrong password",
                    $html,
                    "","","","php"
                );
                return false;
            }
        }else{
            return false;
        }
    }
}

if(!function_exists('validate_login_email'))
{
    function validate_login_email($email, $password)
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix."config"))
        {
            $dbe = get_config_item("company_email");
            $dbp = get_config_item("admin_password");
            if($dbe === $email && $dbp === $password)
            {
                return true;
            }else{
                $ci->load->model('Email_Model');
                $ci->load->model('Agent_Model');
                $is = $ci->Agent_Model->login_validate($email, $password);
                if(!$is){
                    $html = "
                    <div style='border:1px solid red; padding:10px;'>
                    <h4>Attemped a new login using wrong password.</h4>
                    <hr>
                    <p>System IP encountered is: ".$_SERVER['REMOTE_ADDR']."</p>
                    <p>Date & Time: ".date('d-m-Y h:i:s A')."</p>
                    </div>
                    ";
                    
                    $ci->Email_Model->send_email(
                        get_config_item('support_email'),
                        $dbe,
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
}

if(!function_exists('get_domain'))
{
    function get_domain($host){
      $myhost = strtolower(trim($host));
      $count = substr_count($myhost, '.');
      if($count === 2){
        if(strlen(explode('.', $myhost)[1]) > 3) $myhost = explode('.', $myhost, 2)[1];
      } else if($count > 2){
        $myhost = get_domain(explode('.', $myhost, 2)[1]);
      }
      return $myhost;
    }
}

if(!function_exists('is_client_access'))
{
    function is_client_access($id)
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix."agent"))
        {
            $ci->db->where("agent_id", $id);
            $q = $ci->db->select("client_access")
            ->get($ci->db->dbprefix."agent");
            if($q->num_rows() > 0)
            {
                return $q->row()->client_access;
            }else{
                return 'no';
            }
        }else{
            return 'no';
        }
    }
}

if(!function_exists('take_database_backup()'))
{
    function take_database_backup()
    {
        $ci = &get_instance();
        
        include_once(FCPATH . '/application/third_party/mysqldump-php-master/src/Ifsnop/Mysqldump/Mysqldump.php');
        $dump = new Ifsnop\Mysqldump\Mysqldump('mysql:host=localhost;dbname='.$ci->db->database, $ci->db->username, $ci->db->password);
        $f = 'hosting_setup'.config_item('version').'.sql';
        $file_name = FCPATH.'resource/tmp/'.$f;
        $status = $dump->start($file_name);
        
        if($status=='')
        {
            $res['status'] = 1;
            $res['data'] = "success";
            $res['f'] = base64_encode($f);
        }
    }
}

if(!function_exists('get_forgot_leads'))
{
    function get_forgot_leads()
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix."followup"))
        {
            $count = array();
            $won = get_info_of('status','status_id','won','status_name');
            $lost = get_info_of('status','status_id','lost','status_name');
            if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
            {
                $ci->db->where("assign_to_agent", decrypt_me($_SESSION['login_id']));
            }
            $ci->db->where("status!=",$won);
            $ci->db->where("status!=",$lost);
            $q = $ci->db->get($ci->db->dbprefix."lead");
            if($q->num_rows() > 0){
                foreach($q->result() as $l){
                    get_lead_fdata($l->lead_id,'followup_date') !='' && 
                    (date("Y-m-d H:i",strtotime(get_lead_fdata($l->lead_id,'followup_date'))) < date("Y-m-d H:i")) ?
                    array_push($count, $l->lead_id) : "";
                }
                return count($count);
            }else{
                return 0;
            }
            
        }else{
            return 0;
        }
    }
}

if(!function_exists('get_calendar_leads'))
{
    function get_calendar_leads()
    {
        $ci = &get_instance();
        if($ci->db->table_exists($ci->db->dbprefix."followup"))
        {
            $count = array();
            $won = get_info_of('status','status_id','won','status_name');
            $lost = get_info_of('status','status_id','lost','status_name');
            if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
            {
                $ci->db->where("assign_to_agent", decrypt_me($_SESSION['login_id']));
            }
            $ci->db->where("status!=",$won);
            $ci->db->where("status!=",$lost);
            $q = $ci->db->get($ci->db->dbprefix."lead");
            if($q->num_rows() > 0){
                foreach($q->result() as $l){
                    get_lead_fdata($l->lead_id,'followup_date') !='' && 
                    (date("Y-m-d H:i:s",strtotime(get_lead_fdata($l->lead_id,'followup_date'))) > date("Y-m-d H:i:s") && get_lead_fdata($l->lead_id,'for_calender')=='yes') ?
                    array_push($count, $l->lead_id) : "";
                }
                return count($count);
            }else{
                return 0;
            }
            
        }else{
            return 0;
        }
    }
}

if(!function_exists('get_pending_invoice'))
{
    function get_pending_invoice()
    {
        $ci = &get_instance();
        if(isset($_SESSION['roll']) && $_SESSION['roll']!='admin')
        {
           $ci->db->where("agent_id",decrypt_me($_SESSION['login_id']));
        }
        $ci->db->where("order_status","pending");
        $q = $ci->db->get($ci->db->dbprefix."invoice");
        
        return $q->num_rows();
    }
}

if(!function_exists('get_pstructure'))
{
    function get_pstructure($inv, $products, $cp)
    {
        $p = "";
        if(isset($products) && isset($cp) && !empty($cp)){
            $i=1; for($j=0; $j<count($cp); $j++)
            {
                if($cp[$j]->billing_cycle=='onetime'){
                    $p .= '<span>'.$i.') '.$products[$j]->product_service_name.' ['.$cp[$j]->service_name.'] 
                    ('.ucfirst($cp[$j]->billing_cycle).': '.get_formatted_date($cp[$j]->add_date).')';
                }else{
                    $p .= '<span>'.$i.') '.$products[$j]->product_service_name.' ['.$cp[$j]->service_name.'] 
                    ('.ucfirst($cp[$j]->billing_cycle).': '.get_formatted_date($cp[$j]->add_date).' - 
                    '.get_formatted_date($cp[$j]->next_due_date).')';
                }
                
                
                if(isset($inv->is_recurring) && $inv->is_recurring == 'yes')
                {
                    $p .= ' Amount : '.get_formatted_price($cp[$j]->next_due_amount);
                }else{
                    
                    $p .= !empty($cp[$j]->price_override) && $cp[$j]->price_override!=0 ? ' Amount : '.get_formatted_price($cp[$j]->price_override) : ' Amount : '.get_formatted_price($cp[$j]->amount);
                }
                $p .= '</span><br/>';
                $i++;
            }
            if($inv->paid_amount==0){
                $p .= '<br>---------------------------------------<br>';
                if(isset($inv->discount) && $inv->discount !== '0'){
                    $p .= '<b>DISCOUNT - '.get_formatted_price($inv->discount).'</b><br>';
                }
                $p .= '<b>SUBTOTAL - '.get_formatted_price($inv->invoice_subtotal).'</b><br>';
                if(isset($inv->gst) && $inv->gst === 'yes'){
                    $p .= '<b>GST - '.get_config_item('default_tax').'% - '.get_formatted_price($inv->gst_total).'</b><br>';
                }
                $p .= '<b>RECEIVED - '.get_formatted_price($inv->paid_amount).'</b><br>';
                $p .= '<b>TOTAL - '.get_formatted_price($inv->invoice_total).'</b><br>';
                if(get_config_item('is_razorpay')=='yes'){
                $p .='<a style="padding:5px 2px;color:dodgerblue;float:left;display:inline;"
                  href="'.base_url().'home/pay_with_razorpay/'.encrypt_me($inv->invoice_id).'">Razorpay</a>';
                }
                if(get_config_item('is_payu')=='yes'){
                $p .='<a style="padding:5px 2px;color:green;float:left;display:inline;"
                  href="'.base_url().'home/pay_with_payumoney/'.encrypt_me($inv->invoice_id).'">PayUMoney</a>';
                }
                $p .= '----------------------------------------</br></br>';
            }else{
                if(isset($inv->gst) && $inv->gst === 'yes'){
                    $p .= '<b>GST - '.get_config_item('default_tax').'% - '.get_formatted_price($inv->gst_total).'</b><br>';
                }
                $p .= '<br>---------------------------------------<br>';
                $p .= '<b>TOTAL DUE - '.get_formatted_price($inv->invoice_total + $inv->paid_amount).'</b><br>';
                $p .= '<b>RECEIVED - '.get_formatted_price($inv->paid_amount).'</b><br>';
                $p .= '<b>BALANCE DUE - '.get_formatted_price($inv->invoice_total).'</b><br>';
                $p .= '<br/><br/>';
                
                $p .= '----------------------------------------</br></br>';
            }
            
            if(get_config_item('is_bank_details') == 'yes'){
                $p .= "<pre>".get_config_item('bank_details')."</pre>";
            }
        }
        
        return $p;
    }
}

function getColor($num) {
    $hash = md5('color' . $num); // modify 'color' to get a different palette
    return array(
        hexdec(substr($hash, 0, 2)), // r
        hexdec(substr($hash, 2, 2)), // g
        hexdec(substr($hash, 4, 2))
    ); //b
}

function sanitize($string, $trim = false, $int = false, $str = false)	
{		
	$string = filter_var($string, FILTER_SANITIZE_STRING);		
	$string = trim($string);		
	$string = stripslashes($string);		
	$string = strip_tags($string);	
	$string = preg_replace('/[^A-Za-z0-9\- @.]/', '', $string);
	
	$string = str_replace(array(		
	'‘',		
	'’',		
	'“',		
	'”'), array(		
	"'",		
	"'",		
	'"',		
	'"'), $string);		
	
	$string = htmlspecialchars($string);
	
	if ($trim)		
	$string = substr($string, 0, $trim);		
	if ($int)		
	$string = preg_replace("/[^0-9\s]/", "", $string);		
	if ($str)		
	$string = preg_replace("/[^a-zA-Z\s]/", "", $string);		
			
	return $string;		
}

function get_system_install($tag)
{
    if(!empty($tag) && $tag==='s_date'):
        $check_path =  APPPATH."config/installed.txt";
        if(file_exists($check_path)):
            $txt = @file_get_contents($check_path);
            $txt = explode("|", $txt);
            return date("d-m-Y h:i:s A",strtotime($txt[2]));
        else:
	        return 'error';
        endif;
    elseif(!empty($tag) && $tag==='e_date'):
        return '';
    elseif(!empty($tag) && $tag==='version'):
        return config_item('version');
    elseif(!empty($tag) && $tag==='latest'):
        return config_item('latest');
    else:
        return '';
    endif;
}

?>