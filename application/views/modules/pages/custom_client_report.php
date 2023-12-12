<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header">
 <div class="row">
  <div class="col-sm-12">
   <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
    <div class="panel-heading ui-sortable-handle">
     <div class="btn-group">
      <p>Custom client report</p>
     </div>
    </div>
    <div class="panel-body">
     <div class="col-sm-12 col-md-12 col-xs-12">
      <div class="cards">
       <form action="" method="get">
       <div class="serach-lists">
        <p>Search by</p>
        <div class="col-md-2">
         <div class="form-group">
          <select class="form-control" name="service">
            <option value="">Product/Service</option>
            <?php $products = get_module_values('product_service'); ?>
            <?php if(isset($products) && !empty($products)):?>
            <?php foreach($products as $p):?>
            <option 
            <?php echo isset($_GET['service']) && $_GET['service']== base64_encode($p->product_service_id) ? "selected": "";?>
            value="<?=base64_encode($p->product_service_id)?>"><?=$p->product_service_name?></option>
            <?php endforeach;?>
            <?php endif;?>
          </select>
         </div>
        </div>
        
        <div class="col-md-3">
         <div class="form-group">
          <input type="text" name="ccrdatef" id="ccrdatef"
          class="form-control" placeholder="Start Date" 
          value="<?php echo isset($_GET['ccrdatef']) ? $_GET['ccrdatef'] : "";?>"/>
         </div>
        </div>
        <div class="col-md-3">
         <div class="form-group">
          <input type="text" name="ccrdatet" id="ccrdatet"
          class="form-control" placeholder="End Date" 
          value="<?php echo isset($_GET['ccrdatet']) ? $_GET['ccrdatet'] : "";?>"/>
         </div>
        </div>
        <div class="col-md-2">
         <select class="form-control" name="state">
            <option value="">State</option>
            <?php $states = get_module_values('state'); ?>
            <?php if(isset($states) && !empty($states)):?>
            <?php foreach($states as $s):?>
            <option 
            <?php echo isset($_GET['state']) && $_GET['state']== base64_encode($s->state_id) ? "selected": "";?>
            value="<?=base64_encode($s->state_id)?>"><?=$s->state_name?></option>
            <?php endforeach;?>
            <?php endif;?>
         </select>
        </div>
        <div class="col-md-2">
         <div class="form-group">
          <button type="submit" class="btn btnss btn-success">Submit</button>
         </div>
        </div>
       </div>
       </form>
       <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12"></div>
        <div class="card-headers">
         <div class="table-responsive">
          <table class="table table-bordered table-hover" id="ccrtable">
           <thead>
            <tr>
             <th>Client Name</th>
             <th>Contact NO</th>
             <th>Email ID</th>
             <th>No of Serice</th>
             <th>Income</th>
             <th>State</th>
            </tr>
           </thead>
           <tbody>
            <?php $ids=array(); if(isset($clients) && !empty($clients)):?>
            <?php foreach($clients as $c):?>
            <?php array_push($ids, base64_encode($c->client_id)) ?>
            <tr>
             <td><a target='_blank'
             href="<?=base_url()?>add-client?edit=<?=base64_encode($c->client_id)?>"><?=$c->client_name?></a></td>
             <td><?=$c->client_mobile?></td>
             <td><?=$c->client_email?></td>
             <td><?=get_client_services_no($c->client_id)?></td>
             <td><?=get_formatted_price(get_client_paid($c->client_id))?></td>
             <td><?=get_module_value($c->client_state,'state')?></td>
            </tr>
            <?php endforeach;?>
            <?php endif;?>
           </tbody>
          </table>
          <a href="<?=base_url()?>report/export_client_data?c=<?=implode(",",$ids)?>"
          class="btn btn-sm btn-primary">Export Whole Data</a>
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
