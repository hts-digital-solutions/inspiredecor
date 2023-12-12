<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
        <form class="row" style="margin-bottom:2px;">
            <?php if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
&& $_SESSION['roll']==='admin'):?>
           <div class="col-md-3 form-group">
               <label>Business Associate</label>
               <select name="agent" class="form-control" onchange="this.form.submit();">
                   <option value="">Select Business Associate</option>
                   <?php foreach($agents as $a):?>
                    <option value="<?=$a->agent_id?>" <?=isset($_GET['agent']) && $_GET['agent'] === $a->agent_id ? 'selected' : ''?>><?=$a->agent_name?></option>
                   <?php endforeach;?>
               </select>
           </div>
           <?php endif;?>
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
               <select name="project" class="form-control select2" onchange="this.form.submit();">
                   <option value="">Select Project</option>
                   <?php foreach($projects as $p):?>
                   <?php if(isset($_GET['client']) && $_GET['client'] === $p->client_id ):?>
                    <option value="<?=$p->project_id?>" <?=isset($_GET['project']) && $_GET['project'] === $p->project_id ? 'selected' : ''?>><?=$p->project_name?></option>
                   <?php endif;?>
                   <?php endforeach;?>
               </select>
           </div>
           <div class="col-md-3">
              <div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="category_id" id="category_id" onchange="this.form.submit();">
                      <option value="">Select</option>
                      <?php foreach($categories as $category):?>
                      <option value="<?=$category->issue_category_id?>"
                      <?=isset($_GET['category_id']) && $_GET['category_id'] === $category->issue_category_id ? 'selected' : ''?>
                      ><?=$category->name?></option>
                      <?php endforeach;?>
                  </select>
              </div>
          </div>
           <div class="col-md-3 form-group">
               <label>Date</label>
               <input type="date" value="<?=$_GET['date'] ?? ''?>" class="form-control" id="date" name="date" onchange="this.form.submit();" />
           </div>
       </form>
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
          <div class="panel-heading ui-sortable-handle">
               <div class="btn-group"><p>Site Issues</p></div>
                  <button type="button" style="float:right;color:#fff"; 
               class="btn btn-sm btn-primary">
               <a style="color:#fff"; href="<?=base_url()?>add-burning-report">Add Site Issues</a></button>            
            <a style="margin-right:10px;float:right;" href="<?=base_url()?>report/export_burning_report_data?<?= http_build_query($_GET)?>"
          class="btn btn-sm btn-primary">Export Whole Data</a>
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
                        <th>Business Associate Name</th>
                        <th>Client Name</th>
                        <th>Project Name</th>
                        <th>Category</th>
                        <th>Report</th>
                        <th>Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $ids=array(); if(isset($burning_reports) && !empty($burning_reports)):?>
                    <?php foreach($burning_reports as $p):?>
                    <?php array_push($ids, base64_encode($p->burning_report_id)) ?>
                      <tr>
                        <td><?=$p->agent_id==0 ? 'admin' : get_info_of('agent', 'agent_name', $p->agent_id, 'agent_id')?></td>
                        <td><?=$p->client_name?></td>
                        <td><?=$p->project_name?></td>
                        <td><?=$p->category_name?></td>
                        <td><?=$p->text?></td>
                        <td><?=date('d-m-Y', strtotime($p->created))?></td>
                        <td>
                            <?php if((isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true) || date('Y-m-d', strtotime($p->created)) == date('Y-m-d')):?>
                          <a href="<?=base_url()?>add-burning-report/?edit=<?=base64_encode($p->burning_report_id)?>" 
                          class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                          <a onclick="return confirm('Data will be lost. Do you want to continue?');"
                          href="<?=base_url()?>project/del_burning_report?d=<?=base64_encode($p->burning_report_id)?>" 
                          class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                          <?php endif;?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                  </table>
                  <a href="<?=base_url()?>report/export_burning_report_data?<?= http_build_query($_GET)?>"
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