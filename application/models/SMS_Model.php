<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class SMS_Model extends CI_Model {
    
    private static $d;
    private static $sms_host;
    private static $sms_username;
    private static $sms_userid;
    private static $sms_password;
    private static $api_key;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("sconfig_helper");
        date_default_timezone_set("Asia/Kolkata");
        self::$d = $this->db->dbprefix;
        self::$sms_host = get_config_item('sms_host');
        self::$sms_username = get_config_item('sms_user');
        self::$sms_userid = get_config_item('sms_user_id');
        self::$sms_password = get_config_item('sms_pass');
        self::$api_key = get_config_item('sms_api_key');
    }
    
    public function send_sms($numbers, $subject="", $message="", $client="", $invoice="")
    {
        
        if(!empty($numbers) && !empty($message))
        {
            if(
               !empty(self::$sms_username)
               && !empty(self::$sms_password)
               && !empty(self::$sms_userid)
               && !empty(self::$sms_host)
            ){
              $d_message = $message;
              $message=urlencode($subject.$message);

              $url = self::$sms_host.'?username='.self::$sms_username.'&password='.self::$sms_password.'&sender='.self::$sms_userid.'&message='.$message.'&numbers='.$numbers;
              $ch = curl_init();
              curl_setopt ($ch, CURLOPT_URL, $url);
              curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
              curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
              $status = curl_exec($ch);
              $status = json_decode($status);
              
              //save info if client is
              if(!empty($client) || $client==0)
              {
                  $data = array(
                      'client_id' => $client,
                      'for_invoice' => $invoice,
                      'sms_subject' => $subject,
                      'sms_template' => 0,
                      'sms_content' => $d_message,
                      'is_sent' => ($status->return) ? 1 : 0,
                      'sent_to' => $numbers,
                      'created' => date('Y-m-d h:i:s')
                  );
                  $is = $this->db->insert(self::$d."client_sms_history", $data);
                  
                  if($is && $status->return)
                  {
                      return true;
                  }else{
                      return false;
                  }
              }else if($status->return)
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
    }
    
    public function get_all_sms()
    {
        if($this->db->table_exists(self::$d."client_sms_history"))
        {
          
           
           if(isset($_GET['smsFrom']) && isset($_GET['smsTo']) && !empty($_GET['smsFrom']) && !empty($_GET['smsTo']))
           {
               $this->db->where(self::$d."client_sms_history.created >=", date("Y-m-d",strtotime($_GET['smsFrom'])));
               $this->db->where(self::$d."client_sms_history.created <=", date("Y-m-d",strtotime($_GET['smsTo'])));
           }
            
           if(isset($_GET['status']) && $_GET['status']!='')
           {
               $this->db->where(self::$d."client_sms_history.is_sent", $_GET['status']);
           }
           if(isset($_GET['client']) && !empty($_GET['client']))
           {
               $this->db->like(self::$d."client.client_name", $_GET['client']);
           }
           if(isset($_GET['client']) && !empty($_GET['client']))
           {
               $this->db->join(self::$d."client", self::$d."client.client_id=".self::$d."client_sms_history.client_id");
           }
           $this->db->order_by("client_sh_id","desc");
           $q = $this->db->get(self::$d."client_sms_history");
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
    
    public function get_sms_balance()
    {
        if(!empty(self::$api_key))
        {
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "http://sms.itinfoclub.com/api_v2/user/balance",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_HTTPHEADER => array(
                "authorization: Bearer ".self::$api_key,
                "cache-control: no-cache",
                "content-type: application/json"
              ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
              return json_encode(array("error" => "cURL Error #:" . $err));
            } else {
              return $response;
            }
        }else{
            return 0;
        }
    }
    
    public function sms_sent_this_month()
    {
        $res = array("success"=>false,"total"=>0);
        if(!empty(self::$api_key))
        {
            $df = date("Y-m-d", strtotime("-30days"))." 00:00:00";
            $dto = date("Y-m-d")." 23:59:59";
            if(isset($df) && isset($dto) && !empty($df) && !empty($dto))
            {
               $this->db->where('STR_TO_DATE(`created`, "%Y-%m-%d %H:%i:%s") >=', $df);
               $this->db->where('STR_TO_DATE(`created`, "%Y-%m-%d %H:%i:%s") <=', $dto);
            }
            $this->db->where("is_sent",1);
            $q = $this->db->get(self::$d."client_sms_history");
            if($q->num_rows() !=0)
            {
               $res['success'] = true;
               $res['total'] = $q->num_rows();
            }
        }
        return json_encode($res);
    }
    
    public function add_sms_credit()
    {
        if(isset($_GET) && !empty($_GET) && $this->db->table_exists(self::$d."sms_credit"))
        {
            $save = array(
                "sms_userid" =>  sanitize(self::$sms_userid),
                "sms_username" => sanitize(self::$sms_username),
                "sms_credit_req" => isset($_GET['q']) ? sanitize(decrypt_me($_GET['q'])) : '',
                "sms_credit_price" => isset($_GET['p']) ? sanitize(decrypt_me($_GET['p'])) : '',
                "payment_method" => isset($_GET['pm']) ? sanitize(decrypt_me($_GET['pm'])) : '',
                "payment_id" => isset($_GET['pid']) ? sanitize(decrypt_me($_GET['pid'])) : '',
                "req_ip" => sanitize($_SERVER['REMOTE_ADDR']),
                "status" => isset($_GET['s']) ? sanitize(decrypt_me($_GET['s'])) : 'failed',
                "created" => strtotime("now")
            );
            
            $this->db->insert(self::$d."sms_credit", $save);
            return $this->db->insert_id();
        }
    }
    
    public function get_credit_history()
    {
        if($this->db->table_exists(self::$d."sms_credit"))
        {
            $this->db->order_by("created","desc");
            $q = $this->db->get(self::$d."sms_credit");
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
}
?>