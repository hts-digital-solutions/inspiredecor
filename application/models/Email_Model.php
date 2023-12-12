<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once APPPATH.'third_party/PHPMailer/Exception.php';
require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
require_once APPPATH.'third_party/PHPMailer/SMTP.php';

class Email_Model extends CI_Model {
    
    private static $d;
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $d = $this->db->dbprefix;
        $this->load->helper("sconfig_helper");
        $this->load->library("email");
    }
    
    public function send_email($from, $to, $dname, $subject, $message, $client="", $invoice="", $attach="", $type="")
    {
        $mailtype = empty($type) ? get_config_item('mail_type') : $type;
        $s = false;
        if($mailtype == 'php')
        {
            $s = $this->send_php_mail($from,$dname,$subject, $to, $message,$attach);
        }else if($mailtype == 'smtp')
        {
            $s = $this->send_smtp_mail($from, $to,$dname, $subject, $message,$attach);
        }
        
        if(!empty($client))
        {
          $data = array(
              'client_id' => $client,
              'for_invoice' => $invoice,
              'email_subject' => $subject,
              'email_template' => 0,
              'email_content' => $message,
              'is_sent' => ($s==true) ? 1 : 0,
              'sent_to' => $to,
              'created' => date('Y-m-d')
          );
          $is = $this->db->insert(self::$d."client_email_history", $data);
          
          if($is || $s)
          {
              return true;
          }else{
              return false;
          }
        }else if($s){
            return true;
        }else{
            return $s;
        }
    }
    
    public function send_php_mail($from="",$dname="",$subject, $to, $content, $attach) {
        if(!empty($to) && !empty($content)) {
            
            $this->email->set_mailtype("html");
            $this->email->from($from, $dname);
            $this->email->subject($subject);
            $this->email->to($to);
            $this->email->attach($attach);
            $this->email->message($content);
            if(filter_var($to, FILTER_VALIDATE_EMAIL)){
                $status = $this->email->send();
                return $status;
            }else{
                return false;
            }
        }else {
            return false;
        }
    }
    
    public function send_smtp_mail($from, $to,$dname="", $subject, $message, $attach) {
        $config = array();
        $config['smtp_username'] = get_config_item('smtp_user');
        $config['smtp_password'] = get_config_item('smtp_pass');
        $config['smtp_server'] = get_config_item('smtp_host');
        $config['smtp_port'] = get_config_item('smtp_port');
        
        if(!empty($config)
            && !empty($from)
            && !empty($to)
            && !empty($message)
        ){
            $mail = new PHPMailer;
            $mail->SMTPAuth = true;
            
            $mail->Username = $config['smtp_username'];
            $mail->Password = $config['smtp_password'];
            $mail->Host = $config['smtp_server'];
            $mail->Port = $config['smtp_port'];
            
            $mail->setFrom($from, $dname);
            $mail->addReplyTo($from, $dname);
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->addAttachment($attach);
            $mail->Body = $message;
            
            if(filter_var($to, FILTER_VALIDATE_EMAIL) && $mail->SmtpConnect()){
                if(!$mail->send()){
                    return false;
                }else{
                    return true;
                }
            }else{
                return false;
            }
        }
    }
    
}
?>