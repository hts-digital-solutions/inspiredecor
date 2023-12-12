<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
&& $_SESSION['roll']==='admin'):?>
<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
        <form class="row" style="margin-bottom:2px;">
           
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
               <label>Project Status</label>
               <select class="form-control" id="project_status" name="project_status" onchange="this.form.submit();">
                  <option value="">Select Project Status</option>
                  <option value="1" <?php echo isset($_GET['project_status']) && $_GET['project_status'] == 1 ? 'selected':'';?>>Active</option>
                  <option value="0" <?php echo isset($_GET['project_status']) && $_GET['project_status'] == 0 ? 'selected':'';?>>Completed</option>
              </select>
           </div>
       </form>
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
          <div class="panel-heading ui-sortable-handle">
               <div class="btn-group"><p>Projects</p></div>
                  <button type="button" style="float:right;color:#fff"; 
               class="btn btn-sm btn-primary">
               <a style="color:#fff"; href="<?=base_url()?>add-project">Add Project</a></button>            
                <a style="float:right;margin-right:10px;" href="<?=base_url()?>report/export_project_data?<?= http_build_query($_GET)?>"
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
                        <th>Project Name</th>
                        <th>Client Name</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $ids=array(); if(isset($projects) && !empty($projects)):?>
                    <?php foreach($projects as $p):?>
                    <?php array_push($ids, base64_encode($p->project_id)) ?>
                      <tr>
                        <!--<td class="list-check">-->
                        <!--    <input type="checkbox" class="checkme" name="radioGroup" value="<?=base64_encode($p->project_id)?>" />-->
                        <!--</td>-->
                        <td><a href="<?=base_url()?>add-project/?edit=<?=base64_encode($p->project_id)?>">
                            <?=$p->project_name?>
                        </a></td>
                        <td><?=$p->client_name?></td>
                        
                        <td>
                            <?php if($p->status == '1'): ?>
                            <span class="label-info label label-default">Active</span>
                            <?php else: ?>
                            <span class="label-success label label-default">Completed</span>
                            <?php endif;?>
                        </td>
                        <td>
                          <a href="<?=base_url()?>add-project/?edit=<?=base64_encode($p->project_id)?>" 
                          class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                          <a onclick="return confirm('Data will be lost. Do you want to continue?');"
                          href="<?=base_url()?>project/del_project?d=<?=base64_encode($p->project_id)?>" 
                          class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                  </table>
          <!--        <button type="button" onclick="deleteSelected('projects');" class="btn btn-danger">Delete</button>-->
                  <a href="<?=base_url()?>report/export_project_data?<?= http_build_query($_GET)?>"
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
<?php else:?>
<p class="badge badge-danger">Projects access denied.</p>
<?php endif;?>