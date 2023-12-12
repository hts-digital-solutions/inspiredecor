<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>
<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
        <form class="row filters">
           <?php 
if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
&& $_SESSION['roll']==='admin'):?>
           <div class="col-md-3 form-group">
               <label>Business Associate</label>
               <select name="agent" class="form-control" onchange="this.form.submit();">
                   <option value="">Select Business Associate</option>
                   <?php foreach($agents as $c):?>
                    <option value="<?=$c->agent_id?>" <?=isset($_GET['agent']) && $_GET['agent'] === $c->agent_id ? 'selected' : ''?>><?=$c->agent_name?></option>
                   <?php endforeach;?>
               </select>
           </div>
           <?php endif;?>
           <div class="col-md-3 form-group">
               <label>Date</label>
               <input type="date" class="form-control" name="date" onchange="this.form.submit();" value="<?=$_GET['date'] ?? ''?>"/>
           </div>
       </form>
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
          <div class="panel-heading ui-sortable-handle">
               <div class="btn-group"><p>Cash Flow Report</p></div>   
               <?php if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
&& $_SESSION['roll']==='admin'):?>
                <a style="float:right;" href="<?=base_url()?>report/update_closing_balance?date=<?= $_GET['date'] ?? date('Y-m-d') ?>">Update Closing Balance</a>
                <?php else:?>
                <!--<a style="float:right;" href="<?=base_url()?>home/update_closing_balance?date=<?= $_GET['date'] ?? date('Y-m-d') ?>">Update Closing Balance</a>-->
                <?php endif;?>
                <a style="float:right;margin-right:10px;" href="<?=base_url()?>report/export_petty_cash_data?<?=http_build_query($_GET)?>"
          class="btn btn-primary">Export Whole Data</a>
            </div>
       
        <div class="panel-body">
          <div class="row">
            <div class="cards">
              <div class="card-headers">
                <div class="table-responsive mob-bord">
                  <table class="table table-bordered table-hover" id="projectTable">
                    <thead>
                      <tr>
                        <th>Business Associate</th>
                        <th>Date</th>
                        <th>Opening Balance</th>
                        <th>Total Received</th>
                        <th>Total Expense</th>
                        <th>Received From</th>
                        <th>Closing Balance</th>
                        <?php if($this->uri->segment(1) === 'petty-cash'):?>
                        <th>Action</th>
                        <?php endif;?>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $ids=array(); if(isset($petty_cash) && !empty($petty_cash)):?>
                    <?php foreach($petty_cash as $p):?>
                    <?php array_push($ids, base64_encode($p->petty_cash_id)) ?>
                      <tr>
                        <td><?=get_info_of('agent', 'agent_name', $p->agent_id, 'agent_id')?></td>
                        <td><?=date('d-m-Y', strtotime($p->created))?></td>
                        <td><?=get_formatted_price($p->opening_balance)?></td>
                        <td><?=get_formatted_price($p->total_received)?></td>
                        <td><?=get_formatted_price($p->total_expense)?></td>
                        <td>
                            <?php $receiveds = json_decode($p->received_history); ?>
                            <?php if(is_array($receiveds)):?>
                            <?php foreach($receiveds as $r):?>
                                <p><strong>From:</strong> <?=$r->from ?? ''?> | <strong>Amount:</strong> <?=get_formatted_price($r->amount) ?? ''?> | <strong>Type:</strong> <?=$r->type ?? ''?></p>
                            <?php endforeach;?>
                            <?php endif;?>
                        </td>
                        <td style="<?=$p->closing_balance<0 ? 'background:red;color:white;' : ($p->closing_balance > 0 ? 'color:white;background:green;' : '')?>"><?=get_formatted_price($p->closing_balance)?></td>
                        <?php if($this->uri->segment(1) === 'petty-cash'):?>
                        <td>
                            <?php if((isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true) || date('Y-m-d', strtotime($p->created)) == date('Y-m-d')):?>
                            <a href="<?=base_url()?>add-petty-cash/?edit=<?=base64_encode($p->petty_cash_id)?>" 
                          class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                          <a onclick="return confirm('Data will be lost. Do you want to continue?');"
                          href="<?=base_url()?>project/del_petty_cash?d=<?=base64_encode($p->petty_cash_id)?>" 
                          class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                          <?php endif;?>
                        </td>
                        <?php endif;?>
                      </tr>
                    <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                  </table>
                  <a href="<?=base_url()?>report/export_petty_cash_data?<?=http_build_query($_GET)?>"
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