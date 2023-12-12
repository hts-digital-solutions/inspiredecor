<?php defined("BASEPATH") OR exit("No direct access allowed.");?>

<section class="content content-header">
    <div class="row">
        <div class="panel panel-bd" style="display:inline-block;padding:20px 10px;">
            <form action="<?=base_url()?>client/update_cproduct" id="updateCp" method="POST">
            <div class="card-headers">
              <div class="col-md-12">
                  <div class="col-md-2 pd-top"><label>Product/Service</label></div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <input type="hidden" name="cid" value="<?php echo isset($cp->client_id) ? $cp->client_id : '' ?>" />
                      <input type="hidden" name="cpid" value="<?php echo isset($cp->client_product_id) ? $cp->client_product_id : '' ?>" />
                      <select class="form-control invp" id="invp_<?php echo isset($cp->product_id) ? $cp->product_id : 1 ?>"
                      onchange="get_cproduct_d(this);"
                      name="product">
                        <option value="">Select</option>
                        <?php $ps = get_module_values('product_service'); 
                        if(isset($ps) && !empty($ps)):?>
                        <?php foreach($ps as $p):?>
                        <option value="<?=$p->product_service_id?>" 
                        <?php echo isset($cp->product_id) && $cp->product_id == $p->product_service_id ? 'selected':''; ?>
                        ><?=$p->product_service_name?></option>
                        <?php endforeach;?>
                        <?php endif;?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2 pd-top"><label>First Payment Amount</label></div>
                  <div class="col-md-4">
                      <input type="text" name="fpay" id="fpay" 
                      value="<?php echo !empty($cp->price_override) ? $cp->price_override : ($cp->amount); ?>" 
                      class="form-control"/>
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="col-md-2 pd-top"><label>Service Name</label></div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <input type="text" class="form-control" name="sname"
                      placeholder="Service Name" required="" value="<?php echo isset($cp->service_name)?$cp->service_name:'';?>" />
                    </div>
                  </div>
                  <div class="col-md-2 pd-top"><label>Recurring Amount</label></div>
                  <div class="col-md-4">
                      <input type="text" name="ramount" id="ramount"
                      value="<?php echo isset($cp->next_due_amount) ? ($cp->next_due_amount):''; ?>"
                      class="form-control"/>
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="col-md-2 pd-top"><label>Billing Cycle</label></div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <select class="form-control" id="billing" name="bcycle">
                        <option value="">Select</option>
                        <option value="onetime"
                        <?php echo isset($cp->billing_cycle) && $cp->billing_cycle == 'onetime' ? 'selected' : '';?>
                        >One Time</option>
                        <option value="monthly"
                        <?php echo isset($cp->billing_cycle) && $cp->billing_cycle == 'monthly' ? 'selected' : '';?>
                        >Monthly</option>
                        <option value="quarterly"
                        <?php echo isset($cp->billing_cycle) && $cp->billing_cycle == 'quarterly' ? 'selected' : '';?>
                        >Quarterly</option>
                        <option value="semesterly" 
                        <?php echo isset($cp->billing_cycle) && $cp->billing_cycle == 'semesterly' ? 'selected' : '';?>
                        >Semesterly</option>
                        <option value="yearly" 
                        <?php echo isset($cp->billing_cycle) && $cp->billing_cycle == 'yearly' ? 'selected' : '';?>
                        >Yearly</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2 pd-top"><label>Payment Method</label></div>
                  <div class="col-md-4 form-group">
                      <select class="form-control" name="paymethod" id="paymethod">
                          <option value="">Select</option>
                          <option value="online"
                          <?php echo isset($cp->pay_method) && $cp->pay_method == 'online' ? 'selected' : ''; ?>
                          >Online</option>
                          <option value="chq-deposit"
                          <?php echo isset($cp->pay_method) && $cp->pay_method == 'chq-deposit' ? 'selected' : ''; ?>
                          >Chq/Deposit</option>
                          <option value="cod" 
                          <?php echo isset($cp->pay_method) && $cp->pay_method == 'cod' ? 'selected' : ''; ?>
                          >Cod</option>
                        </select>
                  </div>
                  
              </div>
              <div class="col-md-12">
                  <div class="col-md-2 pd-top"><label>Signup Date</label></div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <input type="text" class="form-control" id="reg_date" name="reg_date"
                    placeholder="Price" value="<?php echo isset($cp->add_date)? get_formatted_date($cp->add_date):'';?>"/>
                    </div>
                  </div>
                  
                  <div class="col-md-2 pd-top"><label>Next Due date</label></div>
                  <div class="col-md-4">
                      <input type="text" name="nextdue" id="nextduedate"
                      value="<?php echo isset($cp->next_due_date) ? get_formatted_date($cp->next_due_date):''; ?>"
                      class="form-control"/>
                  </div>
                  
              </div>
              <div class="col-md-12">
                  
                  <div class="col-md-2 pd-top"><label>Product Status</label></div>
                  <div class="col-md-4 form-group">
                      <select class="form-control" name="status">
                          <option value="">Select</option>
                          <option value="1"
                          <?php echo isset($cp->client_product_status) && $cp->client_product_status == 1 ? 'selected':'';?>
                          >Active</option>
                          <option value="0"
                          <?php echo isset($cp->client_product_status) && $cp->client_product_status == 0 ? 'selected':'';?>
                          >Suspended</option>
                      </select>
                  </div>
                  <div class="col-md-2 pd-top"><label>Invoice Status</label></div>
                  <div class="col-md-4 form-group">
                      <select class="form-control" name="billstatus">
                          <option value="">Select</option>
                          <option value="paid"
                          <?php echo isset($cp->bill_status) && $cp->bill_status == 'paid' ? 'selected':'';?>
                          >Paid</option>
                          <option value="pending"
                          <?php echo isset($cp->bill_status) && $cp->bill_status == 'pending' || $cp->bill_status == 'due' ? 'selected':'';?>
                          >Pending</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="col-md-2"><label>Admin Note</label></div>
                  <div class="col-md-6">
                      <textarea name="admin_note" class="form-control"><?php echo isset($cp->admin_note)? $cp->admin_note:'';?></textarea>
                  </div>
                  <div class="col-md-4">
                    <div class="btn-group" style="float:right;">
                      <button class="btn btn-primary" type="submit">Save Changes </button>
                    </div>
                  </div>
              </div>
            </div>
            </form>
        </div>
    </div>
</section>