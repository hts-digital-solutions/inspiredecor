<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<?php $or = array(); ?>
<?php 
if(isset($_GET['ref']) && !empty($_GET['ref'])){
    $ref = isset($_GET['ref']) ? base64_decode($_GET['ref']) : ''; 
    $ref = explode("_",$ref);
    $cid = $ref[0]; $cn = $ref[1];
}else{$cid='';$cn='';}
?>
<section class="content content-header">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd">
        <div class="panel-heading">
          <div class="btn-group">
              <?=get_client_info($i->client_id,'client_name')." - ".get_client_info($i->client_id,'client_company')?>
          </div>
        </div>
        <div class="panel-body">
        <div class="row">
        <div class="col-md-12">
        <div class="col-sm-6 col-xs-12">
          <div class="cardses">
            <div class="row">
              <div class="col-md-12">
                <div class="address-sec">Invoice</div>
              </div>
              <div class="card-headers">
                <div class="col-md-4 pd-top"><label>Payment Method</label></div>
                <div class="col-md-8">
                  <div class="form-group">
                      <p class="form-control"><?= ucfirst($i->payment_method)?></p>
                  </div>
                </div>
                <div class="col-md-4 pd-top"><label>Order Status</label></div>
                <div class="col-md-8">
                  <div class="form-group">
                      <p class="form-control"><?= ucfirst($i->order_status)?></p>
                  </div>
                </div>
                <div class="col-md-4 pd-top"><label>GST</label></div>
                <div class="col-md-8">
                  <div class="form-group">
                      <p class="form-control"><?php echo isset($i->client_id) ? get_client_gst($i->client_id) :'' ?></p>
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
                      <p class="form-control"><?= isset($cp[0]->product_id) ? ucfirst(get_module_value($cp[0]->product_id, 'product_service')) : '' ?></p>
                    </div>
                  </div>
                  <?php $s = isset($i->products_name)? explode("_",$i->products_name): '';?>
                  <div class="col-md-4 pd-top"><label>Service Name</label></div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <p class="form-control"><?= ucfirst($s[0])?></p>
                    </div>
                  </div>

                  <div class="col-md-4 pd-top"><label>Billing Cycle</label></div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <p class="form-control"><?= isset($cp[0]->billing_cycle) ? ucfirst($cp[0]->billing_cycle) : '' ?></p>
                    </div>
                  </div>
                  <div class="col-md-4 pd-top"><label>Price override</label></div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <p class="form-control"><?= isset($cp[0]->price_override) ? ucfirst($cp[0]->price_override) : '' ?></p>
                    </div>
                    <?php isset($cp[0]->price_override) ? array_push($or,$cp[0]->price_override) : '';?>
                  </div>
                  <div class="col-md-4 pd-top">
                    <label>Renewal Override</label></div>
                    <div class="col-md-8">
                    <div class="form-group">
                    <input type="text" class="form-control" id="invRO_<?= $cp[0]->product_id?>" 
                    name="inv_roverride[]" placeholder="Price" value="<?php echo isset($cp[0]->next_due_amount)?$cp[0]->next_due_amount:'';?>" />
                    </div>
                    </div>
                </div>
                <?php if(isset($cp[1]) && !empty($cp[1])):?>
                <?php for($j=1; $j<count($cp); $j++):?>
            <div class="card-headers">
            <div class="col-md-4 pd-top">
            <label>Product/Service</label></div>
            <div class="col-md-8">
                <div class="form-group">
                <input type="hidden" name="cpid[]" value="<?php echo isset($cp[$j]->client_product_id) ? $cp[$j]->client_product_id : '' ?>" />
                <p class="form-control"><?= ucfirst(get_module_value($cp[$j]->product_id, 'product_service'))?></p>
                </div>
                </div>
                <div class="col-md-4 pd-top">
                <label>Service Name</label></div>
                <div class="col-md-8">
                <div class="form-group">
                  <p class="form-control"><?php echo isset($s[$j]) ? ucfirst($s[$j]):''?></p>
                </div>
                </div>
                <div class="col-md-4 pd-top">
                <label>Billing Cycle</label></div>
                <div class="col-md-8">
                <div class="form-group">
                    <p class="form-control"><?= ucfirst($cp[$j]->billing_cycle)?></p>
                </div>
                </div>
                <div class="col-md-4 pd-top">
                <label>Price override</label></div>
                <div class="col-md-8">
                <div class="form-group">
                    <p class="form-control"><?= ucfirst($cp[$j]->price_override)?></p>
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
                </div>
                <?php endfor;?>
                <?php endif;?>
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
                  <table class="table invoice">
                    <?php if(isset($products) && !empty($products)): ?>
                    <?php $k=0; foreach($products as $p):?>
                    <?php $n = strtolower($p->product_service_name); $n = preg_replace('/[^A-Za-z0-9\-]/','', $n);
                    $n = str_replace(' ','', $n);?>
                    
                    <tr>
                    <td class="border-linenone">
                        <b><?=$p->product_service_name?></b>
                        <span id="sn<?=$p->product_service_id?>"> [<?php echo isset($s[$k]) ? $s[$k]:''?>]</span><br>
                        (<?=get_formatted_price($p->payment)?> + [<?=get_formatted_price($p->set_up_fee)?> - setup fee])
                    </td>
                    
                    <?php if(isset($or[$k]) && $or[$k]!=0):?>
                    <td class="border-linenone" style="text-align:right;"><?=get_formatted_price($or[$k])?>/</td>
                    <?php else:?>
                    
                    <td class="border-linenone" style="text-align:right;"><?=get_formatted_price($p->set_up_fee + $p->payment)?>/</td>
                    <?php endif;?>
                    </tr>
                    
                    <?php $k++; endforeach;?>
                    <?php endif;?>
                  </table>
                  <?php if($i->paid_amount==0):?>
                  <table class="table invoice">
                    <tr id="disRow" style="<?php echo isset($i->discount) && !empty($i->discount) ? '' : 'display:none;'?>">
                      <td class="border-linenone">Discount</td>
                      <td class="border-linenone" style="text-align:right;"><?=get_formatted_price($i->discount)?>/</td>
                    </tr>
                    <tr class="doted-border">
                      <td class="border-linenone">Sub Total</td>
                      <td class="border-linenone" style="text-align:right;"><?=get_formatted_price($i->invoice_subtotal)?>/</td>
                    </tr>
                    <tr class="bg-color " style="<?php echo isset($i->gst_total) && !empty($i->gst_total) ? '' : 'display:none;'?>">
                      <td class="border-linenone">GST <?=get_config_item('default_tax')?>%</td>
                      <td class="border-linenone" style="text-align:right;"><?=get_formatted_price($i->gst_total)?>/</td>
                    </tr>
                    <tr class="bg-primary">
                      <td class="border-linenone">Received</td>
                      <td class="border-linenone" style="text-align:right;"><?=get_formatted_price($i->paid_amount)?>/</td>
                    </tr>
                    <tr class="toatal-bg">
                      <td class="border-linenone"><h2>Total</h2></td>
                      <td class="border-linenone" style="text-align:right;"><h2><?=get_formatted_price($i->invoice_total)?>/</h2></td>
                    </tr>
                    <tr class="recurring">
                      <td class="border-linenone">Recurring</td>
                      <td class="border-linenone" style="text-align:right;"><?php echo isset($cp[0]->next_due_amount)?$cp[0]->next_due_amount:'';?>/</td>
                    </tr>
                  </table>
                  <?php else:?>
                  <table class="table invoice">
                    <tr class="bg-primary">
                      <td class="border-linenone">Total Due</td>
                      <td class="border-linenone" style="text-align:right;"><?=get_formatted_price($i->invoice_total + $i->paid_amount)?>/</td>
                    </tr>
                    <tr class="toatal-bg">
                      <td class="border-linenone"><h2>Received</h2></td>
                      <td class="border-linenone" style="text-align:right;"><h2><?=get_formatted_price($i->paid_amount)?>/</h2></td>
                    </tr>
                    <tr class="recurring">
                      <td class="border-linenone">Balance Due</td>
                      <td class="border-linenone" style="text-align:right;"><?=get_formatted_price($i->invoice_total)?>/</td>
                    </tr>
                  </table>
                  <?php endif;?>
                </div>
                <!-- Default unchecked -->
            <?php if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
            && $_SESSION['roll']=='admin' || 1):?>
             <div class="address-sec">Add Payment</div>
             <form action="<?=base_url()?>invoice/add_payment" method="POST">
                <input type="hidden" name="invoice_id" 
                value="<?php echo isset($i->invoice_id) ? $i->invoice_id : ''; ?>" />
                <input type="hidden" name="invoice_gid" 
                value="<?php echo isset($i->invoice_gid) ? $i->invoice_gid : ''; ?>" />
                <input type="hidden" name="client_id" 
                value="<?php echo isset($i->client_id) ? $i->client_id : ''; ?>" />
                <input type="hidden" name="itotal" 
                value="<?php echo isset($i->invoice_total) ? $i->invoice_total : ''; ?>" />
                <input type="hidden" name="paid_amount" 
                value="<?php echo isset($i->paid_amount) ? $i->paid_amount : ''; ?>" />
               <div class="col-md-4 pd-top"><label>Amount</label></div>
               <div class="col-md-8">
                    <div class="form-group">
                     <input type="text" class="form-control" name="amount"
                     placeholder="Amount" required="" onkeyup="if(isNaN(this.value)){alert('Please enter right amount.');}"/>
                    </div>
                </div>
               <div class="col-md-4 pd-top"><label>Payment Method</label></div>
               <div class="col-md-8">
                    <div class="form-group">
                     <select class="form-control" name="pay_method" required>
                         <option value="">Payment Method</option>   
                         <option value="online">Online</option>
                         <option value="chq-deposit">Chq-deposit</option>
                         <option value="razorpay">Razorpay</option>
                         <option value="neft">NEFT</option>
                         <option value="cod">Cod</option>   
                     </select>
                    </div>
                </div>
               <div class="col-md-4 pd-top"><label>Transaction ID</label></div>
               <div class="col-md-8">
                    <div class="form-group">
                     <input type="text" class="form-control" name="txnid"
                     placeholder="Transaction ID" required="">
                    </div>
                </div>
                <div class="col-md-4 pd-top"><label>Date</label></div>
               <div class="col-md-8">
                    <div class="form-group">
                     <input type="text" class="form-control datepicker" name="date"
                     placeholder="Payment Date" id="paydate">
                    </div>
                </div>
               <table class="table">
                  <tr>
                    <td class="border-linenone">Send email 
                        <input type="checkbox" name="send_mail" class="custom-control-input" />
                    </td>
                    <td class="border-linenone">SMS Notification
                        <input type="checkbox" name="send_sms" class="custom-control-input"/>
                    </td>
                  </tr>
                </table>
                <div class="btn-group order-submit">
                  <button class="btn btn-primary" type="submit">Submit <i class="fa fa-angle-double-right"></i></button>
                  <button class="btn btn-warning" type="button" onclick="resendInv(event,'<?=$this->uri->segment(3)?>');">Resend</button>
                </div>
               </form> 
              </div>
              <?php endif;?>
            </div>
          </div>
        </div>
        </div>
        </div>
        <div class="col-md-12">
            <h2>Transactions</h2>
            <table class="table" id="txnTable">
                <thead>
                    <tr>
                       <th>Date</th>
                       <th>Payment Method </th>
                       <th>Transactions id</th>
                       <th>Amount</th>
                       <th>Transactions Fees</th>
                       <th>Status</th>
                       <?php if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
            && $_SESSION['roll']=='admin'):?>
                       <th>Action</th>
                       <?php endif;?>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($txn) && !empty($txn)):?>
                    <?php foreach($txn as $t):?>
                    <tr>
                        <td><?=get_formatted_date($t->created)?></td>
                        <td><?=ucfirst($t->pay_method)?></td>
                        <td><?=($t->txn_id)?></td>
                        <td><?=get_formatted_price($t->amount)?></td>
                        <td><?=get_formatted_price($t->txn_fee)?></td>
                        <td>
                        <?php if($t->transaction_status==1):?>
                            <span class="label-success label label-default">Success</span>
                        <?php else:?>
                        <span class="label-danger label label-default">Failed</span>
                        <?php endif;?>
                        </td>
                        <?php if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
            && $_SESSION['roll']=='admin'):?>
                        <td>
                            <a href="<?=base_url()?>invoice/action?delTxn&d=<?=base64_encode($t->transaction_id)?>" 
                            class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                        </td>
                        <?php endif;?>
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
</section>

<?php if(isset($i->discount)):?>
<script>document.getElementById('discount').innerHTML = (<?=$i->discount?>);</script>
<?php endif;?>