<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class Product extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('sconfig_helper');
        $this->load->model('Product_Model');
        $this->load->library("Auth");
        $this->Auth = new Auth();
        $this->Auth->_check_auth();
        date_default_timezone_set("Asia/Kolkata");
    }
    
    public function add_new()
    {
        $res = array("status"=>0, "data"=>"failed");
        if(!empty($_POST))
        {
            $data = array(
                "product_service_name" => sanitize($this->input->post('product_name',true)),
                "set_up_fee" => sanitize($this->input->post('setupfee',true)),
                "payment" => sanitize($this->input->post('payment',true)),
                "recurring" => sanitize($this->input->post('recurring',true)),
                "billing_cycle" => sanitize($this->input->post('billing-cycle',true)),
                "created" => date("Y-m-d")
            );
            
            if(isset($_POST['pid']) && !empty($_POST['pid']))
            {
                $data["updated"] = date("Y-m-d");
                $id = $this->Product_Model->update(sanitize($_POST['pid']), $data);
                $res['update'] = true;
                $this->session->set_flashdata("success","Record has been updated.");
            }else{
                $id = $this->Product_Model->add_new($data);
                $this->session->set_flashdata("success","Record has been updated.");
            }
            
            if($id)
            {
                $res['status'] = 1;
                $res['data'] = 'success';
            }else
            {
                $res['data'] = 'adderror';
            }
        }
        print_r(json_encode($res));
    }
 
    public function pdelete()
    {
        if(isset($_GET['me']) && !empty($_GET['me']))
        {
            $isa = $this->Product_Model->is_assigned_to_client($_GET['me']);
            
            if(!$isa){
                $is = $this->Product_Model->_delete($_GET['me']);
                $this->session->set_flashdata("success","Record has been updated.");
            }else{
                $this->session->set_flashdata("error","Product and Service can not be delete when assign to client.");
            }
            redirect(base_url('product-and-services'));
        }
    }
    
    public function getPdetails()
    {
        $res = array("status"=>0,"data"=>"failed");
        if(isset($_POST['pid']) && !empty($_POST['pid']))
        {
            $data = $this->Product_Model->getPdetails($_POST['pid']);
            if(!empty($data))
            {
                $res['data'] = "success";
                $res['e'] = $data;
                $res['sf'] = get_formatted_price($data->set_up_fee);
                $res['pm'] = get_formatted_price($data->payment);
                $res['p'] = get_formatted_price(floatval($data->set_up_fee) + floatval($data->payment));
                $res['status'] = 1;
            }else{
                $res['data'] = 'derror';
            }
        }
        print_r(json_encode($res));
    }
    
    public function getcPdetails()
    {
        $res = array("status"=>0,"data"=>"failed");
        if(isset($_POST['pid']) && !empty($_POST['pid']))
        {
            $data = $this->Product_Model->getPdetails($_POST['pid']);
            if(!empty($data))
            {
                if($data->billing_cycle=='onetime')
                {
                    $res['nd'] = date("Y-m-d");
                }
                if($data->billing_cycle=='monthly')
                {
                    $res['nd'] = date("Y-m-d", strtotime('+1 month'));
                }
                if($data->billing_cycle=='quarterly')
                {
                    $res['nd'] = date("Y-m-d", strtotime('+3 month'));
                }
                if($data->billing_cycle=='semesterly')
                {
                    $res['nd'] = date("Y-m-d", strtotime('+6 month'));
                }
                if($data->billing_cycle=='yearly')
                {
                    $res['nd'] = date("Y-m-d", strtotime('+12 month'));
                }
                $res['data'] = "success";
                $res['e'] = $data;
                $res['status'] = 1;
            }else{
                $res['data'] = 'derror';
            }
        }
        print_r(json_encode($res));
    }
    
    
    public function action()
    {
        if(isset($_GET['deleteSelected']))
        {
            $res = array("status"=>0,"data"=>"failed");
            if(isset($_POST['ids']) && !empty($_POST['ids']))
            {   
                foreach($_POST['ids'] as $id){
                    $isa = $this->Product_Model->is_assigned_to_client($id);
                    if(!$isa){
                        $is = $this->Product_Model->_delete($id);
                    }else{
                        $is = false;
                        $this->session->set_flashdata("error","Product is used! Can't delete it.");
                    }
                }
                if($is){
                    $res['status'] = 1;
                    $res['data'] = "success";
                }
            }
            print_r(json_encode($res));
        }
    }
}
?>