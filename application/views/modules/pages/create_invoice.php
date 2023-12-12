<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<?php $or = array(); ?>
<?php 
if(isset($_GET['ref']) && !empty($_GET['ref'])){
    $ref = isset($_GET['ref']) ? base64_decode($_GET['ref']) : ''; 
    $ref = explode("_",$ref);
    $cid = isset($ref[0]) ? $ref[0] : $i->client_id; $cn = $ref[1];
}else{$cid=isset($i->client_id) ? $i->client_id : '';$cn= isset($i->client_id) ? get_client_info($i->client_id,"client_name"):'';}
?>
<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd">
        <div class="panel-heading">
          <div class="btn-group"><?php echo isset($i->client_id) ? get_client_info($i->client_id,'client_name')." - ".get_client_info($i->client_id,'client_company') :'Create Open Invoice'?></div>
        </div>
        <div class="panel-body">
          <form method="post" action="<?=base_url()?>invoice/create_invoice" id="invForm">
            <div class="col-sm-6 col-xs-12">
              <div class="cardses">
                <div class="row">
                  <div class="col-md-12">
                    <div class="address-sec">Create Invoice</div>
                  </div>
                  <div class="card-headers">
                    <div class="col-md-4 pd-top"><label>Client Name</label></div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="hidden" name="invoice_id" 
                        value="<?php echo isset($i->invoice_id) ? $i->invoice_id : ''; ?>" />
                        <input type="hidden" name="invoice_gid" 
                        value="<?php echo isset($i->invoice_gid) ? $i->invoice_gid : ''; ?>" />
                        <input type="hidden" name="client_id" id="client_id"
                        value="<?php echo isset($i->client_id) ? $i->client_id : (isset($cid) ? $cid : ''); ?>"/>
                        <input type="text" class="form-control" id="inv_cname" name="inv_cname"
                        placeholder="Search by ID, Name or Company" required=""
                        value="<?php echo isset($i->client_name) ? $i->client_name : (isset($cn) ? $cn : '') ; ?>"/>
                      </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                        <button type="button" class="btn btn-info w-med m-b-5 form-control">
                            <a href="<?=base_url('add-client')?>?ref=inv"><i class="fa fa-plus"></i></a></button>
                        </div>
                        </div>
                    <div class="col-md-4 pd-top"><label>GST Number</label></div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="text" class="form-control" name="gst" id="gstnumber"
                            placeholder="optional" value="<?php echo isset($cid) ? get_client_gst($cid) :'' ?>"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pd-top"><label>PAN Number</label></div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="text" class="form-control" name="pan" id="pannumber"
                            placeholder="optional" value="<?php echo isset($cid) ? get_client_info($cid,'client_pan') :'' ?>"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pd-top"><label>CIN</label></div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="text" class="form-control" name="cin" id="cinnumber"
                            placeholder="optional" value="<?php echo isset($cid) ? get_client_info($cid,'client_cin') :'' ?>"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pd-top"><label>Payment Method</label></div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <select class="form-control" name="inv_pmethod">
                          <option value="">Select</option>
                          <option value="online"
                          <?php echo isset($i->payment_method) && $i->payment_method == 'online' ? 'selected' : ''; ?>
                          >Online</option>
                          <option value="chq-deposit"
                          <?php echo isset($i->payment_method) && $i->payment_method == 'chq-deposit' ? 'selected' : ''; ?>
                          >Chq/Deposit</option>
                          <option value="cod" 
                          <?php echo isset($i->payment_method) && $i->payment_method == 'cod' ? 'selected' : ''; ?>
                          >Cod</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 pd-top"><label>Order Status</label></div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <select class="form-control" name="inv_ostatus">
                          <option value="">Select</option>
                          <?php if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
            && $_SESSION['roll']=='admin'):?>
                          <option value="pending">Pending</option>
                          <option value="paid"
                          <?php echo isset($i->order_status) && $i->order_status == 'paid' ? 'selected' : ''; ?>
                          >Paid</option>
                          <?php endif;?>
                          <option value="due"
                          selected
                          >Due</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 pd-top"><label>GST</label></div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <select class="form-control" name="inv_gst" id="inv_gst" onchange="gstCalc();">
                          <option value="">Select</option>
                          <option value="yes" 
                          <?php echo isset($i->gst) && $i->gst == 'yes' ? 'selected' : ''; ?>
                          >Yes</option>
                          <option value="no"
                          <?php echo isset($i->gst) && $i->gst == 'no' ? 'selected' : ''; ?>
                          >No</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="address-sec">Product Service</div>
                  </div>
                  <div class="service-con">
                    <div class="card-headers">
                      <div class="col-md-4 pd-top"><label>Product/Service</label></div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <input type="hidden" name="cpid[]" value="<?php echo isset($cp[0]->client_product_id) ? $cp[0]->client_product_id : '' ?>" />
                          <select class="form-control invp" id="invp_<?php echo isset($cp[0]->product_id) ? $cp[0]->product_id : 1 ?>"
                          onchange="get_product_d(this);"
                          name="inv_product[]">
                            <option value="">Select</option>
                            <?php $ps = get_module_values('product_service'); 
                            if(isset($ps) && !empty($ps)):?>
                            <?php foreach($ps as $p):?>
                            <option value="<?=$p->product_service_id?>" 
                            <?php echo isset($cp[0]->product_id) && $cp[0]->product_id == $p->product_service_id ? 'selected':''; ?>
                            ><?=$p->product_service_name?></option>
                            <?php endforeach;?>
                            <?php endif;?>
                          </select>
                        </div>
                      </div>
                      <?php $s = isset($i->products_name)? explode("_",$i->products_name): '';?>
                      <div class="col-md-4 pd-top"><label>Service Name</label></div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <input type="text" class="form-control" name="inv_sname[]" id="invs_<?php echo isset($cp[0]->product_id) ? $cp[0]->product_id : 1 ?>"
                          placeholder="Service Name" required="" onkeyup="reflectS(this)" value="<?php echo isset($s[0])?$s[0]:'';?>" />
                        </div>
                      </div>

                      <div class="col-md-4 pd-top"><label>Billing Cycle</label></div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <select class="form-control" id="invb_<?php echo isset($cp[0]->product_id) ? $cp[0]->product_id : 1;?>" name="inv_bcycle[]">
                            <option value="">Select</option>
                            <option value="onetime"
                            <?php echo isset($cp[0]->billing_cycle) && $cp[0]->billing_cycle == 'onetime' ? 'selected' : '';?>
                            >One Time</option>
                            <option value="monthly"
                            <?php echo isset($cp[0]->billing_cycle) && $cp[0]->billing_cycle == 'monthly' ? 'selected' : '';?>
                            >Monthly</option>
                            <option value="quarterly"
                            <?php echo isset($cp[0]->billing_cycle) && $cp[0]->billing_cycle == 'quarterly' ? 'selected' : '';?>
                            >Quarterly</option>
                            <option value="semesterly" 
                            <?php echo isset($cp[0]->billing_cycle) && $cp[0]->billing_cycle == 'semesterly' ? 'selected' : '';?>
                            >Semesterly</option>
                            <option value="yearly" 
                            <?php echo isset($cp[0]->billing_cycle) && $cp[0]->billing_cycle == 'yearly' ? 'selected' : '';?>
                            >Yearly</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 pd-top"><label>Price override</label></div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <input type="text" class="form-control" onkeyup="overRideP(this);" id="invO_<?php echo isset($cp[0]->product_id) ? $cp[0]->product_id : 1 ?>" name="inv_poverride[]"
                        placeholder="Price" value="<?php echo isset($cp[0]->price_override)?$cp[0]->price_override:'';?>"/>
                        </div>
                        <?php isset($cp[0]->price_override) ? array_push($or,$cp[0]->price_override) : '';?>
                      </div>
                      
                      <div class="col-md-4 pd-top">
                    <label>Renewal Override</label></div>
                    <div class="col-md-8">
                    <div class="form-group">
                    <input type="text" class="form-control" id="invRO_<?php echo isset($cp[0]->product_id) ? $cp[0]->product_id : 1 ?>" 
                    name="inv_roverride[]" placeholder="Price" value="<?php echo isset($cp[0]->next_due_amount)?$cp[0]->next_due_amount:'';?>" />
                    </div>
                    </div>
                      
                    </div>
                    <?php if(isset($cp[1]) && !empty($cp[1])):?>
                    <?php for($j=1; $j<count($cp); $j++):?>
                    
                    <div class="card-headers" id="id<?=$cp[$j]->product_id?>">
                <div class="col-md-4 pd-top">
                <label>Product/Service</label></div>
                <div class="col-md-8">
                    <div class="form-group">
                    <input type="hidden" name="cpid[]" value="<?php echo isset($cp[$j]->client_product_id) ? $cp[$j]->client_product_id : '' ?>" />
                    <select class="form-control invp" id="invp_<?=$cp[$j]->product_id?>" onchange="get_product_d(this);" name="inv_product[]">
                    <option value="">Select</option>
                    <?php $ps = get_module_values('product_service'); 
                    if(isset($ps) && !empty($ps)):?>
                    <?php foreach($ps as $p):?>
                    <option value="<?=$p->product_service_id?>"
                    <?php echo isset($cp[$j]->product_id) && $cp[$j]->product_id == $p->product_service_id ? 'selected':''; ?>
                    ><?=$p->product_service_name?></option>
                    <?php endforeach;?>
                    <?php endif;?>   
                    </select>
                    </div>
                    </div>
                    <div class="col-md-4 pd-top">
                    <label>Service Name</label></div>
                    <div class="col-md-8">
                    <div class="form-group">
                    <input type="text" class="form-control" name="inv_sname[]" onkeyup="reflectS(this)"
                    id="invs_<?php echo isset($cp[$j]->product_id) ? $cp[$j]->product_id : '' ?>"
                    value="<?php echo isset($s[$j])?$s[$j]:'';?>"
                    placeholder="Service Name" required="">
                        </div>
                    </div>
                     <div class="col-md-4 pd-top">
                    <label>Billing Cycle</label></div>
                    <div class="col-md-8">
                    <div class="form-group">
                    <select class="form-control" id="invb_<?=$cp[$j]->product_id?>" name="inv_bcycle[]" readonly>
                    <option value="">Select</option>
                    <option value="onetime"
                    <?php echo isset($cp[$j]->billing_cycle) && $cp[$j]->billing_cycle == 'onetime' ? 'selected' : '';?>
                    >One Time</option>
                    <option value="monthly"
                    <?php echo isset($cp[$j]->billing_cycle) && $cp[$j]->billing_cycle == 'monthly' ? 'selected' : '';?>
                    >Monthly</option>
                    <option value="quarterly"
                    <?php echo isset($cp[$j]->billing_cycle) && $cp[$j]->billing_cycle == 'quarterly' ? 'selected' : '';?>
                    >Quarterly</option>
                    <option value="semesterly"
                    <?php echo isset($cp[$j]->billing_cycle) && $cp[$j]->billing_cycle == 'semesterly' ? 'selected' : '';?>
                    >Semesterly</option>
                    <option value="yearly"
                    <?php echo isset($cp[$j]->billing_cycle) && $cp[$j]->billing_cycle == 'yearly' ? 'selected' : '';?>
                    >Yearly</option>
                    </select>
                    </div>
                    </div>
                    <div class="col-md-4 pd-top">
                    <label>Price Override</label></div>
                    <div class="col-md-8">
                    <div class="form-group">
                    <input type="text" class="form-control" onkeyup="overRideP(this);" id="invO_<?=$cp[$j]->product_id?>" 
                    name="inv_poverride[]" placeholder="Price" value="<?php echo isset($cp[$j]->price_override)?$cp[$j]->price_override:'';?>" />
                    </div>
                    <?php isset($cp[$j]->price_override) ? array_push($or,$cp[$j]->price_override) : '';?>
                    </div>
                    
                    <div class="col-md-4 pd-top">
                    <label>Renewal Override</label></div>
                    <div class="col-md-8">
                    <div class="form-group">
                    <input type="text" class="form-control" id="invRO_<?=$cp[$j]->product_id?>" 
                    name="inv_roverride[]" placeholder="Price" value="<?php echo isset($cp[$j]->next_due_amount)?$cp[$j]->next_due_amount:'';?>" />
                    </div>
                    </div>
                    
                    <p class="remove-btn">
                    <button class="btn btn-danger text-left" type="button" onclick="removeInvMe('<?=$cp[$j]->product_id?>')">Remove</button></p>
                    </div>
                    <?php endfor;?>
                    <?php endif;?>
                  </div>
                </div>
                
              <div class="col-md-12">
                <div class="btn-group">
                  <a class="btn btn-primary" href="javascript:;" onclick="addService();">
                       <i class="fa fa-plus-circle"></i> Add Another </a>
                </div>
              </div>
              </div>
            </div>
            <div class="col-sm-6 col-xs-12">
              <div class="cardses">
                <div class="row">
                  <div class="col-md-12">
                    <div class="address-sec">Order Summery</div>
                  </div>
                  <div class="card-headers invoice-bord">
                    <div class="headding_ex">
                      
                      <table class="table invoice" id="plistInv">
                        
                        <?php if(isset($products) && !empty($products)): ?>
                        <?php $k=0; foreach($products as $p):?>
                        <?php $n = strtolower($p->product_service_name); $n = preg_replace('/[^A-Za-z0-9\-]/','', $n);
                        $n = str_replace(' ','', $n);?>
                        
                        <tr id="p<?=$p->product_service_id?>" data-i="<?=$n?>" 
                        data-un="<?=get_formatted_price($p->set_up_fee + $p->payment)?>"
                        data-p="<?=get_formatted_price(isset($or[$k]) && $or[$k]!=0 ? $or[$k] : $p->set_up_fee + $p->payment)?>" data-r="<?=$p->recurring?>">
                        
                        <td class="border-linenone" id="n<?=$p->product_service_id?>">
                            <b><?=$p->product_service_name?></b>
                            <span id="sn<?=$p->product_service_id?>"> [<?php echo isset($s[$k]) ? $s[$k] : ''?>]</span><br>
                            (<?=get_formatted_price($p->payment)?> + [<?=get_formatted_price($p->set_up_fee)?> - setup fee])
                        </td>
                        
                        <?php if(isset($or[$k]) && $or[$k]!=0):?>
                        <td class="border-linenone" id="rs<?=$p->product_service_id?>" style="text-align:right;"><?=get_formatted_price($or[$k])?>/</td>
                        <?php else:?>
                        
                        <td class="border-linenone" id="rs<?=$p->product_service_id?>" style="text-align:right;"><?=get_formatted_price($p->set_up_fee + $p->payment)?>/</td>
                        <?php endif;?>
                        </tr>
                        
                        <?php $k++; endforeach;?>
                        <?php endif;?>
                      </table>
                      <table class="table invoice">
                        <tr id="disRow" style="<?php echo isset($i->discount) && !empty($i->discount) ? '' : 'display:none;'?>">
                          <td class="border-linenone">Discount</td>
                          <td class="border-linenone" style="text-align:right;"><?=get_formatted_price('<span id="discount"></span>')?>/</td>
                        </tr>  
                          
                        <tr class="doted-border">
                          <td class="border-linenone">Sub Total</td>
                          <td class="border-linenone" style="text-align:right;"><?=get_formatted_price('<span id="subtotal"></span>')?>/</td>
                        </tr>
                        
                        <tr class="bg-color" id="gstRow" style="display:none;">
                          <td class="border-linenone">GST <?=get_config_item('default_tax')?>%</td>
                          <td class="border-linenone" style="text-align:right;"><?=get_formatted_price('<span id="gsttotal"></span>')?>/</td>
                        </tr>
                        <tr class="toatal-bg">
                          <td class="border-linenone"><h2>Total</h2></td>
                          <td class="border-linenone" style="text-align:right;"><h2><?=get_formatted_price('<span id="totalP"></span>')?>/</h2></td>
                        </tr>
                        <tr class="recurring">
                          <td class="border-linenone">Recurring</td>
                          <td class="border-linenone" style="text-align:right;"><?=get_formatted_price('<span id="recurring"></span>')?>/</td>
                        </tr>
                        
                        
                      </table>
                      <div class="row invoice-top">
                          <div class="col-md-8 col-xs-12">
                                  <div class="form-group">  
                           <input type="text" name="coupon" id="coupon" placeholder="Enter discount coupon..." class="form-control" />
                          </div>
                                </div>
                            <div class="col-md-4 col-xs-12">
                                  <div class="form-group">
                                   <button type="button" id="apc" class="btn btnes btn-block btn-info form-control">Apply</button>
                              </div>
                              </div>
                          
                      </div>
                     <div class="border-btnss"></div>
                      <div class="row">
                          <div class="col-md-12 col-xs-12">
                            <div class="col-md-6 col-xs-12">
                            <div class="form-group">  
                            <input type="text" name="inv_create_date" id="inv_create_date" value="<?php echo isset($i->created) ? get_formatted_date($i->created): '';?>"
                           placeholder="Create date" class="form-control"/></td>
                         </div>
                        </div>
                          <div class="col-md-6 col-xs-12">
                            <div class="form-group">  
                            <input type="text" name="inv_due_date" id="inv_due_date" 
                           placeholder="Due date" class="form-control" value="<?php echo isset($i->invoice_due_date) ? get_formatted_date($i->invoice_due_date): '';?>"/></td>
                         </div>
                        </div>
                        
                      </div></div>
                      
                    </div>
                    <!-- Default unchecked -->

                    <!--<table class="table">-->
                    <!--  <tr>-->
                    <!--    <td class="border-linenone">Send email</td>-->
                    <!--    <td class="border-linenone">-->
                    <!--        <input type="checkbox" name="send_mail" class="custom-control-input" /></td>-->
                    <!--  </tr>-->
                    <!--  <tr>-->
                    <!--    <td class="border-linenone">SMS Notification</td>-->
                    <!--    <td class="border-linenone">-->
                    <!--        <input type="checkbox" name="send_sms" class="custom-control-input"/></td>-->
                    <!--  </tr>-->
                    <!--</table>-->
                   <div class="row">
                   <div class="col-md-12">
                      <div class="col-md-10 col-xs-10"> <div class="form-group">Send email</div></div> 
                      <div class="col-md-2 col-xs-2"> <div class="form-group">
                          <input type="checkbox" name="send_mail" class="custom-control-input" /></div></div> 
                   </div>
                   </div>
                   <div class="row">
                        <div class="col-md-12">
                      <div class="col-md-10 col-xs-10"> <div class="form-group">SMS Notification</div></div> 
                      <div class="col-md-2 col-xs-2">
                           <div class="form-group">
                           <input type="checkbox" name="send_sms" class="custom-control-input"/></div></div> 
                   </div>
                   </div>
                    <div class="btn-group order-submit">
                      <button class="btn btn-primary" type="submit">Submit Order <i class="fa fa-angle-double-right"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php if(isset($i->discount)):?>
<script>document.getElementById('discount').innerHTML = (<?=$i->discount?>);</script>
<?php endif;?>