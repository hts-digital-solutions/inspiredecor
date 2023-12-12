<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
       <form class="row" style="margin-bottom:2px;">
           <div class="col-md-3 form-group">
               <label>Agent</label>
               <select name="agent" class="form-control select2" onchange="this.form.submit();">
                   <option value="">Select Agent</option>
                   <option value="0">Admin</option>
                   <?php foreach($agents as $a):?>
                    <option value="<?=$a->agent_id?>" <?=isset($_GET['agent']) && $_GET['agent'] === $a->agent_id ? 'selected' : ''?>><?=$a->agent_name?></option>
                   <?php endforeach;?>
               </select>
           </div>
           <div class="col-md-3 form-group">
               <label>Client</label>
               <select name="client" class="form-control select2" onchange="this.form.submit();">
                   <option value="">Select Client</option>
                   <?php foreach($clients as $c):?>
                    <option value="<?=$c->client_id?>" <?=isset($_GET['client']) && $_GET['client'] === $c->client_id ? 'selected' : ''?>><?=$c->client_name?></option>
                   <?php endforeach;?>
               </select>
           </div>
           <div class="col-md-3 form-group">
               <label>Project</label>
               <select name="project" class="form-control select2" onchange="this.form.submit();">
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
               <label>Month</label>
               <select name="month" class="form-control" onchange="this.form.submit();">
                   <option value="">Select Month</option>
                   <?php for($i=1; $i<=12; $i++):?>
                    <option value="<?=date('m', strtotime($i.'-'.$i.'-'.date('Y')))?>" <?=isset($_GET['month']) && $_GET['month'] === date('m', strtotime($i.'-'.$i.'-'.date('Y'))) ? 'selected' : ''?>><?=date('M', strtotime($i.'-'.$i.'-'.date('Y')))?></option>
                   <?php endfor;?>
               </select>
           </div>
           <div class="col-md-3 form-group">
               <label>Date</label>
                <input type="date" name="date" onchange="this.form.submit();" value="<?=$_GET['date'] ?? ''?>" class="form-control"/>
           </div>
           <div class="col-md-3 form-group">
               <label>Category</label>
               <select class="form-control select2" id="category" name="category" onchange="this.form.submit();">
                  <option value="">Select Category</option>
                  <?php foreach($categories as $c):?>
                  <option value="<?=strtolower($c->name)?>" <?php echo isset($_GET['category']) && $_GET['category'] == strtolower($c->name) ? 'selected':'';?>><?=$c->name?></option>
                  <?php endforeach;?>
              </select>
           </div>
           <div class="col-md-3 form-group">
               <label>Project Status</label>
               <select class="form-control" id="project_status" name="project_status" onchange="this.form.submit();">
                  <option value="">Select Project Status</option>
                  <option value="1" <?php echo isset($_GET['project_status']) && $_GET['project_status'] == '1' ? 'selected':'';?>>Active</option>
                  <option value="0" <?php echo isset($_GET['project_status']) && $_GET['project_status'] == '0' ? 'selected':'';?>>Completed</option>
              </select>
           </div>
           <div class="col-md-3 form-group">
               <label>From Date</label>
                <input type="date" name="from_date" onchange="this.form.submit();" value="<?=$_GET['from_date'] ?? ''?>" class="form-control"/>
           </div>
           <div class="col-md-3 form-group">
               <label>To Date</label>
                <input type="date" name="to_date" onchange="this.form.submit();" value="<?=$_GET['to_date'] ?? ''?>" class="form-control"/>
           </div>
       </form>
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
          <div class="panel-heading ui-sortable-handle">
               <div class="btn-group"><p>Expenses Report</p></div>
                  
            </div>
       
        <div class="panel-body">
          <div class="row">
            <div class="cards">
              <div class="card-headers">
                <div class="table-responsive mob-bord">
                  <table class="table table-bordered table-hover" id="projectTable">
                    <thead>
                      <tr>
                        <th>Project Name</th>
                        <th>Client Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price</th>
                        <th>Type</th>
                        <th>Comments</th>
                        <th>Created By</th>
                        <th>Date Time</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $ids=array(); $total = 0; if(isset($expenses) && !empty($expenses)):?>
                    <?php foreach($expenses as $p):?>
                    <?php array_push($ids, base64_encode($p->expense_id)) ?>
                      <tr>
                        <td><a href="<?=base_url()?>add-project/?edit=<?=base64_encode($p->project_id)?>">
                            <?=$p->project_name?>
                        </a></td>
                        <td><?=$p->client_name?></td>
                        <td><?=ucwords($p->category)?></td>                        
                        <td><?=$p->quantity?></td>
                        <td><?=get_formatted_price($p->price)?></td>
                        <td><?=get_formatted_price($p->total_price)?></td>
                        <td><?=ucwords($p->type)?></td>
                        <td><?=$p->comment?></td>
                        <td><?=empty($p->created_by_id) ? 'Admin' : get_info_of('agent', 'agent_name', $p->created_by_id, 'agent_id') ?></td>
                        <td><?= date('d-m-Y h:i:s a', strtotime($p->created)) ?></td>
                      </tr>
                      <?php $total += $p->total_price;?>
                    <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                  </table>
                  <a href="<?=base_url()?>report/export_expense_data?<?= http_build_query($_GET)?>"
          class="btn btn-primary">Export Whole Data</a>
          
                <button class="btn btn-info">Total Expenses: <?=get_formatted_price($total);?></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>