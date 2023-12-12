<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>
<section class="content content-header">
   <div class="row">
      <div class="col-sm-12">
         <div class="panel panel-bd">
            <div class="panel-heading">
               <div class="btn-group">Settings</div>
            </div>
            <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-12 m-b-20">
                  <div class="col-md-2 col-xs-12 col-xs-4 p-0">
                     <!-- required for floating -->
                     <!-- Nav tabs -->
                     <ul class="nav nav-tabs tabs-left border-lefttab destop-View">
                        <li class="active">
                           <a href="#general" data-toggle="tab"><i class="fa wiht fa-wrench"></i> General Setting</a>
                        </li>
                        <li>
                           <a href="#system" data-toggle="tab"><i class="fa wiht fa-assistive-listening-systems"></i> System Setting</a>
                        </li>
                        <li>
                           <a href="#cron" data-toggle="tab"><i class="fa wiht fa-wrench"></i> Cron Jobs</a>
                        </li>
                        <li>
                           <a href="#security" data-toggle="tab"><i class="fa wiht fa-mixcloud "></i> Security Setting</a>
                        </li>
                        <li>
                           <a href="#payment" data-toggle="tab"><i class="fa wiht fa-cog"></i> Payment</a>
                        </li>
                        <li>
                           <a href="#email-setting" data-toggle="tab"><i class="fa wiht fa-envelope"></i> Email Setting</a>
                        </li>
                        <li>
                           <a href="#sms-setting" data-toggle="tab"><i class="fa wiht fa-comments"></i> SMS Setting</a>
                        </li>
                        <li>
                           <a href="#invoice-setting" data-toggle="tab"><i class="fa wiht fa-credit-card-alt"></i> Invoice Setting</a>
                        </li>
                        <li>
                           <a href="#email-template" data-toggle="tab"><i class="fa wiht fa-globe"></i> Email Templates</a>
                        </li>
                        <li>
                           <a href="#department" data-toggle="tab"><i class="fa wiht fa-users"></i> Department</a>
                        </li>
                        <li>
                           <a href="#crm-filed" data-toggle="tab"><i class="fa wiht fa-code"></i> CRM Field</a>
                        </li>
                        <li>
                           <a href="#loginHis" data-toggle="tab"><i class="fa wiht fa-sign-in" aria-hidden="true"></i> Login History</a>
                        </li>
                     </ul>
                  </div>
                  <div class="col-md-10 col-xs-12 p-0">
                     <!-- Tab panels -->
                     
                     <div class="tab-content">
                        <div class="mobil-accor">
                             <a href="#general" class="visible  btn btn-labeled btn-primary" data-toggle="tab">
                                 <span class="btn-labelsetting"><i class="fa fa-wrench"></i></span>General Setting</a>
                              </div>
                        <div class="tab-pane fade in active" id="general">
                           <form action="<?=base_url()?>setting/save_setting" method="post" name="general_setting" id="general_setting">
                              <div class="col-sm-6 col-xs-12 pd-0t">
                                 <div class="cardses">
                                    <div class="row">
                                       <div class="card-headers">
                                          <div class="col-md-5 pd-top">
                                             <label>Company Name</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="company_name" class="form-control" 
                                                value="<?=get_config_item('company_name')?>"
                                                placeholder="Company Name" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Contact Person</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="contact_person" class="form-control" 
                                                value="<?=get_config_item('contact_person')?>"
                                                placeholder="Contact Person" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Email ID</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="company_email" class="form-control" 
                                                value="<?=get_config_item('company_email')?>"
                                                placeholder="Email ID" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Contact No. </label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="company_mobile" class="form-control" 
                                                value="<?=get_config_item('company_mobile')?>"
                                                placeholder="Contact No" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Website Name</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="website_name" class="form-control" 
                                                value="<?=get_config_item('website_name')?>"
                                                placeholder="Website Name" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Company PAN No.</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="company_pan" class="form-control" 
                                                value="<?=get_config_item('company_pan')?>"
                                                placeholder="PAN Number" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Company CIN</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="company_cin" class="form-control" 
                                                value="<?=get_config_item('company_cin')?>"
                                                placeholder="CIN Number" required="" />
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6 col-xs-12 pd-0t">
                                 <div class="cardses">
                                    <div class="row">
                                       <div class="card-headers">
                                          <div class="col-md-5 pd-top">
                                             <label>Company Address</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <textarea type="text" name="company_address" class="form-control" 
                                                placeholder="Company Address"  rows="2" required="" /><?=get_config_item('company_address')?></textarea>
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Pincode</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="company_zip_code" class="form-control" 
                                                value="<?=get_config_item('company_zip_code')?>"
                                                placeholder="Pincode" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>City</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="company_city" class="form-control" 
                                                value="<?=get_config_item('company_city')?>"
                                                placeholder="City" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>State</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <select class="form-control" name="company_state">
                                                   <option value="">State</option>
                                                   <?php if(isset($states) && !empty($states)): ?>
                                                   <?php foreach($states as $s):?>
                                                   <option value="<?=$s->state_id?>"
                                                   <?php echo get_config_item('company_state')==$s->state_id ? 'selected' : '';?>
                                                   ><?=$s->state_name?></option>
                                                   <?php endforeach;?>
                                                   <?php endif;?>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Country</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <select class="form-control" name="company_country">
                                                   <option value="">Country</option>
                                                   <?php if(isset($countries) && !empty($countries)): ?>
                                                   <?php foreach($countries as $c):?>
                                                   <option value="<?=$c->country_id?>"
                                                   <?php echo get_config_item('company_country')==$c->country_id ? 'selected' : '';?>
                                                   ><?=$c->country_name?></option>
                                                   <?php endforeach;?>
                                                   <?php endif;?>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Company GST NO</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="company_gst" class="form-control" 
                                                value="<?=get_config_item('company_gst')?>"
                                                placeholder="Company GST NO" required="" />
                                             </div>
                                          </div>
                                           <div class="col-md-5 pd-top">
                                             
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="submit" name="submit" value="Submit" class="btn btn-success form-control" />
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                        
                         <div class="mobil-accor">
                           <a href="#system" class="visible  btn btn-labeled btn-primary" data-toggle="tab">
                                 <span class="btn-labelsetting"><i class="fa fa-assistive-listening-systems"></i></span>
                               System Setting</a></div>
                         <div class="tab-pane fade" id="system">
                            
                           <form action="<?=base_url()?>setting/save_setting" method="post" name="system_setting" id="system_setting">
                              <div class="col-sm-6 col-xs-12 pd-0t">
                                 <div class="cardses">
                                    <div class="row">
                                       <div class="card-headers">
                                          <div class="col-md-5 pd-top">
                                             <label>Username</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="username" value="<?=get_config_item('admin_username')?>"
                                                class="form-control" placeholder="Username" required="" />
                                             </div>
                                          </div>
                                          
                                          <div class="col-md-5 pd-top">
                                             <label>New Password</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="new_passwd" 
                                                class="form-control" placeholder="New Password" />
                                             </div>
                                          </div>
                                           
                                          <div class="col-md-5 pd-top">
                                             <label>Locale</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="locale" value="<?=get_config_item('locale')?>"
                                                class="form-control" placeholder="Locale" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Default Currency</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="default_currency" class="form-control" 
                                                value="<?=get_config_item('default_currency')?>"
                                                placeholder="Default Currency" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Currency Position</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                 <select name="currency_position" class="form-control">
                                                     <option value="">Select</option>
                                                     <option value="before" 
                                                     <?php echo get_config_item('currency_position') == 'before' ? 'selected' : '';?>
                                                     >Before</option>
                                                     <option value="after"
                                                     <?php echo get_config_item('currency_position') == 'after' ? 'selected' : '';?>
                                                     >After</option>
                                                 </select>
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Currency Decimals </label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="currency_decimals" class="form-control" 
                                                value="<?=get_config_item('currency_decimals')?>"
                                                placeholder="Currency Decimals" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Task Notification</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <select name="task_what" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="email"
                                                    <?php echo get_config_item('task_what')=='email' ? 'selected':''?>
                                                    >Email</option>
                                                    <option value="sms"
                                                    <?php echo get_config_item('task_what')=='sms' ? 'selected':''?>
                                                    >SMS</option>
                                                    <option value="email-sms"
                                                    <?php echo get_config_item('task_what')=='email-sms' ? 'selected':''?>
                                                    >Email and SMS</option>
                                                </select>
                                             </div>
                                          </div>
                                          
                                          <div class="col-md-5 pd-top">
                                             <label>Followup Notification</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <select name="followup_what" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="email"
                                                    <?php echo get_config_item('followup_what')=='email' ? 'selected':''?>
                                                    >Email</option>
                                                    <option value="sms"
                                                    <?php echo get_config_item('followup_what')=='sms' ? 'selected':''?>
                                                    >SMS</option>
                                                    <option value="email-sms"
                                                    <?php echo get_config_item('followup_what')=='email-sms' ? 'selected':''?>
                                                    >Email and SMS</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6 col-xs-12">
                                 <div class="cardses">
                                    <div class="row">
                                       <div class="card-headers">
                                          <div class="col-md-5 pd-top">
                                             <label>Last Password</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="password" name="last_passwd"
                                                class="form-control" placeholder="Last Password"/>
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Purchase Code</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="purchase_code" class="form-control" 
                                                value="<?=o_pkey(get_config_item('purchase_code'))?>"
                                                placeholder="Purchase Code" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Tax</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="default_tax" class="form-control" 
                                                value="<?=get_config_item('default_tax')?>"
                                                placeholder="Tax" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Date Format</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <select class="form-control" name="date_format">
                                                    <option value="">Select</option>
                                                    <option value="d-m-Y"
                                                    <?php echo get_config_item('date_format')=='d-m-Y' ? 'selected' : ''?>
                                                    >dd-mm-YYYY</option>
                                                    <option value="m-d-Y"
                                                    <?php echo get_config_item('date_format')=='m-d-Y' ? 'selected' : ''?>
                                                    >mm-dd-YYYY</option>
                                                    <option value="Y-m-d"
                                                    <?php echo get_config_item('date_format')=='Y-m-d' ? 'selected' : ''?>
                                                    >YYYY-mm-dd</option>
                                                    <option value="Y-d-m"
                                                    <?php echo get_config_item('date_format')=='Y-d-m' ? 'selected' : ''?>
                                                    >YYYY-dd-mm</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>File Maximum Size (kb)</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="file_max_size"
                                                value="<?=get_config_item('file_max_size')?>"
                                                placeholder=" File max size" required="" class="form-control"/>
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Task Notification Before</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="number" name="task_notified_minute" class="form-control" 
                                                value="<?php echo get_config_item('task_notified_minute')?>"/>
                                             </div>
                                          </div>
                                          
                                          <div class="col-md-5 pd-top">
                                             <label>Followup Notification Before</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="number" name="followup_notified_minute" class="form-control" 
                                                value="<?php echo get_config_item('followup_notified_minute')?>"/>
                                             </div>
                                          </div>
                                           <div class="col-md-5"></div>
                              <div class="col-md-7">
                                 <div class="form-group">
                                    <input type="submit" name="submit" value="Submit" class="btn btn-success form-control" />
                                 </div>
                              </div>
                                          
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                        
                        <div class="mobil-accor">
                            <a href="#cron" class="visible  btn btn-labeled btn-primary" data-toggle="tab">
                                 <span class="btn-labelsetting"><i class="fa fa-wrench"></i></span>Cron Jobs</a>
                        </div>
                        <div class="tab-pane fade" id="cron">
                            <div class="row">
                                <div class="col-md-12" style="padding:20px 40px;">
                                    <div class="form-group">
                                        <b>Invoice Automate Cron Job</b>
                                        <p><?=base_url()?>cron/invoice_automate</p>
                                        <p>Last Run : <?=get_config_item('inv_cron_run')?></p>
                                        <button id="inv_cron_run" class="btn btn-primary btn-sm">Run Manually</button>
                                    </div>
                                    </hr><br>
                                    <div class="form-group">
                                        <b>Task Notification Cron Job</b>
                                        <p><?=base_url()?>cron/notify_task</p>
                                        <p>Last Run : <?=get_config_item('task_cron_run')?></p>
                                        <button id="task_cron_run" class="btn btn-primary btn-sm">Run Manually</button>
                                    </div>
                                    </hr><br>
                                    <div class="form-group">
                                        <b>Followup Notification Cron Job</b>
                                        <p><?=base_url()?>cron/notify_followup</p>
                                        <p>Last Run : <?=get_config_item('followup_cron_run')?></p>
                                        <button id="followup_cron_run" class="btn btn-primary btn-sm">Run Manually</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                         <div class="mobil-accor">
                            <a href="#security" class="visible  btn btn-labeled btn-primary" data-toggle="tab">
                                 <span class="btn-labelsetting"><i class="fa fa-mixcloud"></i></span> Security Setting</a></div>
                        <div class="tab-pane fade" id="security">
                           
                           <form action="<?=base_url()?>setting/save_setting" method="post" name="security_setting" id="security_setting">
                              <div class="col-sm-7 col-xs-12 pd-0t">
                                 <div class="cardses">
                                    <div class="row">
                                       <div class="card-headers mt-tp">
                                          <div class="col-md-4 pd-top">
                                             <label>2 Step Verification</label>
                                          </div>
                                          <div class="col-md-1">
                                             <div class="form-group">
                                                <input type="checkbox" name="two_step_verification" <?php echo get_config_item('two_step_verification')=='yes' ? 'checked' :'';?>
                                                class="form-controlcheck" value="yes" />
                                             </div>
                                             
                                          </div>
                                          <div class="col-md-7 pd-top">
                                              <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="form-group">
                                             <button type="button" id="exportDB"
                                             class="btn btn-sm btn-primary">Export Database</button>
                                             </div>
                                             </div>
                                                 <div class="col-md-6">
                                                       <div class="form-group">
                                             <button type="button" id="sessionOut"
                                             class="btn btn-sm btn-danger">Logout All Devices</button>
                                          </div>
                                          </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-5 col-xs-12">
                                 <div class="cardses">
                                    <div class="row">
                                       <div class="card-headers mt-tp">
                                          <div class="col-md-6 pd-top">
                                             <label>Login Notification</label>
                                          </div>
                                          <div class="col-md-3">
                                             <div class="form-group">
                                                <input type="checkbox" name="login_notification" <?php echo get_config_item('login_notification')=='yes' ? 'checked' :'';?>
                                                class="form-controlcheck" value="yes" />
                                             </div>
                                          </div>
                                           <div class="col-md-3">
                                             <div class="form-group">
                                                <input type="submit" name="submit" value="Submit" class="btn btn-success" />
                                             </div>
                                          </div>
                                         
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                           <div class="col-md-12">
                               <table class="table" id="bckupTable">
                                   <thead>
                                       <tr>
                                           <th>Filename</th>
                                           <th>Action</th>
                                       </tr>
                                   </thead>
                                   <tbody id="DBbfiles">
                                       <?php if(isset($bfiles) && !empty($bfiles)):?>
                                       <?php foreach($bfiles as $f):?>
                                       <tr data-node="<?=base64_encode($f)?>">
                                           <td><?=$f?></td>
                                           <td>
                                             <a target="_blank" href="<?=base_url()?>home/download_file?file=<?=base64_encode($f)?>"
                                             class="btn btn-xs btn-success"><i class="fa fa-download"></i></a>
                                             
                                             <button type="button" class="btn btn-xs btn-success"
                                             data-d="<?=base64_encode($f)?>" onclick="importDB(this)"
                                             ><i class="fa fa-upload"></i></button>
                                             
                                             <button type="button" class="btn btn-xs btn-danger"
                                             data-d="<?=base64_encode($f)?>" onclick="removeDBbckup(this)"
                                             ><i class="fa fa-trash"></i></button>
                                           </td>
                                       </tr>
                                       <?php endforeach;?>
                                       <?php endif;?>
                                   </tbody>
                               </table>
                           </div>
                        </div>
                       
                         <div class="mobil-accor">
                           <a href="#payment" class="visible  btn btn-labeled btn-primary" data-toggle="tab">
                                 <span class="btn-labelsetting"><i class="fa fa-cog"></i></span> Payment</a></div>
                        <div class="tab-pane fade" id="payment">
                           
                           <form action="<?=base_url()?>setting/save_setting" method="post" name="payment_setting" id="payment_setting">
                             <div class="row">
                                <div class="col-md-12">
                                             <div class="address-sec">
                                                <h4 style="display:inline;">Razorpay - </h4> 
                                 &nbsp;&nbsp; <lable>Enable </lable><input type="checkbox" class="rozarpay"  name="is_razorpay" <?php echo get_config_item('is_razorpay')=='yes' ? 'checked' :'';?> value="yes"/>
                                                                       </div>
                                          </div>
                                 
                               <div class="cardses">
                                   <div class="col-sm-6 col-xs-12 ">
                                 
                                    <div class="row">
                                       <div class="card-headers">
                                          <div class="col-md-5 pd-top">
                                             <label>RAZOR_KEY_ID </label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="RAZOR_KEY_ID" value="<?php echo decrypt_me(get_config_item('RAZOR_KEY_ID'));?>"
                                                class="form-control"/>
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Success Page </label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="razorpay_surl" value="<?php echo get_config_item('razorpay_surl');?>"
                                                class="form-control"/>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                   <div class="col-sm-6 col-xs-12">
                                 
                                    <div class="row">
                                       <div class="card-headers">
                                          <div class="col-md-5 pd-top">
                                             <label>RAZOR_KEY_SECRET</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="RAZOR_KEY_SECRET"  value="<?php echo decrypt_me(get_config_item('RAZOR_KEY_SECRET'));?>"
                                                class="form-control" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Failure Page </label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="razorpay_furl" value="<?php echo get_config_item('razorpay_furl');?>"
                                                class="form-control"/>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                              </div>
                               
                               </div></div>
                                <div class="row">
                              <div class="col-md-12">
                                    <div class="address-sec">
                                  <h4 style="display:inline;">PayU Money - </h4>  &nbsp;&nbsp;
                             <lable> Enable </lable><input type="checkbox" class="rozarpay" name="is_payu" <?php echo get_config_item('is_payu')=='yes' ? 'checked' :'';?> value="yes"/>
                             </div> </div>
                                   <div class="cardses">
                                  <div class="col-sm-6 col-xs-12">
                                
                                    <div class="row">
                                       <div class="card-headers">
                                          <div class="col-md-5 pd-top">
                                             <label>KEY_ID </label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="PAYU_KEY_ID" value="<?php echo decrypt_me(get_config_item('PAYU_KEY_ID'));?>"
                                                class="form-control"/>
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Success Page </label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="payu_surl" value="<?php echo get_config_item('payu_surl');?>"
                                                class="form-control"/>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                  <div class="col-sm-6 col-xs-12">
                                 
                                    <div class="row">
                                       <div class="card-headers">
                                          <div class="col-md-5 pd-top">
                                             <label>SALT_KEY</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="PAYU_SALT_KEY"  value="<?php echo decrypt_me(get_config_item('PAYU_SALT_KEY'));?>"
                                                class="form-control" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Failure Page </label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="payu_furl" value="<?php echo get_config_item('payu_furl');?>"
                                                class="form-control"/>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 
                              </div>
                              <div>
                                       <div class="card-headers">
                                          <div class="col-md-3 pd-top">
                                             <label for="is_bank_details">Bank Details <input id="is_bank_details" <?php echo get_config_item('is_bank_details')=='yes' ? 'checked' :'';?>
                                             type="checkbox" name="is_bank_details" value="yes" /></label>
                                          </div>
                                          <div class="col-md-9">
                                             <div class="form-group">
                                                <textarea name="bank_details"  class="form-control"><?php echo get_config_item('bank_details');?></textarea>
                                             </div>
                                          </div>
                                          <div class="col-md-10"></div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <input type="submit" name="submit" value="Submit" class="btn btn-success btn-block" />
                                 </div>
                              </div>
                                       </div>
                                       
                                    </div>
                              </div>
                               </div>
                           </form>
                        </div>
                        
                         <div class="mobil-accor">
                           <a href="#email-setting" class="visible  btn btn-labeled btn-primary" data-toggle="tab">
                                 <span class="btn-labelsetting"><i class="fa fa-envelope"></i></span> Email Setting</a></div>
                        <div class="tab-pane fade" id="email-setting">
                          
                           <form action="<?=base_url()?>setting/save_setting" method="post" name="email_setting" id="email_setting">
                              <div class="col-sm-6 col-xs-12 pd-0t">
                                 <div class="cardsess-setting">
                                    <div class="row">
                                       <div class="card-headers">
                                          <div class="col-md-5 pd-top">
                                             <label>Company Email</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="support_email" class="form-control" 
                                                value="<?=get_config_item('support_email')?>"
                                                placeholder="Company Email" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>SMTP Port</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="smtp_port" class="form-control" 
                                                value="<?=get_config_item('smtp_port')?>"
                                                placeholder="SMTP Port" required="" />
                                             </div>
                                          </div>
                                          
                                          <div class="col-md-5 pd-top">
                                             <label>SMTP Host</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="smtp_host" class="form-control" 
                                                value="<?=get_config_item('smtp_host')?>"
                                                placeholder="SMTP Host" required="" />
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6 col-xs-12">
                                 <div class="cardses">
                                    <div class="row">
                                       <div class="card-headers">
                                          <div class="col-md-5 pd-top">
                                             <label>Mail Type</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                               <select name="mail_type" class="form-control">
                                                   <option value="php" <?php echo get_config_item('mail_type')=='php' ? 'selected' : ''; ?>>PHP</option>
                                                   <option value="smtp" <?php echo get_config_item('mail_type')=='smtp' ? 'selected' : ''; ?>>SMTP</option>
                                               </select>
                                             </div>
                                          </div>
                                          
                                          <div class="col-md-5 pd-top">
                                             <label>SMTP Username</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="smtp_user" class="form-control" 
                                                value="<?=get_config_item('smtp_user')?>"
                                                placeholder="SMTP Username" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>SMTP Password</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="smtp_pass" class="form-control"
                                                value="<?=get_config_item('smtp_pass')?>"
                                                placeholder="SMTP Password" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="submit" name="submit" value="Submit" class="btn btn-success form-control" />
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                           <form name="test-smtp" id="test-smtp">
                               <div class="row">
                                  <div class="col-md-8 col-xs-12">
                                    <div class="cardses">
                                    <div class="card-headers">    
                                     <div class="row">      
                                   <div class="col-md-3 pd-top">Test SMTP</div>
                                   <div class="col-md-9">
                                   <div class="form-group">
                                       <input type="email" placeholder="Email"
                                       class="form-control" name="email" id="text" />
                                   </div>
                                   </div>
                                  
                               </div>
                               </div>
                               </div>
                               </div>
                                  <div class="col-md-4 col-xs-12">
                                    <div class="cardses">
                                    <div class="card-headers">    
                                     <div class="form-group">
                                       <button type="submit" class="btn btn-primary setting form-control">Send</button>
                                     </div>
                               </div>
                               </div>
                               </div>
                               </div>
                           </form>
                        </div>
                        
                          <div class="mobil-accor">
                             <a href="#sms-setting" class="visible  btn btn-labeled btn-primary" data-toggle="tab">
                                 <span class="btn-labelsetting"><i class="fa fa-comments"></i></span> SMS Setting</a></div>
                        <div class="tab-pane fade" id="sms-setting">
                            
                           <form action="<?=base_url()?>setting/save_setting" method="post" name="sms_setting" id="sms_setting">
                              <div class="col-sm-6 col-xs-12 pd-0t">
                                 <div class="cardses">
                                    <div class="row">
                                       <div class="card-headers">
                                          <div class="col-md-5 pd-top">
                                             <label>SMS Host URL</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="sms_host" class="form-control" 
                                                value="<?=get_config_item('sms_host')?>"
                                                placeholder="SMS Host URL" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>SMS User ID</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="sms_user_id" class="form-control" 
                                                value="<?=get_config_item('sms_user_id')?>"
                                                placeholder="SMS User ID" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>SMS API Key</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="sms_api_key" class="form-control" 
                                                value="<?=get_config_item('sms_api_key')?>"
                                                placeholder="SMS API Key" required="" />
                                             </div>
                                          </div>
                                         
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6 col-xs-12">
                                 <div class="cardses">
                                    <div class="row">
                                       <div class="card-headers">
                                            <div class="col-md-5 pd-top">
                                             <label>SMS Balance</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group" style="font-size:3rem;">
                                                  <?php $sms = json_decode($sms_balance);?>
                                                  <?php echo
                                                  !isset($sms->error) ? $sms->data->sms_credit : '';
                                                  ?>
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>SMS Username</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="sms_user" class="form-control" 
                                                value="<?=get_config_item('sms_user')?>"
                                                placeholder="SMS Username" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>SMS Password</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="sms_pass" class="form-control"
                                                value="<?=get_config_item('sms_pass')?>"
                                                placeholder="SMS Password" required="" />
                                             </div>
                                          </div>
                                           <div class="col-md-5 pd-top"></div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="submit" name="submit" value="Submit" class="btn btn-success form-control" />
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                        
                         <div class="mobil-accor">
                             <a href="#invoice-setting" class="visible  btn btn-labeled btn-primary" data-toggle="tab">
                                 <span class="btn-labelsetting"><i class="fa fa-credit-card-alt"></i></span> Invoice Setting</a></div>
                        <div class="tab-pane fade" id="invoice-setting">
                            
                           <form action="<?=base_url()?>setting/save_setting" method="post" name="invoice_setting" id="invoice_setting" enctype="multipart/form-data">
                              <div class="col-sm-6 col-xs-12 pd-0t">
                                 <div class="cardses">
                                    <div class="row">
                                       <div class="card-headers">
                                          
                                          <div class="col-md-5 pd-top">
                                             <label>Invoice Prefix</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="invoice_prefix" value="<?=get_config_item('invoice_prefix')?>"
                                                class="form-control" placeholder="Invoice Prefix" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Invoice due before</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" class="form-control" name="invoices_due_before"
                                                placeholder="4 days" value="<?=get_config_item('invoices_due_before')?>" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Invoices Due After</label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="invoices_due_after" value="<?=get_config_item('invoices_due_after')?>"
                                                class="form-control" placeholder="5 days" required="" />
                                             </div>
                                          </div>
                                          <div class="col-md-5 pd-top">
                                             <label>Invoice Starting Number </label>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="form-group">
                                                <input type="text" name="invoice_start_no" value="<?=get_config_item('invoice_start_no')?>"
                                                class="form-control" placeholder="1001" required="" />
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6 col-xs-12">
                                 <div class="cardses">
                                    <div class="row">
                                       <div class="card-headers">
                                          <div class="image-input image-input-outline">
                                             <div class="image-input-wrapper">
                                                 <img src="<?php echo !empty(get_config_item('invoice_logo')) ? 
                                                 base_url('resource/system_uploads/inv_logo/'.get_config_item('invoice_logo')) : '';?>" 
                                                 alt="invlogo" style="height:120px;width:100px;object-fit:contain;" id="invlogo"/>
                                             </div>
                                             <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change Logo">
                                                 <i class="fa fa-edit icon-sm text-muted"></i>
                                                 <input type="file" name="invoice_logo" id="invoice_logo" accept=".png, .jpg, .jpeg" />
                                                 <input type="hidden" name="prev_logo" value="<?=get_config_item('invoice_logo')?>" />
                                                 <input type="hidden" name="is_remove" id="is_remove" value="false" />
                                             </label>
                                             
                                             <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" id="remove_logo" data-action="remove" data-toggle="tooltip" title="" data-original-title="Remove Logo">
                                                <i class="fa fa-trash icon-xs text-muted"></i>
                                             </span>
                                          </div>
                                          <span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span><br/>
                                          <span class="text-danger" id="logoError"></span>
                                           <div class="col-md-8 pd-top"> </div>
                                          <div class="col-md-4">
                                             <div class="form-group">
                                                <input type="submit" name="submit" value="Submit" class="btn btn-success form-control" />
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                        
                        <div class="mobil-accor">
                           <a href="#email-template" class="visible  btn btn-labeled btn-primary" data-toggle="tab">
                                 <span class="btn-labelsetting"><i class="fa fa-globe"></i></span> Email Templates</a></div>
                        <div class="tab-pane fade" id="email-template">
                        
                        <form action="<?=base_url()?>setting/save_setting" method="post" name="email_setting" id="email_setting">
                           <div class="col-md-12">
                              <div class="notice" style="padding-top:10px;">
                                  <p>
                                      Use variables to call dynamic data. For user details - <code>{user}</code>,
                                      For date - <code>{date}</code>, For payment method <code>{method}</code>, For
                                      invoice number <code>{invoice_no}</code>, For amount payable <code>{amount}</code>,
                                      For due date <code>{due_date}</code> and For invoice items call <code>{products}</code>
                                  </p>
                              </div>
                              <div class="panel-group" id="accordion">
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <h4 class="panel-title">
                                          <a href="#invoice" data-toggle="collapse" data-parent="#accordion">Invoice Email</a>
                                       </h4>
                                    </div>
                                    <div class="panel-colapse collapse" id="invoice">
                                       <div class="row">
                                          <div class="col-sm-3 col-md-2 col-form-label text-right">
                                             <div class="form-group">
                                                <label>Subject :</label>
                                             </div>
                                          </div>
                                          <div class="col-sm-9 col-md-10">
                                             <div class="form-group">
                                                <input class="form-control" value="<?=get_config_item('invoice_email_subject')?>"
                                                type="text" name="invoice_email_subject" />
                                             </div>
                                          </div>
                                       </div>
                                       <div class="panel-body">
                                          <textarea id="summernote1" name="invoice_email_content"><?=get_config_item('invoice_email_content')?></textarea>
                                       
                                       <div class="btn-group pull-right">
                                          <button type="submit" class="btn btn-success">Submit</button>
                                       </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel-group" id="accordion2">
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <h4 class="panel-title">
                                          <a href="#overdue" data-toggle="collapse" data-parent="#accordion2">Overdue Email</a>
                                       </h4>
                                    </div>
                                    <div class="panel-colapse collapse" id="overdue">
                                       <div class="row">
                                          <div class="col-sm-3 col-md-2 col-form-label text-right">
                                             <div class="form-group">
                                                <label>Subject :</label>
                                             </div>
                                          </div>
                                          <div class="col-sm-9 col-md-10">
                                             <div class="form-group">
                                                <input class="form-control" value="<?=get_config_item('overdue_email_subject')?>"
                                                type="text" name="overdue_email_subject" />
                                             </div>
                                          </div>
                                       </div>
                                       <div class="panel-body">
                                          <textarea id="summernote2" name="overdue_email_content"><?=get_config_item('overdue_email_content')?></textarea>
                                       
                                       <div class="btn-group pull-right">
                                          <button type="submit" class="btn btn-success">Submit</button>
                                       </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel-group" id="accordion3">
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <h4 class="panel-title">
                                          <a href="#email-signature" data-toggle="collapse" data-parent="#accordion3">Email Signature</a>
                                       </h4>
                                    </div>
                                    <div class="panel-colapse collapse" id="email-signature">
                                       <div class="panel-body">
                                          <div class="col-md-12">
                                             <textarea id="signature"  name="email_signature"><?=get_config_item('email_signature')?></textarea>
                                          </div>
                                          <div class="col-md-12">
                                             <div class="btn-group pull-right">
                                                <button type="submit" class="btn btn-success form-control">Submit</button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel-group" id="accordion4">
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <h4 class="panel-title">
                                          <a href="#invoice-conformation" data-toggle="collapse" data-parent="#accordion4">Invoice conformation</a>
                                       </h4>
                                    </div>
                                    <div class="panel-colapse collapse" id="invoice-conformation">
                                       <div class="form-group row">
                                          <div class="col-sm-3 col-md-2 col-form-label text-right"> <label>Subject :</label></div>
                                          <div class="col-sm-9 col-md-10">
                                             <input class="form-control" type="text" name="invoice_confirmation_subject"
                                             value="<?=get_config_item('invoice_confirmation_subject')?>" />
                                          </div>
                                       </div>
                                       <div class="panel-body">
                                          <textarea id="summernote3" name="invoice_confirmation_content"
                                          ><?=get_config_item('invoice_confirmation_content')?></textarea>
                                       
                                       <div class="btn-group pull-right">
                                          <button type="submit" class="btn btn-success">Submit</button>
                                       </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="notice" style="padding-top:10px;">
                                  <p>
                                      Use variables to call dynamic data. For user details - <code>{user}</code>,
                                      For date - <code>{date}</code>, For email <code>{email}</code>, For
                                      mobile <code>{mobile}</code>
                                  </p>
                              </div>
                              <!--email templates-->
                              <div class="row">
                                  <div class="col-md-12">
                                      <div id="emailtemplates"  class="form-group">
                                            <?php if(isset($etemplates) && !empty($etemplates)): ?>
                                            <?php foreach($etemplates as $e):?>
                                            <div class="panel-group etemps" id="accordionid<?=$e->email_template_id?>">
                                             <div class="panel panel-default">
                                                <div class="panel-heading">
                                                   <h4 class="panel-title">
                                                      <a href="#id<?=$e->email_template_id?>" data-toggle="collapse" data-parent="#accordionid<?=$e->email_template_id?>"><?=$e->subject?></a>
                                                   </h4>
                                                </div>
                                                <input type="hidden" name="etempid[]" value="<?=$e->email_template_id?>" />
                                                <div class="panel-colapse collapse" id="id<?=$e->email_template_id?>">
                                                   <div class="form-group row">
                                                      <div class="col-sm-3 col-md-2 col-form-label text-right"> <label>Subject :</label></div>
                                                      <div class="col-sm-9 col-md-10">
                                                         <input class="form-control" type="text" name="subject[]"
                                                         value="<?=$e->subject?>" />
                                                      </div>
                                                   </div>
                                                   <div class="panel-body">
                                                      <textarea class="summernotebox" name="content[]"
                                                      ><?=$e->content?></textarea>
                                                   <div class="btn-group">
                                                      <button type="submit" class="btn btn-success">Submit</button>
                                                   </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                            <?php endforeach;?>
                                            <?php endif;?>
                                      </div>
                                      <div class="col-md-9"></div>
                                      <div class="col-md-3">
                                      <div class="form-group">
                                          <button type="button" class="btn btn-sm btn-primary form-control" id="addnewetemp" style="float:right;">Add New</button>
                                      </div></div>
                                  </div>
                              </div>
                           </div>
                        </form>
                        </div>
                        
                        <div class="mobil-accor">
                            <a href="#department" class="visible  btn btn-labeled btn-primary" data-toggle="tab">
                                 <span class="btn-labelsetting"><i class="fa fa-users"></i></span>Department</a></div>
                        <div class="tab-pane fade" id="department">
                           
                           <form name="agentForm" id="agentForm" style="position:relative;z-index:999!important;">
                              <div class="col-sm-12 col-xs-12 pd-0t">
                                 <div class="service-con">
                                    <div class="cardses">
                                       <div class="row">
                                          <div class="card-headers">
                                             <div class="col-md-3">
                                                <div class="form-group">
                                                   <input type="hidden" name="aid" id="aid" />
                                                   <input type="text" class="form-control" name="aname"
                                                   placeholder="User Name" required="" id="aname" />
                                                </div>
                                             </div>
                                             <div class="col-md-3">
                                                <div class="form-group">
                                                   <input type="email" class="form-control" name="aemail"
                                                   placeholder="Email" required="" id="aemail" />
                                                </div>
                                             </div>
                                             <div class="col-md-3">
                                                <div class="form-group">
                                                   <input type="text" maxlength=10 class="form-control" name="amobile"
                                                   placeholder="Mobile" required="" id="amobile" />
                                                </div>
                                             </div>
                                             <div class="col-md-3">
                                                <div class="form-group">
                                                   <input type="password" class="form-control" name="apassword"
                                                   placeholder="Password" id="apassword"/>
                                                </div>
                                             </div>
                                             <div class="col-md-3" style="display:none;">
                                                <div class="form-group">
                                                   <select class="form-control" name="aroll" id="aroll">
                                                      <option value="">Roll</option>
                                                      <option value="sales">Sales</option>
                                                      <option value="support">Support</option>
                                                   </select>
                                                </div>
                                             </div>
                                             <input type="hidden" name="aroll" id="aroll" value="sales" hidden />
                                             <div class="col-md-3">
                                                <div class="form-group">
                                                   <select class="form-control" name="astatus" id="astatus">
                                                      <option value="">Status</option>
                                                      <option value="1">Enable</option>
                                                      <option value="0">Disable</option>
                                                   </select>
                                                </div>
                                             </div>
                                             <div class="col-md-3">
                                                <div class="form-group">
                                                   <select class="form-control" name="afeature" id="afeature">
                                                      <option value="">Feature Action</option>
                                                      <option value="yes">Client Access</option>
                                                   </select>
                                                </div>
                                             </div>
                                             <div class="col-md-2">
                                                <div class="form-group"> 
                                                    <button class="btn btn-primary form-control" type="post" id="aaction">Add</button>
                                                    <button type="button" class="btn btn-danger" id="acancel" style="display:none;">Cancel</button>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                            <div class="col-md-12">
                               <div class="table-responsive">
                               <table class="table" id="agentTable">
                                   <thead>
                                       <tr>
                                           <th>#</th>
                                           <th>User Name</th>
                                           <th>Email</th>
                                           <th>Mobile</th>
                                           <th>Roll</th>
                                           <th>Feature Action</th>
                                           <th>Status</th>
                                           <th>Action</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                   <?php if(isset($agent) && !empty($agent)):?>
                                   <?php $i=1; foreach($agent as $a):?>
                                   <tr>
                                       <td><?=$i?></td>
                                       <td><?=$a->agent_name?></td>
                                       <td><?=$a->agent_email?></td>
                                       <td><?=$a->agent_mobile?></td>
                                       <td><?=ucfirst($a->agent_roll)?></td>
                                       <td>
                                       <label for="aa<?=$a->agent_id?>" style="font-weight:400;">
                                           Client Access <input <?php echo $a->client_access==='yes' ? 'checked' : ''; ?>
                                           type="checkbox" id="aa<?=$a->agent_id?>" onclick="agentF(this)" 
                                           data-id="<?=base64_encode($a->agent_id)?>" />
                                       </label>
                                       </td>
                                       <td>
                                           <?php if($a->agent_status==1): ?>
                                           Enabled
                                           <?php else:?>
                                           Disabled
                                           <?php endif;?>
                                       </td>
                                       <td>
                                           <button type="button" onclick="editAgent(this)" 
                                           data-g="<?=base64_encode($a->agent_id)?>"
                                           class="btn btn-xs btn-primary">
                                               <i class="fa fa-pencil"></i>
                                           </button>
                                           <button type="button" g="<?=base64_encode($a->agent_id)?>" link="<?=base_url()?>agent/del_agent?d=<?=base64_encode($a->agent_id)?>"
                                           class="btn btn-xs btn-danger" 
                                           onclick="delAgent(this);">
                                               <i class="fa fa-trash-o"></i>
                                           </button>
                                       </td>
                                   </tr>
                                   <?php $i++; endforeach;?>
                                   <?php endif;?>
                                   </tbody>
                               </table>
                           </div>
                           </div>
                        </div>
                        
                        <!--agent popup-->
                        
                        <div id="agentListPopup" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Select Agent to transfer Leads</h4>
                              </div>
                              <div class="modal-body">
                                <div class="form-group">
                                    <label>Agents</label>
                                    <select id="selAgent" class="form-control">
                                        <?php if(isset($agent)&& !empty($agent)): ?>
                                        <option value="">Select</option>
                                        <?php foreach($agent as $a):?>
                                        <option value="<?=base64_encode($a->agent_id)?>"><?=$a->agent_name?></option>
                                        <?php endforeach;?>
                                        <?php endif;?>
                                    </select>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <a href="javascript:void();" onclick="delAndT_(this);" id="delFinal" class="btn btn-success">Submit</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                        
                          </div>
                        </div>
                         <div class="mobil-accor">
                           <a href="#crm-filed" class="visible  btn btn-labeled btn-primary" data-toggle="tab">
                                 <span class="btn-labelsetting"><i class="fa fa-code"></i></span>CRM Field</a></div>
                        <div class="tab-pane fade" id="crm-filed">
                           
                           <ul class="nav nav-tabs bottom-border">
                              <li class="active"><a href="#Option" data-toggle="tab" aria-expanded="false">Option</a></li>
                              <li><a href="#custome-field" data-toggle="tab" aria-expanded="false">Custom Field</a></li>
                              <li class="custome_new"><a href="javascript:;" class="" data-toggle="modal" data-target="#custome">
                                 Add New Custom</a>
                              </li>
                           </ul>
                           <div class="cards-tab">
                              <div class="tab-content">
                                 <!---------------------------------------------Option------------------------------->
                                 <div class="tab-pane fade active in" id="Option">
                                    <div class="row">
                                       <div class="col-sm-12">
                                          <div class="panel panel-bd ">
                                             <div class="panel-heading">
                                                <div class="btn-group"> Lead Source</div>
                                             </div>
                                             <div class="panel-body">
                                                <div class="col-sm-12 col-md-12 col-xs-12 ">
                                                   <div class="cards">
                                                      <div class="card-headers">
                                                        <form  method="post" name="add_lead_source" id="add_lead_source">
                                                         <div class="col-md-2 pd-top">
                                                            <button type="button" id="addleadsource" class="btn btn-sm btn-success form-control">Add New</button>
                                                         </div>
                                                         <div class="col-md-2 pd-top">
                                                            <label>Lead Source</label>
                                                         </div>
                                                         <div class="col-md-6">
                                                            <div class="form-group">
                                                               <input type="hidden" name="lsid" id="lshiddenid" value=""/>
                                                               <input type="text" name="lead_source" id="lead_source"
                                                               class="form-control" placeholder="Lead Source" />
                                                               <span id="lserror" class="text-danger"></span>
                                                               <span id="lssuccess" class="text-success"></span>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-2">
                                                            <div class="resets-button">
                                                               <input type="submit" name="submit" value="Submit" class="btn btn-success form-control">
                                                            </div>
                                                         </div>   
                                                        </form>
                                                         <div class="table-responsive">
                                                            <form name="leadsort" id="leadsort" method="post">
                                                            <input type="hidden" name="name" value="lead_source" />
                                                            <table class="table table-bordered table-hover" id="lstable">
                                                               <thead>
                                                                  <tr>
                                                                     <th>Lead Source Name</th>
                                                                     <th>Action<button style="float:right;" 
                                                                     class="btn btn-sm btn-success " type="submit">Sort</button></th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody id="lead_source_list">
                                                                  <?php if(isset($lead_source) && !empty($lead_source)):?>
                                                                  <?php foreach($lead_source as $ls):?>
                                                                  <tr data-fire="l<?=base64_encode($ls->lead_source_id)?>">
                                                                     <td><span data-take="l<?=base64_encode($ls->lead_source_id)?>"><?=$ls->lead_source_name?></span> 
                                                                     <input type="hidden" name="id[]" value="<?=base64_encode($ls->lead_source_id)?>" />
                                                                     <input type="hidden" name="index[]" value="<?=$ls->lead_source_index?>" />
                                                                     <span class="d-trans">Drag to adjust order</span></td>
                                                                     <td>
                                                                        <button type="button" onclick="editLs('<?=base64_encode($ls->lead_source_id)?>');" 
                                                                        class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button>
                                                                        <button type="button" onclick="deleteLs('<?=base64_encode($ls->lead_source_id)?>');" 
                                                                        class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                                     </td>
                                                                  </tr>
                                                                  <?php endforeach; ?>
                                                                  <?php endif;?>
                                                               </tbody>
                                                            </table>
                                                            </form>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row" style="display:none;">
                                       <div class="col-sm-12">
                                          <div class="panel panel-bd ">
                                             <div class="panel-heading ">
                                                <div class="btn-group"> Service</div>
                                             </div>
                                             <div class="panel-body">
                                                <div class="col-sm-12 col-md-12 col-xs-12 ">
                                                   <div class="cards">
                                                      <div class="card-headers">
                                                          
                                                        <form method="post" name="add_service" id="add_service">
                                                          <div class="col-md-2 pd-top">
                                                <button type="button" id="addservice" class="btn btn-sm btn-success">Add New</button>
                                             </div>
                                                         <div class="col-md-2 pd-top">
                                                            <label>Add Services</label>
                                                         </div>
                                                         <div class="col-md-6">
                                                            <div class="form-group">
                                                               <input type="hidden" name="sid" id="shiddenid" value="" />
                                                               <input type="text" name="service_name" id="service_name"
                                                               class="form-control" placeholder="Add Services">
                                                               <span id="serror" class="text-danger"></span>
                                                               <span id="ssuccess" class="text-success"></span>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-2">
                                                            <div class="resets-button">
                                                               <input type="submit" name="submit" value="Submit" class="btn btn-success">
                                                            </div>
                                                         </div>
                                                         
                                                        </form>  
                                                         <div class="table-responsive">
                                                            <form name="servicesort" id="servicesort" method="post">
                                                            <input type="hidden" name="name" value="service" />
                                                            <table class="table table-bordered table-hover" id="stable">
                                                               <thead>
                                                                  <tr>
                                                                     <th>Service Name</th>
                                                                     <th>Action <button style="float:right;" 
                                                                     class="btn btn-sm btn-success" type="submit">Sort</button></th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody id="service_list">
                                                                  <?php if(isset($service) && !empty($service)):?>
                                                                  <?php foreach($service as $s):?>
                                                                  <tr data-fire="s<?=base64_encode($s->service_id)?>">
                                                                     <td><span data-take="s<?=base64_encode($s->service_id)?>"><?=$s->service_name?></span>
                                                                     <input type="hidden" name="id[]" value="<?=base64_encode($s->service_id)?>" />
                                                                     <input type="hidden" name="index[]" value="<?=$s->service_index?>" />
                                                                     <span class="d-trans">Drag to adjust order</span></td>
                                                                     <td>
                                                                        <button type="button" onclick="editS('<?=base64_encode($s->service_id)?>');" 
                                                                        class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button>
                                                                        <button type="button" onclick="deleteS('<?=base64_encode($s->service_id)?>');" 
                                                                        class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                                     </td>
                                                                  </tr>
                                                                  <?php endforeach; ?>
                                                                  <?php endif;?>
                                                               </tbody>
                                                            </table>
                                                           </form>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-12">
                                          <div class="panel panel-bd ">
                                             <div class="panel-heading">
                                                <div class="btn-group">Status</div>
                                             </div>
                                             <div class="panel-body">
                                                <div class="col-sm-12 col-md-12 col-xs-12 ">
                                                   <div class="cards">
                                                      <div class="card-headers">
                                                          <form method="post" name="add_status" id="add_status">
                                                          <div class="col-md-2 pd-top">
                                                <button type="button" id="addstatus" class="btn btn-sm btn-success">Add New</button>
                                             </div>
                                                         <div class="col-md-2 pd-top">
                                                            <label>Status</label>
                                                         </div>
                                                         <div class="col-md-6">
                                                            <div class="form-group">
                                                               <input type="hidden" name="stid" id="sthiddenid" value=""/>
                                                               <input type="text" name="status_name" id="status_name" class="form-control" placeholder="Status Name" />
                                                               <span id="sterror" class="text-danger"></span>
                                                               <span id="stsuccess" class="text-success"></span>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-2">
                                                            <div class="resets-button">
                                                               <input type="submit" name="submit" value="Submit" class="btn btn-success">
                                                            </div>
                                                         </div>
                                                                    
                                                      </form>
                                                         <div class="table-responsive">
                                                            <form name="statussort" id="statussort" method="post">
                                                            <input type="hidden" name="name" value="status" />
                                                            <table class="table table-bordered table-hover" id="sttable">
                                                               <thead>
                                                                  <tr>
                                                                     <th>Status Name</th>
                                                                     <th>Action <button style="float:right;" 
                                                                     class="btn btn-sm btn-success" type="submit">Sort</button></th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody id="status_list">
                                                                  <?php if(isset($status) && !empty($status)):?>
                                                                  <?php foreach($status as $s):?>
                                                                  <tr data-fire="st<?=base64_encode($s->status_id)?>">
                                                                     <td><span data-take="st<?=base64_encode($s->status_id)?>"><?=$s->status_name?></span>
                                                                     <input type="hidden" name="id[]" value="<?=base64_encode($s->status_id)?>" />
                                                                     <input type="hidden" name="index[]" value="<?=$s->status_index?>" />
                                                                     <span class="d-trans">Drag to adjust order</span>
                                                                     </td>
                                                                     <td>
                                                                        <button type="button" onclick="editSt('<?=base64_encode($s->status_id)?>');" 
                                                                        class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button>
                                                                        <?php if($s->is_deletable):?>
                                                                        <button type="button" onclick="deleteSt('<?=base64_encode($s->status_id)?>');" 
                                                                        class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                                        <?php endif;?>
                                                                     </td>
                                                                  </tr>
                                                                  <?php endforeach; ?>
                                                                  <?php endif;?>
                                                               </tbody>
                                                            </table>
                                                            </form>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-12">
                                          <div class="panel panel-bd">
                                             <div class="panel-heading">
                                                <div class="btn-group">Lost Reason</div>
                                             </div>
                                             <div class="panel-body">
                                                <div class="col-sm-12 col-md-12 col-xs-12 ">
                                                   <div class="cards">
                                                      <div class="card-headers">
                                                          <form name="add_lost_reason" id="add_lost_reason">
                                                          <div class="col-md-2 pd-top">
                                                <button type="button" id="addlostreason" class="btn btn-sm btn-success">Add New</button>
                                             </div>
                                                         <div class="col-md-2 pd-top">
                                                            <label>Lost Reason</label>
                                                         </div>
                                                         <div class="col-md-6">
                                                            <div class="form-group">
                                                               <input type="hidden" name="lrid" id="lrhiddenid" value=""/>
                                                               <input type="text" name="lost_reason_name" id="lost_reason_name" 
                                                               class="form-control" placeholder="Lost Reason text" />
                                                               <span id="lrerror" class="text-danger"></span>
                                                               <span id="lrsuccess" class="text-success"></span>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-2">
                                                            <div class="resets-button">
                                                               <input type="submit" name="submit" value="Submit" class="btn btn-success">
                                                            </div>
                                                         </div>
                                                      </form>
                                                         <div class="table-responsive">
                                                            <form name="lrsort" id="lrsort" method="post">
                                                            <input type="hidden" name="name" value="lost_reason" />
                                                            <table class="table table-bordered table-hover" id="lrtable">
                                                               <thead>
                                                                  <tr>
                                                                     <th>Lost Reason</th>
                                                                     <th>Action <button style="float:right;" 
                                                                     class="btn btn-sm btn-success" type="submit">Sort</button></th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody id="lost_reason_list">
                                                                  <?php if(isset($lost_reason) && !empty($lost_reason)):?>
                                                                  <?php foreach($lost_reason as $lr):?>
                                                                  <tr data-fire="lr<?=base64_encode($lr->lost_reason_id)?>">
                                                                     <td><span data-take="lr<?=base64_encode($lr->lost_reason_id)?>"><?=$lr->lost_reason_name?></span>
                                                                     <input type="hidden" name="id[]" value="<?=base64_encode($lr->lost_reason_id)?>" />
                                                                     <input type="hidden" name="index[]" value="<?=$lr->lost_reason_index?>" />
                                                                     <span class="d-trans">Drag to adjust order</span>
                                                                     </td>
                                                                     <td>
                                                                        <button type="button" onclick="editLr('<?=base64_encode($lr->lost_reason_id)?>');" 
                                                                        class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button>
                                                                        <button type="button" onclick="deleteLr('<?=base64_encode($lr->lost_reason_id)?>');" 
                                                                        class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                                     </td>
                                                                  </tr>
                                                                  <?php endforeach; ?>
                                                                  <?php endif;?>
                                                               </tbody>
                                                            </table>
                                                            </form>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    
                                    <div class="row">
                                       <div class="col-sm-12">
                                          <div class="panel panel-bd">
                                             <div class="panel-heading">
                                                <div class="btn-group">Expense Category</div>
                                             </div>
                                             <div class="panel-body">
                                                <div class="col-sm-12 col-md-12 col-xs-12 ">
                                                   <div class="cards">
                                                      <div class="card-headers">
                                                          <form name="add_expense_category" id="add_expense_category">
                                                          <div class="col-md-2 pd-top">
                                                <button type="button" id="addexpensecategory" class="btn btn-sm btn-success">Add New</button>
                                             </div>
                                                         <div class="col-md-2 pd-top">
                                                            <label>Expense Category</label>
                                                         </div>
                                                         <div class="col-md-6">
                                                            <div class="form-group">
                                                               <input type="hidden" name="ecid" id="echiddenid" value=""/>
                                                               <input type="text" name="expense_category_name" id="expense_category_name" 
                                                               class="form-control" placeholder="Expense Category Name" />
                                                               <span id="ecerror" class="text-danger"></span>
                                                               <span id="ecsuccess" class="text-success"></span>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-2">
                                                            <div class="resets-button">
                                                               <input type="submit" name="submit" value="Submit" class="btn btn-success">
                                                            </div>
                                                         </div>
                                                      </form>
                                                         <div class="table-responsive">
                                                            <form name="ecsort" id="ecsort" method="post">
                                                            <input type="hidden" name="name" value="expense_category" />
                                                            <table class="table table-bordered table-hover" id="ectable">
                                                               <thead>
                                                                  <tr>
                                                                     <th>Expense Category</th>
                                                                     <th>Action 
                                                                     <!--<button style="float:right;" -->
                                                                     <!--class="btn btn-sm btn-success" type="submit">Sort</button>-->
                                                                     </th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody id="expense_category_list">
                                                                  <?php if(isset($expense_category) && !empty($expense_category)):?>
                                                                  <?php foreach($expense_category as $ec):?>
                                                                  <tr data-fire="ec<?=base64_encode($ec->id)?>">
                                                                     <td><span data-take="ec<?=base64_encode($ec->id)?>"><?=$ec->name?></span>
                                                                     <input type="hidden" name="id[]" value="<?=base64_encode($ec->id)?>" />
                                                                     <!--<input type="hidden" name="index[]" value="<?=$ec->lost_reason_index?>" />-->
                                                                     <!--<span class="d-trans">Drag to adjust order</span>-->
                                                                     </td>
                                                                     <td>
                                                                        <button type="button" onclick="editEc('<?=base64_encode($ec->id)?>');" 
                                                                        class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button>
                                                                        <button type="button" onclick="deleteEc('<?=base64_encode($ec->id)?>');" 
                                                                        class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                                     </td>
                                                                  </tr>
                                                                  <?php endforeach; ?>
                                                                  <?php endif;?>
                                                               </tbody>
                                                            </table>
                                                            </form>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    
                                    <div class="row">
                                       <div class="col-sm-12">
                                          <div class="panel panel-bd">
                                             <div class="panel-heading">
                                                <div class="btn-group">Task Status</div>
                                             </div>
                                             <div class="panel-body">
                                                <div class="col-sm-12 col-md-12 col-xs-12 ">
                                                   <div class="cards">
                                                      <div class="card-headers">
                                                          <form name="add_task_status" id="add_task_status">
                                                          <div class="col-md-2 pd-top">
                                                <button type="button" id="addtaskstatus" class="btn btn-sm btn-success">Add New</button>
                                             </div>
                                                         <div class="col-md-2 pd-top">
                                                            <label>Task Status</label>
                                                         </div>
                                                         <div class="col-md-6">
                                                            <div class="form-group">
                                                               <input type="hidden" name="tsid" id="tshiddenid" value=""/>
                                                               <input type="text" name="task_status_name" id="task_status_name" 
                                                               class="form-control" placeholder="Status Name" />
                                                               <span id="tserror" class="text-danger"></span>
                                                               <span id="tssuccess" class="text-success"></span>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-2">
                                                            <div class="resets-button">
                                                               <input type="submit" name="submit" value="Submit" class="btn btn-success">
                                                            </div>
                                                         </div>
                                                      </form>
                                                         <div class="table-responsive">
                                                            <form name="tssort" id="tssort" method="post">
                                                            <input type="hidden" name="name" value="task_status" />
                                                            <table class="table table-bordered table-hover" id="tstable">
                                                               <thead>
                                                                  <tr>
                                                                     <th>Task Status</th>
                                                                     <th>Action <button style="float:right;" 
                                                                     class="btn btn-sm btn-success" type="submit">Sort</button></th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody id="task_status_list">
                                                                  <?php if(isset($task_status) && !empty($task_status)):?>
                                                                  <?php foreach($task_status as $ts):?>
                                                                  <tr data-fire="ts<?=base64_encode($ts->task_status_id)?>">
                                                                     <td><span data-take="ts<?=base64_encode($ts->task_status_id)?>"><?=$ts->task_status_name?></span>
                                                                     <input type="hidden" name="id[]" value="<?=base64_encode($ts->task_status_id)?>" />
                                                                     <input type="hidden" name="index[]" value="<?=$ts->task_status_index?>" />
                                                                     <span class="d-trans">Drag to adjust order</span>
                                                                     </td>
                                                                     <td>
                                                                        <button type="button" onclick="editTs('<?=base64_encode($ts->task_status_id)?>');" 
                                                                        class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button>
                                                                        <button type="button" onclick="deleteTs('<?=base64_encode($ts->task_status_id)?>');" 
                                                                        class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                                     </td>
                                                                  </tr>
                                                                  <?php endforeach; ?>
                                                                  <?php endif;?>
                                                               </tbody>
                                                            </table>
                                                            </form>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!---------------------------------------------custome-field------------------------------->         
                                 <div class="tab-pane fade" id="custome-field">
                                    <div class="panel-body border-tbal">
                                       <div class="row">
                                          <div class="col-sm-12 col-xs-12">
                                              <code>To make required field mark checkbox.</code>
                                             <div class="cardses">
                                                <?php if(isset($sections) && !empty($sections)):?>
                                                <?php foreach($sections as $s):?>
                                                <form name="flsort" id="flsort<?=$s->section_id?>" class="flsort" method="post">
                                                <div class="row">
                                                   <div class="col-md-12">
                                                      <div class="address-sec"><?=$s->section_name?>
                                                      <button type="button" class="btn btn-sm btn-warning" style="float:right;"
                                                      onclick="enableDrag('dtable<?=$s->section_id?>',this)" id="d<?=$s->section_id?>">Enable Drag</button>
                                                      <button style="float:right;" 
                                                      class="btn btn-sm btn-success" type="submit">Sort</button>
                                                      </div>
                                                   </div>
                                                   <div class="card-headers">
                                                      <div class="headding_ex">
                                                         <div class="table-responsive">
                                                            <table class="table" id="dtable<?=$s->section_id?>">
                                                               <tbody id="sectionid<?=$s->section_id?>" class="flist">
                                                                  <?php $fields = get_fields($s->section_id); ?>
                                                                  <input type="hidden" name="section" value="<?=base64_encode($s->section_id)?>" />
                                                                  <?php if(!empty($fields)): ?>
                                                                  <?php foreach($fields as $f):?>
                                                                  <?php if($f->for_lead_only==0):?>
                                                                  <tr data-of="<?=base64_encode($f->feild_id)?>">
                                                                     <td><span data-take="f<?=base64_encode($f->feild_id)?>"><?=$f->feild_name?></span>
                                                                     <input type="hidden" name="id[]" value="<?=base64_encode($f->feild_id)?>" />
                                                                     <input type="hidden" name="index[]" value="<?=$f->feild_index?>" />
                                                                     <span class="d-trans">Drag to adjust order</span>
                                                                     <input type="checkbox" id="r<?=$f->feild_id?>" onclick="markRequired(this)" 
                                                                     <?php echo $f->is_required ? 'checked' : ''; ?>
                                                                     data-mean="<?=base64_encode($f->feild_id)?>" style="float:right;"/>
                                                                     <?php if($f->action_allowed == 1 ): ?>
                                                                     <td>
                                                                        <button type="button" onclick="editField('<?=base64_encode($f->feild_id)?>')" class="btn btn-info btn-xs" data-toggle="modal" data-target="#ordine"><i class="fa fa-pencil"></i></button>
                                                                        <button type="button" onclick="deleteField('<?=base64_encode($f->feild_id)?>')" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#ordine"><i class="fa fa-trash-o"></i></button>
                                                                     </td>
                                                                     <?php else: ?>
                                                                     <td></td>
                                                                     <?php endif; ?>
                                                                  </tr>
                                                                  <?php endif;?>
                                                                  <?php endforeach;?>
                                                                  <?php endif; ?>
                                                               </tbody>
                                                            </table>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                </form>
                                                <?php endforeach;?>
                                                <?php endif;?>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                         <div class="mobil-accor">
                            <a href="#loginHis" class="visible  btn btn-labeled btn-primary" data-toggle="tab">
                                 <span class="btn-labelsetting"><i class="fa fa-sign-in"></i></span>Login History</a></div>
                        <div class="tab-pane fade" id="loginHis">
                           
                           <div class="col-md-12">
                                <div class="panel-body border-tbal">
                               <div class="table-responsive">
                               <table class="table" id="loginHisTable">
                                   <thead>
                                       <tr>
                                           <th>#</th>
                                           <th>Time</th>
                                           <th>System</th>
                                           <th>Browser</th>
                                           <th>IP</th>
                                           <th>Place 
                                           <a href="<?=base_url()?>home/clearLoginHistory?e=<?=base64_encode(get_config_item('company_email'))?>" 
                                           class="btn btn-xs btn-danger" onclick="return confirm('All history will lost. Do you want to continue?');" style="float:right;">Clear History</a>
                                           </th>
                                       </tr>
                                   </thead>
                                   <tbody id="loginHistory">
                                       <?php if(isset($lhistory) && !empty($lhistory)):?>
                                       <?php $i=1; foreach($lhistory as $h):?>
                                       <tr>
                                           <td><?=$i?></td>
                                           <td><?=date("d-m-Y H:i:s", strtotime($h->login_time))?></td>
                                           <td><?=$h->platform?></td>
                                           <td><?=$h->browser_used?></td>
                                           <td><?=$h->login_ip?></td>
                                           <td><?php
                                           $p = @unserialize($h->login_place);
                                           
                                           echo $p['regionName'].", ".$p['city'].", ".$p['country'];
                                           ?></td>
                                       </tr>
                                       <?php $i++; endforeach;?>
                                       <?php endif;?>
                                   </tbody>
                               </table>
                           </div>
                           </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
              
