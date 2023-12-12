<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>
<?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true):?>
<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
        <form class="row" style="margin-bottom:45px;">
           <div class="col-md-3 form-group">
               <label>Client</label>
               <select name="client" class="form-control" onchange="this.form.submit();">
                   <option value="">Select Client</option>
                   <?php foreach($clients as $c):?>
                    <option value="<?=$c->client_id?>" <?=isset($_GET['client']) && $_GET['client'] === $c->client_id ? 'selected' : ''?>><?=$c->client_name?></option>
                   <?php endforeach;?>
               </select>
           </div>
           <div class="col-md-3 form-group">
               <label>Project</label>
               <select name="project" class="form-control" onchange="this.form.submit();">
                   <option value="">Select Project</option>
                   <?php foreach($projects as $p):?>
                   <?php if(isset($_GET['client']) && $_GET['client'] === $p->client_id ):?>
                    <option value="<?=$p->project_id?>" <?=isset($_GET['project']) && $_GET['project'] === $p->project_id ? 'selected' : ''?>><?=$p->project_name?></option>
                   <?php endif;?>
                   <?php endforeach;?>
               </select>
           </div>
           <div class="col-md-3 form-group">
               <label>Payment Type</label>
               <select name="type" class="form-control" onchange="this.form.submit();">
                   <option value="">Select Payment Type</option>
                   <option value="cash" <?php echo isset($_GET['type']) && $_GET['type'] == 'cash' ? 'selected':'';?>>Cash</option>
                  <option value="credit" <?php echo isset($_GET['type']) && $_GET['type'] == 'credit' ? 'selected':'';?>>Credit</option>
                  <option value="paytm" <?php echo isset($_GET['type']) && $_GET['type'] == 'paytm' ? 'selected':'';?>>Paytm</option>
                  <option value="googlepay" <?php echo isset($_GET['type']) && $_GET['type'] == 'googlepay' ? 'selected':'';?>>Googlepay</option>
                  <option value="phonepay" <?php echo isset($_GET['type']) && $_GET['type'] == 'phonepay' ? 'selected':'';?>>Phonepay</option>
                  <option value="online transfter" <?php echo isset($_GET['type']) && $_GET['type'] == 'online transfer' ? 'selected':'';?>>Online Transfer</option>
                  <option value="adjustment" <?php echo isset($_GET['type']) && $_GET['type'] == 'adjustment' ? 'selected':'';?>>Adjustment</option>
                  <option value="product upsell" <?php echo isset($_GET['type']) && $_GET['type'] == 'product upsell' ? 'selected':'';?>>Product Upsell</option>
               </select>
           </div>
           <div class="col-md-3 form-group">
               <label>Date</label>
                <input type="date" name="date" onchange="this.form.submit();" value="<?=$_GET['date'] ?? ''?>" class="form-control"/>
           </div>
       </form>
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
          <div class="panel-heading ui-sortable-handle">
               <div class="btn-group"><p>Client Payments</p></div>
                  
                  <div style="float:right;">
                      <button type="button" style="color:#fff;margin-left:5px;" 
               class="btn btn-sm btn-primary">
               <a style="color:#fff"; href="<?=base_url()?>add-payment">Add Payment</a></button>  
               <a style="margin-left:10px;float:right;" href="<?=base_url()?>report/export_payment_data?<?= http_build_query($_GET)?>"
          class="btn btn-sm btn-primary">Export Whole Data</a>
                  </div>          
            
            </div>
       
        <div class="panel-body">
          <div class="row">
            <div class="cards">
              <div class="card-headers">
                <div class="table-responsive mob-bord">
                  <table class="table table-bordered table-hover" id="projectTable">
                    <thead>
                      <tr>
                        <!--<th><input type="checkbox" class="check"/></th>-->
                        <th>Project Name</th>
                        <th>Client Name</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Comment</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $ids=array(); if(isset($payments) && !empty($payments)):?>
                    <?php $total = 0; foreach($payments as $p):?>
                    <?php array_push($ids, base64_encode($p->passbook_id)) ?>
                      <tr>
                        <!--<td class="list-check">-->
                        <!--    <input type="checkbox" class="checkme" name="radioGroup" value="<?=base64_encode($p->passbook_id)?>" />-->
                        <!--</td>-->
                        <td><a href="<?=base_url()?>add-project/?edit=<?=base64_encode($p->project_id)?>">
                            <?=$p->project_name?>
                        </a></td>
                        <td><?=$p->client_name?></td>
                        <td><?=get_formatted_price($p->amount)?></td>
                        <td><?=ucwords($p->type)?></td>
                        <td><?=date('d-m-Y', strtotime($p->date))?></td>
                        <td><?=$p->comment?></td>
                        <td>
                          <a href="<?=base_url()?>add-payment/?edit=<?=base64_encode($p->passbook_id)?>" 
                          class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                          <a onclick="return confirm('Data will be lost. Do you want to continue?');"
                          href="<?=base_url()?>project/del_payment?d=<?=base64_encode($p->passbook_id)?>"
                          class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>
                      <?php $total +=  $p->amount;?>
                    <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                  </table>
                  <a href="<?=base_url()?>report/export_payment_data?<?= http_build_query($_GET)?>"
          class="btn btn-primary">Export Whole Data</a>
                <button class="btn btn-info">Total Amount: <?=get_formatted_price($total ?? 0);?></button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-info amount-above">Total Amount: <?=get_formatted_price($total ?? 0);?></button>
      </div>
    </div>
  </div>
</section>
<?php else:?>
<p>Access denied!</p>
<?php endif;?>