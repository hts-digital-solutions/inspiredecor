<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once ("application/third_party/razorpay-php/Razorpay.php");
use Razorpay\Api\Api as RazorpayApi;
// credential

$ci = &get_instance();
$ci->load->helper('sconfig_helper');

define('RAZOR_KEY_ID', decrypt_me(get_config_item('RAZOR_KEY_ID')));
define('RAZOR_KEY_SECRET', decrypt_me(get_config_item('RAZOR_KEY_SECRET')));

?>
 