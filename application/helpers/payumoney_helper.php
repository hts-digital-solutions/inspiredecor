<?php
defined("BASEPATH") OR die("No direct script access allowed.");

$ci = &get_instance();
$ci->load->helper("sconfig_helper");

define('MERCHANT_KEY', decrypt_me(get_config_item('PAYU_KEY_ID')));
define('SALT', decrypt_me(get_config_item('PAYU_SALT_KEY')));

// define('PAYU_BASE_URL', "https://sandboxsecure.payu.in");		// For Sandbox Mode
define('PAYU_BASE_URL', "https://secure.payu.in");			// For Production Mode

?>