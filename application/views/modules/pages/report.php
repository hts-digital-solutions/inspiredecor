<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>
<style>
 .row .col-md-6 {
  padding: 4px !important;
 }
 .cheight {
     height:150px;
     overflow:hidden;
     margin-bottom:10px;
 }
</style>
<section class="content content-header">

    <div class="row">
        <div class="col-md-3 col-sm-6 cheight">
                             <a href="<?=base_url()?>report/income_report"> 
                             <div class="mt-icon-box-wraper  p-a30 center m-b30 box-shadow bg-colors">
                                 
                                  <div class="mt-icon-box-sm inline-icon text-primary   radius   scale-in-center bg-moving">
                                        <span class="icon-cell text-secondry"> <i class="fa fa-money fa-2x"></i></span>
                                    </div>
                                    <div class="icon-content">
                                        <h4 class="mt-tilte text-uppercase font-weight-600 ">Income Report</h4>
                                       
                                          </div>
                              </div>
                              </a> 
                                 
                            </div>
        <div class="col-md-3 col-sm-6 cheight">
                            	<a href="<?=base_url()?>report/invoice_report"><div class="mt-icon-box-wraper p-a30 center m-b30 box-shadow bg-colors2">
                                     <div class="mt-icon-box-sm inline-icon text-primary   radius   scale-in-center bg-moving">
                                        <span class="icon-cell text-secondry"> <i class="fa fa-credit-card fa-2x"></i></span>
                                    </div>
                                    <div class="icon-content">
                                        <h4 class="mt-tilte text-uppercase font-weight-600 ">Invoice</h4>
                                       
                                          </div>
                               </div> </a>
                            
                            </div>
        <div class="col-md-3 col-sm-6 cheight">
                              <a href="<?=base_url()?>report/services">
                                  	<div class="mt-icon-box-wraper p-a30 center m-b30 box-shadow bg-colors3">
                                  <div class="mt-icon-box-sm inline-icon text-primary   radius   scale-in-center bg-moving">
                                        <span class="icon-cell text-secondry"> <i class="fa fa-product-hunt fa-2x"></i></span>
                                    </div>
                                    <div class="icon-content">
                                        <h4 class="mt-tilte text-uppercase font-weight-600 ">Products/Services</h4>
                                       
                                          </div>
                                </div>
                                </a>
                            
                            </div>
        <div class="col-md-3 col-sm-6 cheight">
                               <a href="<?=base_url()?>report/client_report"> 
                                  <div class="mt-icon-box-wraper p-a30 center m-b30 box-shadow bg-colors4">
                                 <div class="mt-icon-box-sm inline-icon text-primary   radius   scale-in-center bg-moving">
                                        <span class="icon-cell text-secondry"> <i class="fa fa-user fa-2x"></i></span>
                                    </div>
                                    <div class="icon-content">
                                        <h4 class="mt-tilte text-uppercase font-weight-600 ">Clients</h4>
                                       
                                          </div>
                                </div>
                                </a>
                            
                            </div>
        <div class="col-md-3 col-sm-6 cheight">
                            	<a href="<?=base_url()?>report/custom_income_report">
                            	      <div class="mt-icon-box-wraper p-a30 center m-b30 box-shadow bg-colors4">
                                   <div class="mt-icon-box-sm inline-icon text-primary   radius   scale-in-center bg-moving">
                                        <span class="icon-cell text-secondry"> <i class="fa fa-pie-chart  fa-2x"></i></span>
                                    </div>
                                    <div class="icon-content">
                                        <h4 class="mt-tilte text-uppercase font-weight-600 ">Income Distribution</h4>
                                       
                                          </div>
                                </div>
                                </a>
                            
                            </div>
        <div class="col-md-3 col-sm-6 cheight">
                                <a href="<?=base_url()?>report/employee"> 
                                     <div class="mt-icon-box-wraper p-a30 center m-b30 box-shadow bg-colors3">
                                       <div class="mt-icon-box-sm inline-icon text-primary   radius   scale-in-center bg-moving">
                                            <span class="icon-cell text-secondry"> <i class="fa fa-user fa-2x"></i></span>
                                        </div>
                                        <div class="icon-content">
                                            <h4 class="mt-tilte text-uppercase font-weight-600 ">Employee</h4>
                                        </div>
                                    </div>
                                </a>
                            
                            </div>
        <div class="col-md-3 col-sm-6 cheight">
                                 <a href="<?=base_url()?>report/client_resource"> 
                                	<div class="mt-icon-box-wraper p-a30 center m-b30 box-shadow bg-colors2">
                                  <div class="mt-icon-box-sm inline-icon text-primary   radius   scale-in-center bg-moving">
                                        <span class="icon-cell text-secondry"> <i class="fa fa-area-chart fa-2x"></i></span>
                                    </div>
                                    <div class="icon-content">
                                        <h4 class="mt-tilte text-uppercase font-weight-600 ">Revenue resource</h4>
                                    </div>
                                </div>
                                </a>
                            </div>
        <div class="col-md-3 col-sm-6 cheight">
                                  <a href="<?=base_url()?>report/custom_client_report">
                                    	<div class="mt-icon-box-wraper p-a30 center m-b30 box-shadow bg-colors">
                                  <div class="mt-icon-box-sm inline-icon text-primary   radius   scale-in-center bg-moving">
                                        <span class="icon-cell text-secondry"> <i class="fa fa-user fa-2x"></i></span>
                                    </div>
                                    <div class="icon-content">
                                        <h4 class="mt-tilte text-uppercase font-weight-600 ">Client Report</h4>
                                       
                                          </div>
                                </div>
                                   </a>
                            </div>
        <div class="col-md-3 col-sm-6 cheight">
                                  <a href="<?=base_url()?>report/expense_report">
                                    	<div class="mt-icon-box-wraper p-a30 center m-b30 box-shadow bg-colors">
                                  <div class="mt-icon-box-sm inline-icon text-primary   radius   scale-in-center bg-moving">
                                        <span class="icon-cell text-secondry"> <i class="fa fa-area-chart fa-2x"></i></span>
                                    </div>
                                    <div class="icon-content">
                                        <h4 class="mt-tilte text-uppercase font-weight-600 ">Expense Report</h4>
                                       
                                          </div>
                                </div>
                                   </a>
                            </div>
                            
        <div class="col-md-3 col-sm-6 cheight">
                                  <a href="<?=base_url()?>report/work_status_report">
                                    	<div class="mt-icon-box-wraper p-a30 center m-b30 box-shadow bg-colors">
                                  <div class="mt-icon-box-sm inline-icon text-primary   radius   scale-in-center bg-moving">
                                        <span class="icon-cell text-secondry"> <i class="fa fa-calendar fa-2x"></i></span>
                                    </div>
                                    <div class="icon-content">
                                        <h4 class="mt-tilte text-uppercase font-weight-600 ">Work Status Report</h4>
                                       
                                          </div>
                                </div>
                                   </a>
                            </div>
                            
        <div class="col-md-3 col-sm-6 cheight">
                                  <a href="<?=base_url()?>report/financial_report">
                                    	<div class="mt-icon-box-wraper p-a30 center m-b30 box-shadow bg-colors2">
                                  <div class="mt-icon-box-sm inline-icon text-primary   radius   scale-in-center bg-moving">
                                        <span class="icon-cell text-secondry"> <i class="fa fa-area-chart fa-2x"></i></span>
                                    </div>
                                    <div class="icon-content">
                                        <h4 class="mt-tilte text-uppercase font-weight-600 ">Financial Report</h4>
                                       
                                          </div>
                                </div>
                                   </a>
                            </div>
                            
                            <div class="col-md-3 col-sm-6 cheight">
                                  <a href="<?=base_url()?>report/petty_cash">
                                    	<div class="mt-icon-box-wraper p-a30 center m-b30 box-shadow bg-colors2">
                                  <div class="mt-icon-box-sm inline-icon text-primary   radius   scale-in-center bg-moving">
                                        <span class="icon-cell text-secondry"> <i class="fa fa-area-chart fa-2x"></i></span>
                                    </div>
                                    <div class="icon-content">
                                        <h4 class="mt-tilte text-uppercase font-weight-600 ">Petty Cash Report</h4>
                                       
                                          </div>
                                </div>
                                   </a>
                            </div>
    </div>
</section>
