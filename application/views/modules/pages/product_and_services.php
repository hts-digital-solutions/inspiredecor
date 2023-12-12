<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>
<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
        <div class="panel-heading ui-sortable-handle">
          <div class="col-md-6 col-xs-8">
            <div class="btn-group"><p>Product and Services</p></div>
          </div>
          <div class="col-md-6 col-xs-4">
            <div class="reset-buttons">
              <?php if(isset($_GET['me'])): ?>
              <a href="<?=base_url('product-and-services?refadd')?>" class="btn btn-sm btn-success flipess">Add New</a>
              <?php else: ?>
              <button id="add-new" type="button" class="btn btn-sm btn-success flipess">Add New</button>
              <?php endif;?>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="cards">
              <div class="card-headers">
                <div class="table-responsive mob-bord">
                  <table class="table table-bordered table-hover" id="pandsTable">
                    <thead>
                      <tr>
                        <th class="list-check">
                            <input type="checkbox" class="check"/>
                        </th>
                        <th>Product Name</th>
                        <th>Billing Cycle</th>
                        <th>Price</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($products) && !empty($products)):?>
                    <?php foreach($products as $p):?>
                    <?php if($p->product_service_id != 0) { ?>
                      <tr>
                        <td class="list-check">
                            <input type="checkbox" class="checkme" value="<?=base64_encode($p->product_service_id)?>"/></td>
                        <td><?=$p->product_service_name?></td>
                        <td><?=ucfirst($p->billing_cycle)?></td>
                        <td><?= get_formatted_price($p->payment)?></td>

                        <td>
                          <a href="<?=base_url()?>product-and-services?me=<?=base64_encode($p->product_service_id)?>" 
                          class="btn btn-info btn-xs" ><i class="fa fa-pencil"></i></a>
                          <a onclick="return confirm('It will delete product Parmamently. Do you want to continue?');" 
                          href="<?=base_url()?>product/pdelete?me=<?=base64_encode($p->product_service_id)?>" 
                          class="btn btn-danger btn-xs" ><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>
                    <?php } ?>
                    <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                  </table>
                  <button type="button" onclick="deleteSelected('product-services');" class="btn btn-sm btn-danger">Delete</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <div class="col-sm-12 col-md-8 col-xs-12">
            <div id="add-new-service" <?php echo (isset($product)) ? '' :'style="display:none;"'?>>
              <form method="post" id="addService" name="addService">
                <div class="cardses">
                  <div class="row">
                    <div class="card-headers">
                      <div class="col-md-4 pd-top">
                        <lable>Add New Services</lable>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <input type="hidden" name="pid" id="pid"
                          value="<?php echo isset($product->product_service_id) ? base64_encode($product->product_service_id) : '';?>"/>
                          <input type="text" class="form-control" name="product_name"
                          placeholder="Product & Service Name" 
                          value="<?php echo isset($product->product_service_name) ? $product->product_service_name : '';?>" required="" />
                        </div>
                      </div>
                      <div class="col-md-4 pd-top">
                        <lable>Setup fee</lable>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <input type="text" class="form-control" name="setupfee"
                          placeholder="Setup fee" value="<?php echo isset($product->set_up_fee) ? $product->set_up_fee : '';?>"/>
                        </div>
                      </div>
                      <div class="col-md-4 pd-top">
                        <lable>Payment</lable>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <input type="text" class="form-control" placeholder="Payment"
                          name="payment" value="<?php echo isset($product->payment) ? $product->payment : '';?>"/>
                        </div>
                      </div>
                      <div class="col-md-4 pd-top">
                        <lable>Recurring Payment</lable>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <input type="text" class="form-control" placeholder="Recurring Payment"
                          name="recurring" value="<?php echo isset($product->recurring) ? $product->recurring : '';?>"/>
                        </div>
                      </div>
                      <div class="col-md-4 pd-top">
                        <lable>Billing Cycle</lable>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <select class="form-control" name="billing-cycle">
                            <option value="">Billing cycle</option>
                            <option value="onetime"
                            <?php echo isset($product->billing_cycle) && $product->billing_cycle == 'onetime' ? 'selected' : '';?>
                            >One Time</option>
                            <option value="monthly"
                            <?php echo isset($product->billing_cycle) && $product->billing_cycle == 'monthly' ? 'selected' : '';?>
                            >Monthly</option>
                            <option value="quarterly"
                            <?php echo isset($product->billing_cycle) && $product->billing_cycle == 'quarterly' ? 'selected' : '';?>
                            >Quarterly</option>
                            <option value="semesterly" 
                            <?php echo isset($product->billing_cycle) && $product->billing_cycle == 'semesterly' ? 'selected' : '';?>
                            >Semesterly</option>
                            <option value="yearly" 
                            <?php echo isset($product->billing_cycle) && $product->billing_cycle == 'yearly' ? 'selected' : '';?>
                            >Yearly</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-12 text-right">
                        <div class="resets-button">
                          <button type="button" id="close-new" class="btn btn-danger">Cancel</button>
                          <input type="submit" name="submit" value="Submit" class="btn btn-success" />
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
    </div>
  </div>
</section>
