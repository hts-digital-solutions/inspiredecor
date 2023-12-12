<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class System_Installer extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
        if ($this->_is_install() && $this->uri->segment(2) != 'completed') {
            exit('Application already installed. Need help? https://bizavtar.com');
        }
        $this->load->helper(array('url','form','file','security'));
    }
    
    public function index()
    {
        redirect('System_Installer/setup?step=1');
    }
    
    public function start()
    {
        $this->session->sess_destroy();
        $this->_step_complete('system_check', '2');
        redirect('System_Installer/setup?step=2');
    }
    
    public function setup(){
        $this->load->view("system_install");
    }
    
    public function db_setup()
    {
        $this->_keep_step_data($_POST,3);
        if($this->_step_status('verify')=='complete' 
        && $this->_step_status('next_step')==3)
        {
            $db_connect = $this->verify_db_connection();
    
            if ($db_connect) {
                $create_config = $this->_create_db_config();
                $this->_step_complete('database_setting', '4');
                if(!$this->_prepare_db(config_item('version')))
                {
                    $this->session->set_flashdata('error', 'Database import failed. Check if the file exists: resource/tmp/hosting_setup'. config_item('version') .'.sql');
                    redirect('System_Installer/setup?step=3'); 
                }
                redirect('System_Installer/setup?step=4');
            } else {
                $this->_step_uncomplete('database_setting', '4');
                $this->session->set_flashdata('error', 'Database connection failed please try again.');
                redirect('System_Installer/setup?step=3');
            }
        }else
        {
            $this->_step_uncomplete('database_setting', '4');
            $this->session->set_flashdata('error', 'First verify yourself.');
            redirect('System_Installer/setup?step=2');
        }
    }
    
    public function verify()
    {
        
        $this->_keep_step_data($_POST,2);
        if(!sytem_permission($_POST)){
            $this->session->set_flashdata('error', 'Hosting Ip and Domain don\'t match with this server!');
            redirect('System_Installer/setup?step=2');
        }
        
        $v = $this->_validate_me();
        $v = json_decode($v, true);
        
        if($v == null) 
        {
            $this->session->set_flashdata('error', 'Your purchase code is Invalid for this hosting. Please try again');
            redirect('System_Installer/setup?step=2');
        }else
        {
            if(isset($v['user']) && $v['user'] != $this->_sv($this->input->post('check_username'))
            || isset($v['server']) && $v['server'] !== $_SERVER['SERVER_ADDR']
            || isset($v['domain']) && $v['domain'] !== $_SERVER['HTTP_HOST']
            || !isset($v['server']) || !isset($v['domain']))
            {
               $this->session->set_flashdata('error', 'Please check your username or purchase key!');
               redirect('System_Installer/setup?step=2'); 
            }
        }
        $this->session->set_userdata("purchase_code",$this->input->post('check_purchase_key'));
        $this->_step_complete('verify', '3');
        redirect('System_Installer/setup?step=3');
    }
    
    public function complete()
    {
        $this->_keep_step_data($_POST,3);
        if($this->_step_status('database_setting')=='complete' 
        && $this->_step_status('next_step')==4)
        {
            $is = $this->_enable_system_access();
            if($is) {
                $this->_create_admin_account();
        
                $this->_change_routing();
        
                $this->_change_htaccess();
            }
            $this->session->sess_destroy();
            redirect('System_Installer/completed'); 
        }else
        {
            $this->session->set_flashdata('error', 'Please set your database first!');
            redirect('System_Installer/setup?step=3'); 
        }
    }
    
    public function completed()
    {
        $this->load->view("installed.php");
    }
    
    public function _create_db_config()
    {
        $dbdata = read_file('./application/config/database.php');
        $dbdata = str_replace('db_name', $this->_sv($this->input->post('set_database')), $dbdata);
        $dbdata = str_replace('db_user', $this->_sv($this->input->post('set_db_user')), $dbdata);
        $dbdata = str_replace('db_pass', $this->_sv($this->input->post('set_db_pass')), $dbdata);
        $dbdata = str_replace('db_host', $this->_sv($this->input->post('set_hostname')), $dbdata);
        write_file('./application/config/database.php', $dbdata);
    }
    
    public function verify_db_connection()
    {
        $link = @mysqli_connect(
            $this->_sv($this->input->post('set_hostname')),
            $this->_sv($this->input->post('set_db_user')),
            $this->_sv($this->input->post('set_db_pass')),
            $this->_sv($this->input->post('set_database'))
        );
    
        if (!$link) {
            @mysqli_close($link);

            return false;
        }

        @mysqli_close($link);

        return true;
    }
    
    public function _step_complete($setting, $next_step)
    {
        $formdata = array(
            $setting => 'complete',
            'next_step' => $next_step,
        );

        return $this->session->set_userdata($formdata);
    }
    
    public function _step_uncomplete($setting, $next_step)
    {
        $formdata = array(
            $setting => 'uncomplete',
            'next_step' => $next_step-1,
        );

        return $this->session->set_userdata($formdata);
    }
    
    public function _step_status($key)
    {
        if(!empty($key))
        {
            return $this->session->userdata($key);
        }
    }
    
    public function _keep_step_data($data, $step)
    {
        if(!empty($data) && !empty($step))
        {
            $this->session->set_userdata("step".$step."_data", $data);
        }
    }
    
    public function _sv($v)
    {
        $v = htmlspecialchars($v);
        $v = filter_var($v, FILTER_SANITIZE_STRING);
        return $v;
    }
    
    public function _validate_me()
    {
        $purchase_code = $this->input->post('check_purchase_key');
        
        return file_get_contents(VERIFY_URL.'verify?code='.$purchase_code);
        
    }
    
    public function _prepare_db($version = null)
    {
        $this->load->database();
        $file = 'hosting_setup'.config_item('version').'.sql';
        
        if(!file_exists('./resource/tmp/'.$file)){
            return false;
        }
        
        $templine = '';
        
        $lines = file('./resource/tmp/'.$file);
        foreach ($lines as $line) {
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }
            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';') {
                $this->db->query($templine) or print 'Error performing query \'<strong>'.$templine.'\': '.mysql_error().'<br /><br />';
                $templine = '';
            }
        }

        return true;
    }
    
    public function _enable_system_access()
    {
        $confdata = read_file('./application/config/config.php');
        $confdata = str_replace(
            '$config[\'enable_hooks\'] = FALSE;',
            '$config[\'enable_hooks\'] = TRUE;',
            $confdata);
        $confdata = str_replace(
            '$config[\'index_page\'] = \'index.php\';',
            '$config[\'index_page\'] = \'\';',
            $confdata);

        write_file('./application/config/config.php', $confdata);
        
        $libdata = read_file('./application/config/autoload.php');
        $libdata = str_replace(
            '$autoload[\'libraries\'] = array(\'session\');',
            '$autoload[\'libraries\'] = array(\'session\',\'database\',\'user_agent\');',
            $libdata);
        write_file('./application/config/autoload.php', $libdata);
        
        return true;
    }
    
    public function _create_admin_account()
    {
        $this->load->database();
        // Prepare system settings
        $username = $this->_sv($this->input->post('set_admin_username'));
        $email = $this->_sv($this->input->post('set_admin_email'));
        $password = $this->_sv($this->input->post('set_admin_pass'));
        $fullname = $this->_sv($this->input->post('set_admin_fullname'));
        $company = $this->_sv($this->input->post('set_company_name'));
        $company_email = $this->_sv($this->input->post('set_company_email'));
        $email_activation = false;
        $base_url = $this->_sv($this->input->post('set_base_url'));
        $purchase_code = $this->session->userdata('purchase_code');

        $codata = array('value' => $company);
        $this->db->where('config_key', 'company_name')->update('config', $codata);

        $codata = array('value' => $company);
        $this->db->where('config_key', 'company_legal_name')->update('config', $codata);
        
        $codata = array('value' => $username);
        $this->db->where('config_key', 'admin_username')->update('config', $codata);
        
        $codata = array('value' => md5($password));
        $this->db->where('config_key', 'admin_password')->update('config', $codata);
        
        $codata = array('value' => encrypt_me($password));
        $this->db->where('config_key', 'admin_raw_password')->update('config', $codata);
    
        $codata = array('value' => $company.' Sales');
        $this->db->where('config_key', 'billing_email_name')->update('config', $codata);

        $codata = array('value' => $company.' Support');
        $this->db->where('config_key', 'support_email_name')->update('config', $codata);

        $codata = array('value' => $company);
        $this->db->where('config_key', 'website_name')->update('config', $codata);

        $codata = array('value' => $fullname);
        $this->db->where('config_key', 'contact_person')->update('config', $codata);

        $codata = array('value' => encrypt_me($purchase_code.$_SERVER['HTTP_HOST'].$_SERVER['SERVER_ADDR']));
        $this->db->where('config_key', 'purchase_code')->update('config', $codata);

        $codata = array('value' => $company_email);
        $this->db->where('config_key', 'smtp_user')->update('config', $codata);

        $codata = array('value' => $company_email);
        $this->db->where('config_key', 'support_email')->update('config', $codata);

        $codata = array('value' => 'TRUE');
        $this->db->where('config_key', 'valid_license')->update('config', $codata);

        $codata = array('value' => $company_email);
        $this->db->where('config_key', 'company_email')->update('config', $codata);

        $codata = array('value' => $base_url);
        $this->db->where('config_key', 'company_domain')->update('config', $codata);

        return true;
    }
    
    public function _change_routing()
    {
        $rdata = read_file('./application/config/routes.php');
        $rdata = str_replace('System_Installer', 'home', $rdata);
        write_file('./application/config/routes.php', $rdata);

        $data = 'Installed'."|".encrypt_me($this->session->userdata('purchase_code').$_SERVER['HTTP_HOST'].$_SERVER['SERVER_ADDR'])."|".date('Y-m-d H:i:s')."|".base64_encode($_SERVER['HTTP_HOST'].$_SERVER['SERVER_ADDR']);
        if (write_file('./application/config/installed.txt', $data)) {
            return true;
        }
    }
    
    public function _change_htaccess()
    {
        $subfolder = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        if (!empty($subfolder)) {
            $input = '
            <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteBase '.$subfolder.'
            RewriteCond %{REQUEST_URI} ^system.*
            RewriteRule ^(.*)$ /index.php?/$1 [L]
            
            RewriteCond %{REQUEST_URI} ^application.*
            RewriteRule ^(.*)$ /index.php?/$1 [L]
            
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^(.*)$ index.php?/$1 [L]
            </IfModule>
            
            <IfModule !mod_rewrite.c>
            ErrorDocument 404 /index.php
            </IfModule>
            
            ';

            $current = @file_put_contents('./.htaccess', $input);
        }
    }
    
    public function _is_install()
    {
        if (is_file('./application/config/installed.txt')) {
            return true;
        }
        return false;
    }
    
}

?>