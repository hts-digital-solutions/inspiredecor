<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
/*---------------------------------------*/
$route['lead'] = 'home/lead';
$route['add-lead'] = 'home/add_lead';
$route['import-lead'] = 'home/import_lead';
$route['followup'] = 'home/followup';
$route['setting'] = 'home/setting';
$route['logout'] = 'home/logout';
$route['clients'] = 'home/clients';
$route['vendors'] = 'home/vendors';
$route['projects'] = 'home/projects';
$route['petty-cash'] = 'home/petty_cash';
$route['expenses'] = 'home/expenses';
$route['verify-tool'] = 'home/verify_aaujar';
$route['add-petty-cash'] = 'home/add_petty_cash';
$route['add-auzaar'] = 'home/add_aaujar';
$route['add-expense'] = 'home/add_expense';
$route['import-expense'] = 'home/importExpense';
$route['auzaar'] = 'home/aaujar';
$route['print-work-status'] = 'home/print_work_status';
$route['lead-tomorrow-action-plan'] = 'home/print_work_status_lead';
$route['add-payment'] = 'home/add_payment';
$route['client-payments'] = 'home/client_payments';
$route['add-client'] = 'home/add_client';
$route['add-vendor'] = 'home/add_vendor';
$route['add-project'] = 'home/add_project';
$route['add-work-status'] = 'home/add_work_status';
$route['add-burning-report'] = 'home/add_burning_report';
$route['add-site-issue-category'] = 'home/add_issue_category';
$route['site-issue-category'] = 'home/site_issue_category';
$route['work-status'] = 'home/work_status';
$route['burning-report'] = 'home/burning_report';
$route['create-invoice'] = 'home/create_invoice';
$route['edit-invoice'] = 'home/edit_invoice';
$route['list-invoice'] = 'home/list_invoice';
$route['followup-leads'] = 'home/followup_leads';
$route['product-and-services'] = 'home/product_and_services';
$route['sms'] = 'home/sms';
$route['V2stepverification'] = 'home/V2stepverification';
$route['sent-sms'] = 'home/sent_sms';
$route['sms-credit'] = 'home/sms_credit';
$route['report'] = 'home/report';
$route['profile'] = 'home/profile';
$route['report/(:any)'] = 'report/$1';


