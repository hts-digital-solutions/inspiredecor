<?php
defined("BASEPATH") OR exit("No direct script access allowed.");

class Auth{
    
    public function _check_auth()
    {
        $ci = &get_instance();
        $ci->load->helper('sconfig_helper');
        
        if(isset($_SESSION['logged_in'])
        && $_SESSION['logged_in']==1
        && isset($_SESSION['roll'])
        && isset($_SESSION['login_id'])
        && !empty($_SESSION['login_id']))
        {
            $id = decrypt_me($_SESSION['login_id']);
            $_SESSION['ca'] = is_client_access($id);
            
            if(isset($_SESSION['fforl']) && !empty($_SESSION['fforl']))
            {
                if(!isset($_SESSION['lead_added']) && $ci->uri->segment(1)!='add-lead'
                && $ci->uri->segment(2)!='add_new_lead'
                && $ci->uri->segment(2)!='update_lead' && $ci->uri->segment(1)!='followup')
                {
                    $fd = $ci->Setting_Model->get_field_show_by_id($_SESSION['fforl']);
                    $name = isset($fd->feild_value_name) ? $fd->feild_value_name:'';
                    $id = $ci->Setting_Model->delete_feild($_SESSION['fforl']);
                    $ci->Setting_Model->remove_this_to_lead($name);
                    
                    unset($_SESSION['lead_added']);
                    unset($_SESSION['fforl']);
                }
                if(isset($_SESSION['lead_added'])){
                    unset($_SESSION['lead_added']);
                    unset($_SESSION['fforl']);
                }
            }
            
            // take_database_backup();
        }else{
            session_destroy();
            $ref = base64_encode($_SERVER['REQUEST_URI']);
            redirect(base_url()."?ref=".$ref);
        }
    }
    
    public function _auth_id()
    {
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
    
    public function _check_Aauth()
    {
        $ci = &get_instance();
        $ci->load->helper('sconfig_helper');
        
        $allow = get_config_item('session_active');
        
        if(isset($_SESSION['logged_in'])
        && $_SESSION['logged_in']==1
        && isset($_SESSION['roll'])
        && $_SESSION['roll']==='admin'
        && isset($_SESSION['is_admin'])
        && $_SESSION['is_admin']===true
        && isset($_SESSION['login_id'])
        && !empty($_SESSION['login_id'])
        && $allow === 'yes')
        {
            if($ci->uri->segment(1)!='lead'
            && $ci->uri->segment(1)!='clients'
            && $ci->uri->segment(1)!='project'
            && $ci->uri->segment(1)!='projectExpense'
            && $ci->uri->segment(1)!='expenses'
            && $ci->uri->segment(1)!='add-lead'
            && $ci->uri->segment(1)!='report'
            && $_SERVER['REQUEST_URI']!='/'
            && $ci->uri->segment(1)!='sms'
            && $ci->uri->segment(1)!='sms-credit'
            && $ci->uri->segment(1)!='list-invoice'
            && $ci->uri->segment(1)!='create-invoice'
            && $ci->uri->segment(1)!='add-site-issue-category'
            && $ci->uri->segment(1)!='site-issue-category'
            && $ci->uri->segment(1)!='product-and-services')
            {
                if(isset($_SESSION['setting_access']) 
                && $_SESSION['setting_access']===true)
                {
                    //
                }else{
                    redirect(base_url()."?ref=".base64_encode($_SERVER['REQUEST_URI']));
                }
            }else{
                unset($_SESSION['setting_access']);
            }
            
            if(isset($_SESSION['fforl']) && !empty($_SESSION['fforl']))
            {
                if(!isset($_SESSION['lead_added']) && $ci->uri->segment(1)!='add-lead'
                && $ci->uri->segment(2)!='add_new_lead'
                && $ci->uri->segment(2)!='update_lead' && $ci->uri->segment(1)!='followup')
                {
                    $fd = $ci->Setting_Model->get_field_show_by_id($_SESSION['fforl']);
                    $name = isset($fd->feild_value_name) ? $fd->feild_value_name:'';
                    $id = $ci->Setting_Model->delete_feild($_SESSION['fforl']);
                    $ci->Setting_Model->remove_this_to_lead($name);
                    
                }
                if(isset($_SESSION['lead_added'])){
                    unset($_SESSION['lead_added']);
                    unset($_SESSION['fforl']);
                }
            }
            
            // take_database_backup();
        }else{
            session_destroy();
            $ref = base64_encode($_SERVER['REQUEST_URI']);
            redirect(base_url()."?ref=".$ref);
        }
    }
}

?>