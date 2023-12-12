<style>.ferror{width:100%;display:block;}</style>
<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
$tabindex=1;
if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
&& $_SESSION['roll']==='admin' || $_SESSION['roll']!=='admin'
&& $_SESSION['ca']==='yes'):?>
<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
        <div class="panel-heading vendor-inform">
          <div class="btn-group inform-btn">
            <ul class="nav nav-tabs iconess">
              <?php if(false && isset($_GET['edit']) && !empty($_GET['edit'])):?>
              <li class="active"><a href="#Summary" data-toggle="tab" aria-expanded="false"><span class="tabnone">Summary</span><i class="fa fa-sun-o" aria-hidden="true"></i> </a></li>
              <?php endif; ?>
              <li class="active"><a href="#profile" data-toggle="tab" aria-expanded="false"><span class="tabnone">Profile</span> <i class="fa fa-user" aria-hidden="true"></i></a></li>
              <?php if(false && isset($_GET['edit']) && !empty($_GET['edit'])):?>
              <li class=""><a href="#product" data-toggle="tab" aria-expanded="true"><span class="tabnone">Product/Service</span> <i class="fa fa-product-hunt" aria-hidden="true"></i></a></li>
              <?php endif; ?>
              <?php if(false && isset($_GET['edit']) && !empty($_GET['edit'])):?>
              <li class=""><a href="#invoice" data-toggle="tab" aria-expanded="true"><span class="tabnone">Invoice</span> <i class="fa fa-credit-card" aria-hidden="true"></i></a></li>
              <?php endif; ?>
              <?php if(false && isset($_GET['edit']) && !empty($_GET['edit'])):?>
              <li class=""><a href="#email" data-toggle="tab" aria-expanded="true"><span class="tabnone">Email</span><i class="fa fa-envelope-o" aria-hidden="true"></i> </a></li>
              <?php endif; ?>
              <?php if(false && isset($_GET['edit']) && !empty($_GET['edit'])):?>
              <li class=""><a href="#SMS" data-toggle="tab" aria-expanded="true"><span class="tabnone">SMS</span><i class="fa fa-commenting" aria-hidden="true"></i> </a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
        <div class="panel-body add-vendor">
          <div class="cards-tab">
            <div class="tab-content">
              <!---------------------------------------------tab1------------------------------->
              <?php if(false && isset($_GET['edit']) && !empty($_GET['edit'])):?>
              <div class="tab-pane fade active in" id="Summary">
                <div class="col-sm-6 col-xs-12">
                  <div class="cardses">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="address-sec">Vendor Information</div>
                      </div>
                      <div class="card-headers">
                        <div class="headding_ex">
                         <div class="table-responsive mob-bord">  <table class="table">
                            <tbody>
                              <tr>
                                <td>Name</td>
                                <td class="type-info">
                                    <?php echo isset($vendor->vendor_name) ? $vendor->vendor_name : ''; ?>
                                </td>
                              </tr>
                              <!--<tr>-->
                              <!--  <td>Company Name</td>-->
                              <!--  <td class="type-info">-->
                              <!--      <?php echo isset($vendor->vendor_company) ? $vendor->vendor_company : ''; ?>-->
                              <!--  </td>-->
                              <!--</tr>-->
                              <tr>
                                <td>Number</td>
                                <td class="type-info">
                                    <?php echo isset($vendor->vendor_mobile) ? $vendor->vendor_mobile : ''; ?>
                                </td>
                              </tr>
                              <tr>
                                <td>Office Location</td>
                                <td class="type-info">
                                    <?php echo isset($vendor->office_location) ? $vendor->office_location : ''; ?>
                                </td>
                              </tr>
                              <tr>
                                <td>Office Address</td>
                                <td class="type-info">
                                    <?php echo isset($vendor->office_address) ? 
                                    $vendor->office_address : ''; ?>
                                </td>
                              </tr>
                              <?php if(false):?>
                              <tr>
                                <td>State</td>
                                <td class="type-info">
                                    <?php echo isset($vendor->vendor_state) ? 
                                    get_module_value($vendor->vendor_state,'state') : ''; ?>
                                </td>
                              </tr>
                              <tr>
                                <td>Pincode</td>
                                <td class="type-info">
                                <?php echo isset($vendor->vendor_pincode) ? $vendor->vendor_pincode : ''; ?>
                                </td>
                              </tr>
                              <tr>
                                <td>Country</td>
                                <td class="type-info">
                                    <?php echo isset($vendor->vendor_country) ? 
                                    get_module_value($vendor->vendor_country,'country') : ''; ?>
                                </td>
                              </tr>
                              <?php endif;?>
                            </tbody>
                          </table>
                        </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="address-sec">Other Information</div>
                      </div>
                      <div class="headding_ex">
                        <div class="card-headers">
                          <div class="table-responsive mob-bord"> <table class="table">
                            <tbody>
                              <tr>
                                <td>GST Number </td>
                                <td class="type-info">
                                    <?php echo isset($vendor->vendor_gst) ? $vendor->vendor_gst : ''; ?>
                                </td>
                              </tr>
                              <tr>
                                <td>PAN Number </td>
                                <td class="type-info">
                                    <?php echo isset($vendor->vendor_pan) ? $vendor->vendor_pan : ''; ?>
                                </td>
                              </tr>
                              <tr>
                                <td>CIN </td>
                                <td class="type-info">
                                    <?php echo isset($vendor->vendor_cin) ? $vendor->vendor_cin : ''; ?>
                                </td>
                              </tr>
                              <tr>
                                <td>Status</td>
                                <td class="type-info">
                                    <?php echo isset($vendor->vendor_status) && $vendor->vendor_status == 1
                                    ? 'Active' : 'In-active'; ?>
                                </td>
                              </tr>
                              <tr>
                                <td>Signup Date</td>
                                <td class="type-info">
                                    <?php echo isset($vendor->created) ? 
                                    get_formatted_date($vendor->created) : ''; ?>
                                </td>
                              </tr>
                              <tr>
                                <td>Duration</td>
                                <td class="type-info">
                                    <?php echo isset($vendor->created) ? dateDiffInDays($vendor->created) : '';?>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                  <div class="cardses">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="address-sec">
                          Invoice/Billing
                        </div>
                      </div>
                     <div class="headding_ex">
                      <div class="card-headers">
                        <div class="table-responsive mob-bord"> <table class="table">
                          <tbody>
                            <tr>
                              <td>Paid</td>
                              <td class="type-info">
                                  <?php echo get_vendor_paid_no(isset($vendor->vendor_id)? $vendor->vendor_id : '') ?>
                                  (<?=get_formatted_price(get_vendor_paid(isset($vendor->vendor_id)? $vendor->vendor_id : ''))?>)
                              </td>
                            </tr>
                            <tr>
                              <td>Unpaid/Due</td>
                              <td class="type-info">
                                  <?php echo get_vendor_unpaid_no(isset($vendor->vendor_id)? $vendor->vendor_id : '') ?>
                                  (<?=get_formatted_price(get_vendor_unpaid(isset($vendor->vendor_id)? $vendor->vendor_id : ''))?>)
                              </td>
                            </tr>
                            <tr>
                              <td>Income</td>
                              <td class="type-info"><?=get_formatted_price(get_vendor_paid(isset($vendor->vendor_id)? $vendor->vendor_id : ''))?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      </div>
                      </div>
                      <div class="col-md-12">
                        <div class="address-sec">
                          Product/Services
                        </div>
                     
                      <div class="service">
                        <ul>
                          <?php if(isset($vendor->vendor_id)):?>
                          <?= get_vendor_services($vendor->vendor_id)?>
                          <?php endif;?>
                        </ul>
                      </div>
                      <form method="post" name="saveAdminNote" id="saveAdminNote">
                        <div class="col-md-12">
                          <div class="form-group">
                            <input type="hidden" name="vendor_id" 
                            value="<?=$vendor->vendor_id?>" />
                            <textarea class="form-control" tabindex="<?=$tabindex+1?>" rows="3" placeholder="Admin note..." id="snoteText" name="snoteText"><?=$vendor->admin_note?></textarea>
                          </div>
                        </div>
                        <div class="col-md-12 text-right" style="margin-bottom:5px;">
                          <div class="resets-button">
                            <button type="button" onclick="openSmsM();" tabindex="<?=$tabindex+1?>" class="btn btn-warning form-sendsms">Send SMS</button>
                            <input type="submit" name="submit" value="Save" tabindex="<?=$tabindex+1?>" class="btn btn-success sms-senclent form-sendsms" />
                          </div>
                        </div>
                      </form>
                      <div id="smsModal" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                            <form name="sendSmsForm" id="sendSmsForm" method="POST">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">SMS Content</h4>
                              </div>
                              <div class="modal-body">
                                <input type="hidden" name="vendor_id" 
                            value="<?=$vendor->vendor_id?>" />
                            <input type="hidden" name="vendor_mobile" 
                            value="<?=$vendor->vendor_mobile?>" />
                                <label>Enter content</label>
                                <textarea class="form-control" id="sSmsText" name="smstext" tabindex="<?=$tabindex+1?>"></textarea>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" tabindex="<?=$tabindex+1?>">Send</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" tabindex="<?=$tabindex+1?>">Close</button>
                              </div>
                            </form>
                            </div>
                        
                          </div>
                        </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12">
                        <form action="<?=base_url()?>vendor/send_template_email?c=<?php echo isset($_GET['edit']) ? $_GET['edit'] : '';?>" 
                        method="post">
                            <div class="col-md-12 m-bt-0">
                                <div class="col-md-3 col-xs-12 pd-top">
                                    <label>Send Email</label>
                                    </div>
                                <div class="col-md-6 col-xs-12">
                                    <select name="template" class="form-control" tabindex="<?=$tabindex+1?>">
                                        <option value="">Select Templete</option>
                                        <option value="compose">Compose</option>
                                        <?php if(isset($etemplates) && !empty($etemplates)): ?>
                                        <?php foreach($etemplates as $e):?>
                                        <option value="<?=$e->email_template_id?>"><?=$e->subject?></option>
                                        <?php endforeach;?>
                                        <?php endif;?>
                                    </select>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                <div class="btn-group" style="float:right;">
                                  <button class="btn btn-primary" type="submit" tabindex="<?=$tabindex+1?>">Send Message </button>
                                </div>
                              </div>
                            </div>
                        </form>
                      </div></div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endif;?>
              <!---------------------------------------------tab2------------------------------->
              <div class="tab-pane fade <?php echo isset($_GET['edit']) ? 'active in' : 'active in';?>" id="profile">
                <form method="post" name="vendorAdd" id="vendorAdd">
                  <?php if(isset($_GET['ref']) && !empty($_GET['ref'])): ?>
                  <input type="hidden" name="ref" value="<?=$_GET['ref']?>" />
                  <?php endif;?>
                  <div class="col-sm-6 col-xs-12">
                    <div class="cardses">
                      <div class="row">
                        <div class="card-headers">
                          <div class="col-md-4 pd-top">
                            <label>Name <span class="text-danger">*</span></label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="hidden" name="vendor_id" 
                              value="<?php echo isset($vendor->vendor_id) ? 
                              $vendor->vendor_id : ''; ?>" />
                              <input type="text" class="form-control" name="full_name"
                              placeholder="Full Name" value="<?php echo isset($vendor->vendor_name) ? 
                              $vendor->vendor_name : (isset($_SESSION['dback']['vendor_name']) ? $_SESSION['dback']['vendor_name']: ''); ?>" required="" tabindex="<?=$tabindex+1?>"/>
                            </div>
                            <?php if(isset($_SESSION['rfield']['full_name'])):?>
                          <span class="text-danger ferror"><?=$_SESSION['rfield']['full_name']?></span>
                          <?php endif;?>
                          </div>
                          
                          <?php if(false):?>
                          <div class="col-md-4 pd-top">
                            <label>Company Name <span class="text-danger">*</span></label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="text" class="form-control" name="company_name"
                              placeholder="Company" value="<?php echo isset($vendor->vendor_company) ? 
                              $vendor->vendor_company : (isset($_SESSION['dback']['vendor_company']) ? 
                              $_SESSION['dback']['vendor_company']: ''); ?>" required="" tabindex="<?=$tabindex+1?>"/>
                            </div>
                            <?php if(isset($_SESSION['rfield']['company_name'])):?>
                          <span class="text-danger ferror"><?=$_SESSION['rfield']['company_name']?></span>
                          <?php endif;?>
                          </div>
                          
                          
                          <div class="col-md-4 pd-top">
                            <label>PAN No.</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="text" class="form-control" name="pan_number"
                              placeholder="PAN Number" value="<?php echo isset($vendor->vendor_pan) ? 
                              $vendor->vendor_pan : (isset($_SESSION['dback']['vendor_pan']) ? 
                              $_SESSION['dback']['vendor_pan']: ''); ?>" tabindex="<?=$tabindex+1?>"/>
                            </div>
                          </div>
                          <div class="col-md-4 pd-top">
                            <label>CIN</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="text" class="form-control" name="cin_number"
                              placeholder="CIN Number" value="<?php echo isset($vendor->vendor_cin) ? 
                              $vendor->vendor_cin : (isset($_SESSION['dback']['vendor_cin']) ? 
                              $_SESSION['dback']['vendor_cin']: ''); ?>" tabindex="<?=$tabindex+1?>"/>
                            </div>
                          </div>
                          <?php endif;?>
                          
                          <?php if(false):?>
                          <div class="col-md-4 pd-top">
                            <label>Position</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="text" class="form-control" name="position"
                              placeholder="Position" value="<?php echo isset($vendor->vendor_position) ? 
                              $vendor->vendor_position : (isset($_SESSION['dback']['vendor_position']) ? 
                              $_SESSION['dback']['vendor_position']: ''); ?>" tabindex="<?=$tabindex+1?>"/>
                            </div>
                          </div>
                          
                          
                          <div class="col-md-4 pd-top">
                            <label>Email ID <span class="text-danger">*</span></label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="email" class="form-control" name="email"
                              placeholder="Email ID" value="<?php echo isset($vendor->vendor_email) ? 
                              $vendor->vendor_email : (isset($_SESSION['dback']['vendor_email']) ? 
                              $_SESSION['dback']['vendor_email']: ''); ?>" required="" tabindex="<?=$tabindex+1?>"/>
                            </div>
                            <?php if(isset($_SESSION['rfield']['email'])):?>
                          <span class="text-danger ferror"><?=$_SESSION['rfield']['email']?></span>
                          <?php endif;?>
                          </div>
                          <?php endif;?>
                          
                          <div class="col-md-4 pd-top">
                            <label>Number <span class="text-danger">*</span></label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="text" class="form-control" name="contact"
                              placeholder="Contact No" value="<?php echo isset($vendor->vendor_mobile) ? 
                              $vendor->vendor_mobile : (isset($_SESSION['dback']['vendor_mobile']) ? 
                              $_SESSION['dback']['vendor_mobile']: ''); ?>" required="" tabindex="<?=$tabindex+1?>"/>
                            </div>
                            <?php if(isset($_SESSION['rfield']['contact'])):?>
                          <span class="text-danger ferror"><?=$_SESSION['rfield']['contact']?></span>
                          <?php endif;?>
                          </div>
                          
                          <?php if(false):?>
                          <div class="col-md-4 pd-top">
                            <label>Alternative No</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="text" class="form-control" name="altno"
                              placeholder="Alternative No" value="<?php echo isset($vendor->vendor_alt_no) ? 
                              $vendor->vendor_alt_no : (isset($_SESSION['dback']['vendor_alt_no']) ? 
                              $_SESSION['dback']['vendor_alt_no']: ''); ?>" tabindex="<?=$tabindex+1?>"/>
                            </div>
                          </div>
                          <?php endif;?>
                          
                          <?php if(false):?>
                          <div class="col-md-4 pd-top">
                            <label>Website</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="text" class="form-control" name="website"
                              placeholder="Website" value="<?php echo isset($vendor->vendor_website) ? 
                              $vendor->vendor_website : (isset($_SESSION['dback']['vendor_website']) ? 
                              $_SESSION['dback']['vendor_website']: ''); ?>" tabindex="<?=$tabindex+1?>"/>
                            </div>
                          </div>
                          <?php endif;?>
                          
                          <div class="col-md-4 pd-top">
                            <label>Quoted Rate</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="tel" class="form-control" name="quoted_rate"
                              placeholder="Quoted Rate" value="<?php echo isset($vendor->quoted_rate) ? 
                              $vendor->quoted_rate : (isset($_SESSION['dback']['quoted_rate']) ? 
                              $_SESSION['dback']['quoted_rate']: ''); ?>" tabindex="<?=$tabindex+1?>"/>
                            </div>
                          </div>
                          
                          <div class="col-md-4 pd-top">
                            <label>Final Rate</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="tel" class="form-control" name="final_rate"
                              placeholder="Final Rate" value="<?php echo isset($vendor->final_rate) ? 
                              $vendor->final_rate : (isset($_SESSION['dback']['final_rate']) ? 
                              $_SESSION['dback']['final_rate']: ''); ?>" tabindex="<?=$tabindex+1?>"/>
                            </div>
                          </div>
                          
                          <div class="col-md-4 pd-top">
                            <label>Vendor Type</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="text" class="form-control" name="vendor_type"
                              placeholder="Vendor Type" value="<?php echo isset($vendor->vendor_type) ? 
                              $vendor->vendor_type : (isset($_SESSION['dback']['vendor_type']) ? 
                              $_SESSION['dback']['vendor_type']: ''); ?>" tabindex="<?=$tabindex+1?>"/>
                            </div>
                          </div>
                          
                          <div class="col-md-4 pd-top">
                            <label>Expertise in Product</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="text" class="form-control" name="expertise_in_product"
                              placeholder="Expertise in Product" value="<?php echo isset($vendor->expertise_in_product) ? 
                              $vendor->expertise_in_product : (isset($_SESSION['dback']['expertise_in_product']) ? 
                              $_SESSION['dback']['expertise_in_product']: ''); ?>" tabindex="<?=$tabindex+1?>"/>
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
                          <div class="col-md-4 pd-top">
                            <label>Source</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                            <?php $leadS = get_module_values('lead_source');?>
                              <select name="source" class="form-control" tabindex="<?=$tabindex+1?>">
                                  <option value="">Select</option>
                                  <?php if(isset($leadS) && !empty($leadS)):?>
                                  <?php foreach($leadS as $l):?>
                                  <option <?php echo isset($vendor->vendor_source) && $vendor->vendor_source==$l->lead_source_id ? 
                                  'selected' : (isset($_SESSION['dback']['vendor_source']) && $_SESSION['dback']['vendor_source'] ==  
                                  $l->lead_source_id ? 'selected': ''); ?>
                                  value="<?=base64_encode($l->lead_source_id)?>"><?=$l->lead_source_name?></option>
                                  <?php endforeach;?>
                                  <?php endif;?>
                              </select>
                            </div>
                          </div>
                          <?php if(false):?>
                          <div class="col-md-4 pd-top">
                            <label>GST No.</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="text" class="form-control" name="gst_number"
                              placeholder="GST Number" value="<?php echo isset($vendor->vendor_gst) ? 
                              $vendor->vendor_gst : (isset($_SESSION['dback']['vendor_gst']) ? $_SESSION['dback']['vendor_gst']: ''); ?>" tabindex="<?=$tabindex+1?>"/>
                            </div>
                          </div>
                          <?php endif;?>
                          
                          <div class="col-md-4 pd-top">
                            <label>Office Location</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input class="form-control" rows="3" name="office_address"
                              placeholder="Office Location" tabindex="<?=$tabindex+1?>" value="<?php echo isset($vendor->office_location) ? 
                              $vendor->office_location : (isset($_SESSION['dback']['office_location']) ? $_SESSION['dback']['office_location']: ''); ?>" />
                            </div>
                          </div>
                          
                          <div class="col-md-4 pd-top">
                            <label>Office Address</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <textarea class="form-control" rows="3" name="office_address"
                              placeholder="Office Address" tabindex="<?=$tabindex+1?>"><?php echo isset($vendor->office_address) ? 
                              $vendor->office_address : (isset($_SESSION['dback']['office_address']) ? $_SESSION['dback']['office_address']: ''); ?></textarea>
                            </div>
                          </div>
                          
                          <div class="col-md-4 pd-top">
                            <label>Comments</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <textarea class="form-control" rows="3" name="comments"
                              placeholder="Comments" tabindex="<?=$tabindex+1?>"><?php echo isset($vendor->comments) ? 
                              $vendor->comments : (isset($_SESSION['dback']['comments']) ? $_SESSION['dback']['comments']: ''); ?></textarea>
                            </div>
                          </div>
                          
                          <?php if(false):?>
                          <div class="col-md-4 pd-top">
                            <label>Country</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <select class="form-control select2" name="country" tabindex="<?=$tabindex+1?>">
                                <option value="">Country</option>
                                <?php $country = get_module_values('country'); 
                                if(isset($country) && !empty($country)):?>
                                <?php foreach($country as $c):?>
                                <option value="<?=$c->country_id?>" 
                                <?php echo isset($vendor->vendor_country) && $vendor->vendor_country == $c->country_id ? 
                                'selected' : (isset($_SESSION['dback']['vendor_country']) && $_SESSION['dback']['vendor_country'] ==  
                                  $l->lead_source_id ? 'selected': ''); ?>><?=$c->country_name?></option>
                                <?php endforeach;?>
                                <?php endif;?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4 pd-top">
                            <label>State</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <select class="form-control select2" name="state" tabindex="<?=$tabindex+1?>">
                                <option value="">State</option>
                                <?php $states = get_module_values('state'); 
                                if(isset($states) && !empty($states)):?>
                                <?php foreach($states as $s):?>
                                <option value="<?=$s->state_id?>" <?php echo isset($vendor->vendor_state) && $vendor->vendor_state == $s->state_id ? 
                                'selected' : (isset($_SESSION['dback']['vendor_state']) && $_SESSION['dback']['vendor_state'] ==  
                                  $l->lead_source_id ? 'selected': ''); ?>><?=$s->state_name?></option>
                                <?php endforeach;?>
                                <?php endif;?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4 pd-top">
                            <label>City</label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="text" name="city" value="<?php echo isset($vendor->vendor_city) ? 
                              $vendor->vendor_city : (isset($_SESSION['dback']['vendor_city']) ? $_SESSION['dback']['vendor_city']: ''); ?>" class="form-control" tabindex="<?=$tabindex+1?>"/>
                            </div>
                          </div>
                          
                          <div class="col-md-4 pd-top">
                            <label>Pincode <span class="text-danger">*</span></label>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input type="text" class="form-control" name="pincode"
                              placeholder="Pincode" value="<?php echo isset($vendor->vendor_pincode) ? 
                                $vendor->vendor_pincode : (isset($_SESSION['dback']['vendor_pincode']) ? $_SESSION['dback']['vendor_pincode']: ''); ?>" required="" tabindex="<?=$tabindex+1?>"/>
                            </div>
                            <?php if(isset($_SESSION['rfield']['pincode'])):?>
                          <span class="text-danger ferror"><?=$_SESSION['rfield']['pincode']?></span>
                          <?php endif;?>
                          </div>
                          <?php endif;?>
                          
                          <div class="col-md-12 text-right">
                            <div class="resets-button">
                               <input type="submit" name="submit" value="Submit" class="btn btn-success form-addvendor" tabindex="<?=$tabindex+1?>"/>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!---------------------------------------------tab3------------------------------->
              <?php if(false && isset($_GET['edit']) && !empty($_GET['edit'])):?>
              <div class="tab-pane fade" id="product">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-sm-12 col-xs-12">
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <!--<th class="list-check"><input type="checkbox" name="radioGroup" /></th>-->
                              <th>Product/Service</th>
                              <th>Payment</th>
                              <th>Recurring</th>
                              <th>BIlling</th>
                              <th>Due Date</th>
                              <!--<th>Next Due</th>-->
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if(isset($products) && !empty($products)):?>
                            <?php foreach($products as $p):?>
                              <tr>
                                <!--<th class="list-check"><input type="checkbox" name="radioGroup" /></th>-->
                                <td><?=$p->product_service_name?>&nbsp;(<?= $p->service_name ?>)</td>
                                <td>
                                    <?php if($p->price_override == '' || $p->price_override == 0): ?>
                                    <?=get_formatted_price($p->amount)?>
                                    <?php else:?>
                                    <?=get_formatted_price($p->price_override)?>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <?=get_formatted_price($p->next_due_amount)?>
                                </td>
                                <td><?=ucfirst($p->billing_cycle)?></td>
                                <td><?= $p->bill_status != 'paid' ? get_formatted_date($p->add_date) : get_formatted_date($p->next_due_date); ?></td>
                                <!--<td><?php // echo $p->billing_cycle !== 'onetime' ? get_formatted_date($p->next_due_date) : '-'; ?></td>-->
                                <td>
                                    <?php if($p->bill_status == 'pending' || $p->bill_status == 'due'): ?>
                                    <span class="label-danger label label-default">Unpaid</span>
                                    <?php else:?>
                                    <span class="label-success label label-default">Paid</span>
                                    <?php endif;?>
                                </td>
                                <td>
                                  <button type="button" class="btn btn-info btn-xs">
                                    <a href="<?=base_url()?>vendor/action?editCp=<?=base64_encode($p->vendor_product_id)?>"><i class="fa fa-pencil"></i></a>
                                  </button>
                                  <a onclick="return confirm('It will delete it Parmamently. Do you want to continue?');"
                                  href="<?=base_url()?>vendor/action?deleteCp=<?=base64_encode($p->vendor_product_id)?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                                </td>
                              </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endif;?>
              <!---------------------------------------------tab4------------------------------->
              <?php if(false && isset($_GET['edit']) && !empty($_GET['edit'])):?>
              <div class="tab-pane fade" id="invoice">
                <div class="col-sm-12 col-md-12 col-xs-12">
                  <div class="cards">
                    <div class="card-headers">
                      <p style="display: flex;width: 300px;float: right;">
                          <button class="btn btnss btn-success" onclick="mergeInvoices(event);">Merge</button>
                          <button class="btn btnss btn-warning" onclick="resendInvoices(event);">Resend</button>
                          <a href="<?=base_url()?>create-invoice?ref=<?=base64_encode($vendor->vendor_id.'_'.$vendor->vendor_name)?>"
                          class="btn btnss btn-success">Create Invoice</a>
                       </p>

                      <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>#Sr.</th>
                              <th>Invoice ID</th>
                              <th>Name</th>
                              <th>Payment Method</th>
                              <th>Due Date</th>
                              <th>Service</th>
                              <th>Amount</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if(isset($invoices) && !empty($invoices)):?>
                            <?php foreach($invoices as $i):?>
                              <tr>
                                <td class="list-check">
                                <input type="checkbox" class="checkme" value="<?=base64_encode($i->invoice_id)?>" />
                                </td>
                                <td><?php echo !empty($i->invoice_gid) ? $i->invoice_gid : $i->performa_id?></td>
                                <td><?=$i->vendor_name?></td>
                                <td><?=ucfirst($i->payment_method)?></td>
                                <td><?= get_formatted_date($i->invoice_due_date) ?></td>
                                <td><?=get_invoice_services_no($i->invoice_id)?></td>
                                <td><?="<span style='color:green;'>".get_formatted_price($i->paid_amount)."</span>/<span style='color:red;'>".get_formatted_price($i->invoice_total)."</span>"?></td>
                                <td>
                                    <?php if($i->order_status == 'pending' || $i->order_status == 'due'): ?>
                                    <span class="label-danger label label-default">Unpaid</span>
                                    <?php else:?>
                                    <span class="label-success label label-default">Paid</span>
                                    <?php endif;?>
                                </td>
                                <td>
                                 <button type="button" class="btn btn-success btn-xs">
                                  <a target="_blank" href="<?=base_url()?>vendor/show_inv?view=<?=base64_encode($i->invoice_id)?>"><i class="fa fa-eye"></i></a>
                                  </button>
                                  <?php if($i->paid_amount == 0):?>
                                  <button type="button" class="btn btn-warning btn-xs" title="Edit Invoice">
                                    <a href="<?=base_url()?>edit-invoice?isc=<?=base64_encode($i->vendor_id)?>&edit=<?=base64_encode($i->invoice_id)?>"><i class="fa fa-pencil"></i></a>
                                  </button>
                                  <?php endif;?>
                                  <button type="button" class="btn btn-success btn-xs" title="Add Payment">
                                    <a href="<?=base_url()?>invoice/payment/<?=base64_encode($i->invoice_id)?>?isc=<?=base64_encode($i->vendor_id)?>"><i class="fa fa-money"></i></a>
                                  </button>
                                  <a onclick="return confirm('It will delete it Parmamently. Do you want to continue?');"
                                  href="<?=base_url()?>invoice/action?delete=<?=base64_encode($i->invoice_id)?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                                </td>
                              </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endif;?>
              <!---------------------------------------------tab5------------------------------->
              <?php if(false && isset($_GET['edit']) && !empty($_GET['edit'])):?>
              <div class="tab-pane fade" id="email">
                <div class="col-sm-12 col-md-12 col-xs-12">
                  <div class="cards">
                    <div class="card-headers">
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="emailCtable">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Date</th>
                              <th>Subject</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if(isset($emails) && !empty($emails)):?>
                            <?php $i=1; foreach($emails as $e):?>
                            <tr>
                              <td><?=$i?></td>
                              <td><?=get_formatted_date($e->created)?></td>
                              <td><?=$e->email_subject?></td>
                              <td>
                                <button type="button" class="btn btn-info btn-xs" onclick="showView('<?=base64_encode($e->vendor_eh_id)?>','email')"><i class="fa fa-eye"></i></button>
                                </td>
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
              <?php endif;?>
              <!---------------------------------------------tab6------------------------------->
              <?php if(false && isset($_GET['edit']) && !empty($_GET['edit'])):?>
              <div class="tab-pane fade" id="SMS">
                <div class="col-sm-12 col-md-12 col-xs-12">
                  <div class="cards">
                    <div class="card-headers">
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="smsCtable">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Date</th>
                              <th>Message</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if(isset($sms) && !empty($sms)):?>
                            <?php $i=1; foreach($sms as $s):?>
                            <tr>
                              <td><?=$i?></td>
                              <td><?=get_formatted_date($s->created)?></td>
                              <td><?=$s->sms_subject?><br>
                                  <?=$s->sms_content?></td>
                              <td>
                                <button type="button" class="btn btn-info btn-xs" onclick="showView('<?=base64_encode($s->vendor_sh_id)?>','sms')"><i class="fa fa-eye"></i></button>
                                </td>
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
              <?php endif;?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div id="viewModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="viewTitle"></h4>
      </div>
      <div class="modal-body">
        <div id="viewContent">
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
  
</section>
<?php else:?>
<p class="badge badge-danger">Vendor access denied.</p>
<?php endif;?>