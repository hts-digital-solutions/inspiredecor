<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
        <div class="panel-heading ui-sortable-handle">
          <div class="col-md-6">
            <div class="btn-group">Invoice Report</div>
          </div>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="cards">
                
              <div class="serach-lists">
                <div class="serach-lists">
                  <div class="row">
                      <form action="" method="get">
                      <div class="col-md-3 pd-02">
                        <div class="form-group">
                          <lable>Search By</lable>
                          <input type="hidden" id="invrcid" name="refid"
                          value="<?php echo isset($_GET['refid']) ? $_GET['refid']:''; ?>"
                          />
                          <input type="text" name="client" id="invrclient"
                          placeholder="Client Name" class="form-control" 
                          value="<?php echo isset($_GET['refid']) ? get_client_info($_GET['refid'],'client_name'):''; ?>"
                          />
                        </div>
                      </div>
                      <div class="col-md-3 pd-02">
                        <div class="form-group">
                          <lable>Invoice Type</lable>
                          <select class="form-control" name="rangetype" id="invrtype" onchange="showRange();">
                              <option value="">Select</option>
                              <option value="createdate"
                              <?php echo isset($_GET['rangetype']) && $_GET['rangetype'] == 'createdate' ? 'selected' : ''; ?>
                              >Created</option>
                              <option value="duedate"
                              <?php echo isset($_GET['rangetype']) && $_GET['rangetype'] == 'duedate' ? 'selected' : ''; ?>
                              >Due Invoice</option>
                              <option value="paiddate"
                              <?php echo isset($_GET['rangetype']) && $_GET['rangetype'] == 'paiddate' ? 'selected' : ''; ?>
                              >Paid Invoice</option>
                              <option value="pendingdate"
                              <?php echo isset($_GET['rangetype']) && $_GET['rangetype'] == 'pendingdate' ? 'selected' : ''; ?>
                              >Pending Invoice</option>
                          </select>
                        </div>
                      </div>
                      <?php
                      $cd = isset($_GET['rangetype']) && $_GET['rangetype'] == 'createdate' ? '' : 'style="display:none;"';
                      $dd = isset($_GET['rangetype']) && $_GET['rangetype'] == 'duedate' ? '' : 'style="display:none;"';
                      $pd = isset($_GET['rangetype']) && $_GET['rangetype'] == 'paiddate' ? '' : 'style="display:none;"';
                      $pnd = isset($_GET['rangetype']) && $_GET['rangetype'] == 'pendingdate' ? '' : 'style="display:none;"';
                      ?>
                      <div class="col-md-3 pd-02 cdrange" <?=$cd?>>
                        <div class="form-group">
                          <lable>Creation Date From</lable>
                          <input type="text" name="cdatef" id="invrcdatef"
                          placeholder="Creation Date" class="form-control" 
                          value="<?php echo isset($_GET['cdatef']) ? $_GET['cdatef']:''; ?>"
                          />
                        </div>
                      </div>
                      <div class="col-md-3 pd-02 cdrange" <?=$cd?>>
                        <div class="form-group">
                          <lable>Creation Date To</lable>
                          <input type="text" name="cdatet" id="invrcdatet"
                          placeholder="Creation Date" class="form-control" 
                          value="<?php echo isset($_GET['cdatet']) ? $_GET['cdatet']:''; ?>"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-3 pd-02 pndrange" <?=$pnd?>>
                        <div class="form-group">
                          <lable>Pending Date From</lable>
                          <input type="text" name="pndatef" id="invpndatef"
                          placeholder="Pending Date" class="form-control" 
                          value="<?php echo isset($_GET['pndatef']) ? $_GET['pndatef']:''; ?>"
                          />
                        </div>
                      </div>
                      <div class="col-md-3 pd-02 pndrange" <?=$pnd?>>
                        <div class="form-group">
                          <lable>Pending Date To</lable>
                          <input type="text" name="pndatet" id="invpndatet"
                          placeholder="Pending Date" class="form-control" 
                          value="<?php echo isset($_GET['pndatet']) ? $_GET['pndatet']:''; ?>"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-3 pd-02 ddrange" <?=$dd?>>
                        <div class="form-group">
                          <lable>Due Date From</lable>
                          <input type="text" name="duedatef" id="invduedatef" 
                          placeholder="Due Date From" class="form-control"
                          value="<?php echo isset($_GET['duedatef']) ? $_GET['duedatef']:''; ?>"
                          />
                        </div>
                      </div>
                      <div class="col-md-3 pd-02 ddrange" <?=$dd?>>
                        <div class="form-group">
                          <lable>Due Date To</lable>
                          <input type="text" name="duedatet" id="invduedatet" 
                          placeholder="Due Date To" class="form-control"
                          value="<?php echo isset($_GET['duedatet']) ? $_GET['duedatet']:''; ?>" />
                        </div>
                      </div>
                      
                      <div class="col-md-3 pd-02 pdrange" <?=$pd?>>
                        <div class="form-group">
                          <lable>Paid Date From</lable>
                          <input type="text" name="pdatef" id="invpdatef" 
                          placeholder="Paid Date From" class="form-control"
                          value="<?php echo isset($_GET['pdatef']) ? $_GET['pdatef']:''; ?>"
                          />
                        </div>
                      </div>
                      <div class="col-md-3 pd-02 pdrange" <?=$pd?>>
                        <div class="form-group">
                          <lable>Paid Date To</lable>
                          <input type="text" name="pdatet" id="invpdatet" 
                          placeholder="Paid Date To" class="form-control"
                          value="<?php echo isset($_GET['pdatet']) ? $_GET['pdatet']:''; ?>" />
                        </div>
                      </div>
                      
                      <div class="col-md-2 pd-02">
                        <div class="form-group">
                          <lable>Payment Method</lable>
                          <select class="form-control" name="pay_method">
                              <option value="">Payment Method</option>
                              <option value="online"
                              <?php echo isset($_GET['pay_method']) && $_GET['pay_method'] == 'online' ? 'selected' : ''; ?>
                              >Online</option>
                              <option value="chq-deposit"
                              <?php echo isset($_GET['pay_method']) && $_GET['pay_method'] == 'chq-deposit' ? 'selected' : ''; ?>
                              >Chq/Deposit</option>
                              <option value="cod" 
                              <?php echo isset($_GET['pay_method']) && $_GET['pay_method'] == 'cod' ? 'selected' : ''; ?>
                              >Cod</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <button type="submit" class="btn btn-success inveci">Submit</button>
                        </div>
                      </div>
                      </form>
                  </div>
                </div>
              </div>

              <div class="card-headers">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover" id="invRtable">
                    <thead>
                      <tr>
                        <th>Client Name</th>
                        <th>Invoice No.</th>
                        <th>Creation Date</th>
                        <th>Due Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment Method</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $invoices=array();?>
                      <?php if(isset($invreport) && !empty($invreport)):?>
                      <?php foreach($invreport as $inv):?>
                      <?php array_push($invoices, base64_encode($inv->invoice_id)); ?>
                      <tr>
                        <td>
                            <a href="<?=base_url('add-client?edit='.base64_encode($inv->client_id))?>" target="_blank">
                            <?=$inv->client_name?>
                            </a>
                        </td>
                        <td><?php echo !empty($inv->invoice_gid) ? $inv->invoice_gid : $inv->performa_id?></td>
                        <td><?=get_formatted_date($inv->invoice_date)?></td>
                        <td><?=get_formatted_date($inv->invoice_due_date)?></td>
                        <td><?="<span class='text-success'>".get_formatted_price($inv->paid_amount) . "</span>
                        <span class='text-danger'>/".
                        get_formatted_price($inv->invoice_total)."</span>"?></td>
                        <td>
                            <?php if($inv->order_status=='pending' || $inv->order_status=='due'):?>
                            <span class="label-danger label label-default">Unpaid</span>
                            <?php else:?>
                            <span class="label-success label label-default">Paid</span>
                            <?php endif;?>
                        </td>
                        <td><?=$inv->payment_method?></td>
                      </tr>
                      <?php endforeach;?>
                      <?php endif;?>
                    </tbody>
                  </table>
                  <a href="<?= base_url()?>report/batch_inv_export?inv=<?php print_r(implode(",",$invoices))?>"
                  target="_blank" class="btn btn-primary">Batch Invoice Pdf Export</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
