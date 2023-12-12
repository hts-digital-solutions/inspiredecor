<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
        <form class="row" style="margin-bottom:2px;">
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
               <label>From Date</label>
                <input type="date" name="from_date" onchange="this.form.submit();" value="<?=$_GET['from_date'] ?? ''?>" class="form-control"/>
           </div>
           <div class="col-md-3 form-group">
               <label>End Date</label>
                <input type="date" name="end_date" onchange="this.form.submit();" value="<?=$_GET['end_date'] ?? ''?>" class="form-control"/>
           </div>
       </form>
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
          <div class="panel-heading ui-sortable-handle">
               <div class="btn-group"><p>Work Status Report</p></div>           
            
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
                        <th>Date</th>
                        <th>Today</th>
                        <th>Tomorrow</th>
                        <th>Day After Tomorrow</th>
                        <!--<th><?= isset($_GET['date']) && !empty($_GET['date']) ? date('d-m-Y', strtotime($_GET['date'])) : date('d-m-Y')?></th>-->
                        <!--<th><?= isset($_GET['date']) && !empty($_GET['date']) ? date('d-m-Y', strtotime($_GET['date'] .' +1day')) : date('d-m-Y', strtotime('+1day'))?></th>-->
                        <!--<th><?= isset($_GET['date']) && !empty($_GET['date']) ? date('d-m-Y', strtotime($_GET['date'] .' +2day')) : date('d-m-Y', strtotime('+2day'))?></th>-->
                        
                        <th>Added By</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $ids=array(); if(isset($work_status) && !empty($work_status)):?>
                    <?php foreach($work_status as $p):?>
                    <?php array_push($ids, base64_encode($p->work_status_id)) ?>
                      <tr>
                        
                        <td><a href="<?=base_url()?>add-project/?edit=<?=base64_encode($p->project_id)?>">
                            <?=$p->project_name?>
                        </a></td>
                        <td><?=$p->client_name?></td>
                        <td><?=date('d-m-Y', strtotime($p->created))?></td>
                        <td>
                            <?=$p->work_status_today?>
                        </td>
                        <td>
                            <?=$p->work_status_tomorrow?>
                        </td>
                        <td>
                            <?=$p->day_after_status?>
                        </td>
                        <td><?=empty($p->created_by_id) ? 'Admin' : get_info_of('agent', 'agent_name', $p->created_by_id, 'agent_id') ?></td>
                        
                      </tr>
                    <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                  </table>
                  <a href="<?=base_url()?>report/export_work_status_data?<?= http_build_query($_GET)?>"
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