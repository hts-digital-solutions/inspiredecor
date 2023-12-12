<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<?php if(auth_id()==0):?>
<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
          <div class="panel-heading ui-sortable-handle">
               <div class="btn-group"><p>Site Issue Category</p></div>
                  <div style="float:right;">
                      
                      <button type="button" style="color:#fff;margin-left:5px;" 
               class="btn btn-sm btn-primary">
               <a style="color:#fff"; href="<?=base_url()?>add-site-issue-category">Add Site Issue Category</a></button>  
               <a style="float:right;margin-left:10px;" href="<?=base_url()?>report/export_site_issue_category_data?<?= http_build_query($_GET)?>"
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
                        <th>Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $ids=array(); if(isset($categories) && !empty($categories)):?>
                    <?php foreach($categories as $p):?>
                    <?php array_push($ids, base64_encode($p->issue_category_id)) ?>
                      <tr>
                        <td><?=$p->name?></td>
                        <td>
                          <a href="<?=base_url()?>add-site-issue-category/?edit=<?=base64_encode($p->issue_category_id)?>" 
                          class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                          <a onclick="return confirm('Data will be lost. Do you want to continue?');"
                          href="<?=base_url()?>project/del_site_issue_category?d=<?=base64_encode($p->issue_category_id)?>"
                          class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                  </table>
                  <a href="<?=base_url()?>report/export_site_issue_category_data?<?= http_build_query($_GET)?>"
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
<p>Access denied</p>
<?php endif;?>