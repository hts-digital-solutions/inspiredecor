<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header">
 <div class="row">
  <div class="col-sm-12">
   <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
    <div class="panel-heading ui-sortable-handle">
     <div class="btn-group">
      <p>Employee</p>
     </div>
    </div>
    <div class="panel-body">
     <div class="col-sm-12 col-md-12 col-xs-12">
      <div class="cards">
       <div class="serach-lists">
        <form action="" method="get">
        <div class="row">
          <div class="col-md-4 pd-02">
           <div class="form-group text-center">
            <select class="form-control" name="ps">
             <option value="">Select Product Service</option>
             <?php $products = get_module_values('product_service'); ?>
             <?php if(isset($products) && !empty($products)):?>
             <?php foreach($products as $p):?>
             <option 
             <?php echo isset($_GET['ps']) && $_GET['ps'] == base64_encode($p->product_service_id)? 'selected':'' ?>
             value="<?=base64_encode($p->product_service_id)?>"><?=$p->product_service_name?></option>
             <?php endforeach;?>
             <?php endif;?>
            </select>
           </div>
          </div>
          <div class="col-md-4 pd-02">
           <div class="form-group">
            <select class="form-control" name="employee">
             <option value="">Select Employee</option>
             <?php $agents = get_module_values('agent'); ?>
             <?php if(isset($agents) && !empty($agents)):?>
             <?php foreach($agents as $a):?>
             <option 
             <?php echo isset($_GET['employee']) && $_GET['employee'] == base64_encode($a->agent_id)? 'selected':'' ?>
             value="<?=base64_encode($a->agent_id)?>"><?=$a->agent_name?></option>
             <?php endforeach;?>
             <?php endif;?>
            </select>
           </div>
          </div>
          <div class="col-md-4 pd-02">
           <div class="form-group">
            <select class="form-control" name="status">
             <option value="">Select Status</option>
             <?php $status = get_module_values('status'); ?>
             <?php if(isset($status) && !empty($status)):?>
             <?php foreach($status as $s):?>
             <option 
             <?php echo isset($_GET['status']) && $_GET['status'] == $s->status_id? 'selected':'' ?>
             value="<?=$s->status_id?>"><?=$s->status_name?></option>
             <?php endforeach;?>
             <?php endif;?>
            </select>
           </div>
          </div>
          <div class="col-md-3 pd-02">
           <div class="form-group">
            <input type="text" name="erdatef" id="erdatef" 
            value="<?php echo isset($_GET['erdatef']) ? $_GET['erdatef']: '' ?>"
            class="form-control" placeholder="Start Date" />
           </div>
          </div>
          <div class="col-md-3 pd-02">
           <div class="form-group">
            <input type="text" name="erdatet" id="erdatet"
            value="<?php echo isset($_GET['erdatet']) ? $_GET['erdatet']: '' ?>"
            class="form-control" placeholder="End Date" />
           </div>
          </div>
          <div class="col-md-2">
           <div class="form-group">
            <button type="submit" style="float:right;"
            class="btn btn-sm btn-success form-control">Submit</button>
           </div>
          </div>
        </div>
        </form>
       </div>
       <?php if(isset($_GET) && count($_GET) == 0):?>
       <div class="row">
           <div class="card-body">
               <div id="erchart"></div>
           </div>
       </div>
       <?php endif;?>
       <div class="row">
        <div class="card-headers">
         <?php if(isset($_GET) && count($_GET) > 0):?>
         <div class="table-responsive">
          <table class="table table-bordered table-hover" id="ertable">
           <thead>
            <tr>
             <th>Client Name</th>
             <th>Product Services</th>
             <th>Agent Name</th>
             <th>Status</th>
             <th>Price</th>
            </tr>
           </thead>
           <tbody>
            <?php $t=0; if(isset($ereport) && !empty($ereport)):?>
            <?php foreach($ereport as $er):?>
            <tr>
             <?php if(strtolower(get_module_value($er->status,'status'))!='won'):?>
             <td><a target="_blank" href="<?=base_url()?>followup?lead=?<?=base64_encode($er->lead_id)?>"><?=$er->full_name;?></a></td>
             <?php else:?>
             <td><a target="_blank" 
             href="<?=base_url()?>add-client?edit=?<?=base64_encode(get_info_of('client','client_id',$er->email_id,'client_email'))?>"><?=$er->full_name;?></a></td>
             <?php endif;?>
             <td><?=get_module_value($er->service,'product_service')?></td>
             <td><?=get_module_value($er->assign_to_agent,'agent')?></td>
             <td><?=get_module_value($er->status,'status')?></td>
             <?php if(strtolower(get_module_value($er->status,'status'))=='won'):?>
             <?php $t += get_lead_total($er->service); ?>
             <td><?=get_formatted_price(get_lead_total($er->service))?></td>
             <?php else:?>
             <?php $t += 0; ?>
             <td><?=get_formatted_price(0)?></td>
             <?php endif;?>
            </tr>
            <?php endforeach;?>
            <?php endif;?>
            <tr>
             <th>Total</th>
             <td></td>
             <td></td>
             <td></td>
             <th><?=get_formatted_price($t)?></th>
            </tr>
           </tbody>
          </table>
         </div>
         <?php else:?>
         <?php
         $d = isset($ereport['d']) ? $ereport['d']: array();
         $w = isset($ereport['w']) ? $ereport['w']: array();
         $m = isset($ereport['m']) ? $ereport['m']: array();
         $y = isset($ereport['y']) ? $ereport['y']: array();
         ?>
         <div class="table-responsive">
          <table class="table table-bordered table-hover" id="ertable">
           <thead>
            <tr>
             <th>Employee Name</th>
             <th>Daily</th>
             <th>Weekly</th>
             <th>Monthly</th>
             <th>Yearly</th>
            </tr>
           </thead>
           <tbody>
            <?php if(isset($d) && !empty($d)):?>
            <?php foreach($d as $k=>$v):?>
            <tr>
             <td><?=$k?></td>
             <td><?= get_formatted_price($v)?></td>
             <td><?= get_formatted_price($w[$k])?></td>
             <td><?= get_formatted_price($m[$k])?></td>
             <td><?= get_formatted_price($y[$k])?></td>
            </tr>
            <?php endforeach;?>
            <?php endif;?>
           </tbody>
          </table>
         </div>
         <?php endif;?>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</section>
