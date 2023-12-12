<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header">
 <div class="row">
  <div class="col-sm-12">
   <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
    <div class="panel-heading ui-sortable-handle">
     <div class="col-md-6">
      <div class="btn-group">Services</div>
     </div>
    </div>
    <div class="panel-body">
     <div class="col-sm-12 col-md-12 col-xs-12">
      <div class="cards">
       <form action="" method="get">
       <div class="serach-lists">
        <div class="col-md-12">
         <div class="col-md-3 form-appoin">
          <input type="checkbox" name="client_id" id="client_id" value="yes" 
          <?php echo isset($_GET['client_id']) && $_GET['client_id']=='yes' ? 'checked' : ''; ?>/>
          <label for="client_id" class="lable">Client ID</label>
         </div>
         <div class="col-md-3 form-appoin">
          <input type="checkbox" name="client_name" id="client_name" value="yes" 
          <?php echo isset($_GET['client_name']) && $_GET['client_name']=='yes' ? 'checked' : ''; ?>/>
          <label for="client_name" class="lable">Client Name</label>
         </div>
         <div class="col-md-3 form-appoin">
          <input type="checkbox" name="service_name" id="service_name" value="yes" 
          <?php echo isset($_GET['service_name']) && $_GET['service_name']=='yes' ? 'checked' : ''; ?>/>
          <label for="service_name" class="lable">Service Name</label>
         </div>
         <div class="col-md-3 form-appoin">
          <input type="checkbox" name="payment" id="payment" value="yes" 
          <?php echo isset($_GET['payment']) && $_GET['payment']=='yes' ? 'checked' : ''; ?>/>
          <label for="payment" class="lable">First Payment</label>
         </div>
         <div class="col-md-3 form-appoin">
          <input type="checkbox" name="recurring" id="recurring" value="yes" 
          <?php echo isset($_GET['recurring']) && $_GET['recurring']=='yes' ? 'checked' : ''; ?>/>
          <label for="recurring" class="lable">Recurring Payment</label>
         </div>
         <div class="col-md-3 form-appoin">
          <input type="checkbox" name="billing_cycle" id="billing_cycle" value="yes" 
          <?php echo isset($_GET['billing_cycle']) && $_GET['billing_cycle']=='yes' ? 'checked' : ''; ?>/>
          <label for="billing_cycle" class="lable">Billing cycle</label>
         </div>

         <div class="col-md-3 form-appoin">
          <input type="checkbox" name="next_due_date" id="add_date" value="yes" 
          <?php echo isset($_GET['next_due_date']) && $_GET['next_due_date']=='yes' ? 'checked' : ''; ?>/>
          <label for="add_date" class="lable">Due date</label>
         </div>

         <div class="col-md-3 form-appoin">
          <input type="checkbox" name="pay_method" id="pay_method" value="yes" 
          <?php echo isset($_GET['pay_method']) && $_GET['pay_method']=='yes' ? 'checked' : ''; ?>/>
          <label for="pay_method" class="lable">Payment Method</label>
         </div>

         <div class="col-md-3 form-appoin">
          <input type="checkbox" name="bill_status" id="bill_status" value="yes" 
          <?php echo isset($_GET['bill_status']) && $_GET['bill_status']=='yes' ? 'checked' : ''; ?>/>
          <label for="bill_status" class="lable">Status</label>
         </div>
         
         <div class="col-md-12">
          <div class="form-group" style="float:right;">
           <button type="submit" class="btn btnss btn-success">Submit</button>
          </div>
         </div>
        </div>
       </div>
       </form>
       <br/>
       <table class="table" id="srTable">
           <thead>
               <?php if(isset($_GET) && count($_GET) > 0): ?>
               <tr>
               <th>#</th>
               <?php foreach($_GET as $k=>$v):?>
               <?php if($k == 'next_due_date'): ?>
               <th><?=ucfirst('due Date')?></th>
               <?php else: ?>
               <th><?=ucfirst(str_replace("_"," ",$k))?></th>
               <?php endif; ?>
               <?php endforeach;?>
               </tr>
               <?php else:?>
               <tr>
                <th>Select field given above</th>
               </tr>
               <?php endif;?>
           </thead>
           <tbody>
               <?php if(isset($services) && !empty($services)): ?>
               <?php $i=1; foreach($services as $s):?>
               <tr>
                   <td><?=$i?></td>
                   <?php foreach($_GET as $k=>$v):?>
                   <?php $k = ($k=='service_name') ? 'product_service_name' : $k;?>
                   <?php $k = ($k=='client_id') ? 'client_uid' : $k;?>
                   <td><?php echo ($k=='next_due_date') ? ($s->bill_status == 'paid' ? get_formatted_date($s->next_due_date) : get_formatted_date($s->add_date)) : 
                   (($k=='payment') ? get_formatted_price($s->$k) : 
                   (($k=='recurring') ? get_formatted_price($s->$k ):
                   ($k=='client_uid' ? '<a target="_blank" href="'.base_url('add-client?edit='.
                   base64_encode(get_info_of('client','client_id',$s->$k,'client_uid'))
                   ).'">'.$s->$k.'</a>' : ucfirst($s->$k))))?></td>
                   <?php endforeach;?> 
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
 </div>
</section>
