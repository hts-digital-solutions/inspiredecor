<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header">
 <div class="row">
  <div class="col-sm-12">
   <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
    <div class="panel-heading ui-sortable-handle">
     <div class="btn-group">
      <p>Client resource</p>
     </div>
    </div>
    <div class="panel-body">
     <div class="col-sm-12 col-md-12 col-xs-12">
      <div class="cards">
       <form action="" method="get">
       <div class="serach-lists">
        <div class="col-md-3">
         <div class="form-group">
          <select class="form-control" name="resource">
            <option value="">Select Resource</option>
            <?php $resource = get_module_values('lead_source')?>
            <?php if(isset($resource) && !empty($resource)):?>
            <?php foreach($resource as $r):?>
            <option 
            <?php echo isset($_GET['resource']) && $_GET['resource'] == base64_encode($r->lead_source_id)? 'selected':'' ?>
            value="<?=base64_encode($r->lead_source_id)?>"><?=$r->lead_source_name?></option>
            <?php endforeach;?>
            <?php endif;?>
          </select>
         </div>
        </div>
        <div class="col-md-3">
         <div class="form-group">
          <input type="text" name="crsrcdatef" id="crsrcdatef"
           value="<?php echo isset($_GET['crsrcdatef']) ? $_GET['crsrcdatef']: '' ?>"
          class="form-control" placeholder="Start Date" />
         </div>
        </div>
        <div class="col-md-3">
         <div class="form-group">
          <input type="text" name="crsrcdatet" id="crsrcdatet"
          value="<?php echo isset($_GET['crsrcdatet']) ? $_GET['crsrcdatet']: '' ?>"
          class="form-control" placeholder="End Date" />
         </div>
        </div>
        <div class="col-md-2">
         <div class="form-group">
          <button type="submit" class="btn btnss btn-success">Submit</button>
         </div>
        </div>
       </div>
       </form>
       <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div id="crsrcchart"></div>
        </div>
        <div class="card-headers">
         <div class="table-responsive">
          <table class="table table-bordered table-hover" id="crsrctable">
           <thead>
            <tr>
             <th>Month</th>
             <?php $resource = get_module_values('lead_source')?>
             <?php if(isset($resource) && !empty($resource)):?>
             <?php foreach($resource as $r):?>
             <?php if(isset($_GET['resource']) && $_GET['resource']==base64_encode($r->lead_source_id)):?>
             <th><?=$r->lead_source_name?></th>
             <?php elseif(isset($_GET['resource']) && $_GET['resource']==''|| !isset($_GET['resource'])):?>
             <th><?=$r->lead_source_name?></th>
             <?php endif;?>
             <?php endforeach;?>
             <?php endif;?>
             <th>Total</th>
            </tr>
           </thead>
           <tbody>
            <?php if(isset($cresource) && !empty($cresource)):?>
            <?php foreach($cresource as $k=>$v):?>
            <tr>
             <td><?=ucfirst($k)?></td>
             <?php $resource = get_module_values('lead_source')?>
             <?php if(isset($resource) && !empty($resource)):?>
             <?php  $totalI = $totalC = 0; foreach($resource as $r):?>
             <?php if(isset($_GET['resource']) && $_GET['resource']==base64_encode($r->lead_source_id)):?>
             <td><?="(".get_formatted_price($v['i'][$r->lead_source_name]).") ".$v['c'][$r->lead_source_name]?></td>
             <?php 
             $totalI += $v['i'][$r->lead_source_name]; 
             $totalC += $v['c'][$r->lead_source_name]; 
             ?>
             <?php elseif(isset($_GET['resource']) && $_GET['resource']=='' || !isset($_GET['resource'])):?>
             <td><?="(".get_formatted_price($v['i'][$r->lead_source_name]).") ".$v['c'][$r->lead_source_name]?></td>
             <?php
             $totalI += $v['i'][$r->lead_source_name]; 
             $totalC += $v['c'][$r->lead_source_name]; 
             ?>
             <?php endif;?>
             <?php endforeach;?>
             <?php endif;?>
             <td><?="(".get_formatted_price($totalI).") ".$totalC?></td>
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
    </div>
   </div>
  </div>
 </div>
</section>
