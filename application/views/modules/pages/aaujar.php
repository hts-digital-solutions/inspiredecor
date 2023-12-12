<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
        <form class="row" style="margin-bottom:2px;">
            <?php if(auth_id() == 0):?>
           <div class="col-md-3 form-group">
               <label>Business Associate</label>
               <select name="agent" class="form-control" onchange="this.form.submit();">
                   <option value="">Select Business Associate</option>
                   <option value="0">Admin</option>
                   <?php foreach($agents as $a):?>
                    <option value="<?=$a->agent_id?>" <?=isset($_GET['agent']) && $_GET['agent'] === $a->agent_id ? 'selected' : ''?>><?=$a->agent_name?></option>
                   <?php endforeach;?>
               </select>
           </div>
           <?php endif;?>
           <div class="col-md-3 form-group">
               <label>Date</label>
                <input type="date" name="date" onchange="this.form.submit();" value="<?=$_GET['date'] ?? ''?>" class="form-control"/>
           </div>
           <div class="col-md-3 form-group">
               <label>Tool</label>
               <select class="form-control" id="tool_name" name="tool_name" onchange="this.form.submit();">
                  <option value="">Select Tool</option>
                  <?php foreach($auzaar_names as $c):?>
                  <option value="<?=strtolower($c->name)?>" <?php echo isset($_GET['tool_name']) && $_GET['tool_name'] == strtolower($c->name) ? 'selected':'';?>><?=$c->name?></option>
                  <?php endforeach;?>
              </select>
           </div>
       </form>
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
          <div class="panel-heading ui-sortable-handle">
               <div class="btn-group"><p>Tools</p></div>
                  <div style="float:right;">
                      
                      <button type="button" style="color:#fff;margin-left:5px;" 
               class="btn btn-sm btn-primary">
               <a style="color:#fff"; href="<?=base_url()?>add-auzaar">Add Tool</a></button>  
               <a style="float:right;margin-left:10px;" href="<?=base_url()?>report/export_auzaar_data?<?= http_build_query($_GET)?>"
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
                        <th>Business Associate Name</th>
                        <th>Tool</th>
                        <th>Total Qty</th>
                        <th>Used Qty</th>
                        <th>Transferred Qty</th>
                        <th>Closing Qty</th>
                        <th style="width:120px;">Date</th>
                        <th style="width:120px;">Details</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $ids=array(); if(isset($auzaars) && !empty($auzaars)):?>
                    <?php foreach($auzaars as $p):?>
                    <?php array_push($ids, base64_encode($p->aaujar_id)) ?>
                      <tr>
                        <td><?=$p->agent_name?></td>
                        <td><?=$p->tool_name?></td>                        
                        <td><?=$p->total_qty?></td>
                        <td><?=$p->used_qty?></td>
                        <td><?=$p->transfer_qty?></td>
                        <td><?=$p->closing_qty?></td>
                        <td><?=date('d-m-Y', strtotime($p->created))?></td>
                        <td><?=$p->details?></td>
                        <td>
                            <?php if(auth_id() == 0 || date('Y-m-d', strtotime($p->created)) === date('Y-m-d')):?>
                          <a href="<?=base_url()?>add-auzaar/?edit=<?=base64_encode($p->aaujar_id)?>" 
                          class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                          <?php endif;?>
                          <?php if(auth_id() == 0 || date('Y-m-d', strtotime($p->created)) === date('Y-m-d')):?>
                          <a onclick="return confirm('Data will be lost. Do you want to continue?');"
                          href="<?=base_url()?>project/del_auzaar?d=<?=base64_encode($p->aaujar_id)?>"
                          class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                          <?php endif;?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                  </table>
                  <a href="<?=base_url()?>report/export_auzaar_data?<?= http_build_query($_GET)?>"
          class="btn btn-primary">Export Whole Data</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>