</div>
        <div id="custome" class="modal fade" role="dialog" style="position">
        <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content ">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add Custom Field</h4>
        </div>
        <div class="modal-body">
        <div class="panel panel-bd lobidrag">
        <div class="panel-body">
        <div class="alert alert-success" id="salert" style="display:none;padding:2px 10px;"></div>
        <div class="alert alert-danger" id="ealert" style="display:none;padding:2px 10px;"></div>
        <form name="custom_field" id="custom_field" method="post">
        <div class="row">
        <div class="col-md-3 form-group  pd-top">
        New Field
        </div>
        <div class="col-md-9 form-group">
        <input type='hidden' name="feild_id" id="feild_id" />
        <input type="text" name="feild_name" id="feild_name" 
        class="form-control" placeholder="Field name" required>
        </div>
        </div>
        <div class="row">
        <div class="col-md-3 form-group pd-top">
        Select Section
        </div>
        <div class="col-md-9 form-group">
        <select class="form-control" name="section" id="section">
            <option value="">Select</option>
            <?php if(isset($sections) && !empty($sections)):?>
            <?php foreach($sections as $s):?>
                <option value="<?= $s->section_id ?>">
                    <?= $s->section_name ?>
                </option>
            <?php endforeach; ?>
            <option value="other">Other</option>
            <?php endif;?>
        </select>
        </div>
        </div>
        <div class="row" id="newsection" style="display:none;">
        <div class="col-md-3 form-group  pd-top">
        New Section
        </div>
        <div class="col-md-9 form-group">
        <input type="text" name="new_section" id="new_section" 
        class="form-control" placeholder="New Section name">
        </div>
        </div>
        <div class="row">
        <div class="col-md-3 form-group  pd-top">
        Tpye
        </div>
        <div class="col-md-9 form-group">
        <select class="form-control" name="option_type" id="option_type">
        <option value="">Select Type</option>
        <optgroup label="Choose">
        <option value="select">Select</option>
        <option value="radio">Radio</option>
        <option value="checkbox">Checkbox</option>
        </optgroup>
        <optgroup label="Input">
        <option value="text">Text</option>
        <option value="email">Email</option>
        <option value="file">File</option>
        <option value="date">Date</option>
        <option value="time">Time</option>
        <option value="datetime">Date &amp; Time</option>
        <option value="textarea">Textarea</option>
        </optgroup>
        </select>
        </div>
        </div>
        <div class="table-responsive">
        <table class="table table-bordered table-hover" id="makeSortable" style="display:none;">
        <thead>
        <tr>
        <th>Option name <a href="javascript:;" style="float:right;" id="osort">Sort</a></th>
        <th>Action</th>
        </tr>
        </thead>
        <tbody id="options">
        <tr id="fop">
            <td><input type="text" name="option_value_name[]" id="ovn1" class="form-control" placeholder="Option value name"></td>
            <td>
                <button type="button" onclick="add_more_option();" id="addmore" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
            </td>
        </tr>
        </tbody>
        </table>
        </div>
        <div class="col-md-12 form-group text-right">
        
        <div class="reset button">
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
        </div>
        </div>
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
      </div>
    </div>

</section>