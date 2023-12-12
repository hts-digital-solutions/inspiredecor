<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
&& $_SESSION['roll']==='admin' || $_SESSION['roll']!=='admin'
&& $_SESSION['ca']==='yes'):?>
<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
          <div class="panel-heading ui-sortable-handle">
               <div class="btn-group"><p>Vendor </p></div>
                  <button type="button" style="float:right;color:#fff"; 
               class="btn btn-sm btn-primary">
               <a style="color:#fff"; href="<?=base_url()?>add-vendor">Add Vendor</a></button>            
            
            </div>
       
        <div class="panel-body">
          <div class="row">
            <div class="cards">
              <div class="card-headers">
                <div class="col-md-2">
                  <div class="searchbuy">
                  <button type="button" id="advS" class="btns exports"><i class="fa fa-search" aria-hidden="true"></i> Advance</button>
                  </div>
                </div>
                <form action="" method="get" class="advS" <?php echo isset($_GET) && !empty($_GET) ? '' : 'style="display:none;"';?>>
                <div class="col-md-2 pd-02">
                  <div class="form-group">
                    <input type="text" class="form-control" name="v_name"
                    placeholder="Vendor Name" value="<?php echo isset($_GET['v_name']) ? $_GET['v_name'] : ''; ?>"/>
                  </div>
                </div>
                <div class="col-md-2 pd-02">
                  <div class="form-group">
                    <input type="text" class="form-control" name="v_company"
                    placeholder="Company Name" value="<?php echo isset($_GET['v_company']) ? $_GET['v_company'] : ''; ?>" />
                  </div>
                </div>
                <div class="col-md-2 pd-02">
                  <div class="form-group">
                    <input type="text" class="form-control" name="v_mobile"
                    placeholder="Contact No" value="<?php echo isset($_GET['v_mobile']) ? $_GET['v_mobile'] : ''; ?>"/>
                  </div>
                </div>
                <div class="col-md-2 pd-02" style="float:right;">
                  <div class="form-group">
                    <button type="submit" class="btn btnss btn-success">Submit</button>
                  </div>
                </div>
                </form>
                <div class="table-responsive mob-bord">
                  <table class="table table-bordered table-hover" id="vendorTable">
                    <thead>
                      <tr>
                        <!--<th><input type="checkbox" class="check"/></th>-->
                        <th>Name</th>
                        <th>Number</th>
                        <th>Quoted Rate</th>
                        <th>Final Rate</th>
                        <th>Vendor Type</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $ids=array(); if(isset($vendors) && !empty($vendors)):?>
                    <?php foreach($vendors as $c):?>
                    <?php array_push($ids, base64_encode($c->vendor_id)) ?>
                      <tr>
                        <!--<td class="list-check">-->
                        <!--    <input type="checkbox" class="checkme" name="radioGroup" value="<?=base64_encode($c->vendor_id)?>" />-->
                        <!--</td>-->
                        <td><a href="<?=base_url()?>add-vendor/?edit=<?=base64_encode($c->vendor_id)?>">
                            <?=$c->vendor_name?>
                        </a></td>
                        <td><?=$c->vendor_mobile?></td>
                        <td><?=$c->quoted_rate?></td>
                        <td><?=$c->final_rate?></td>
                        <td><?=$c->vendor_type?></td>
                        <td>
                            <?php if($c->vendor_status == '1'): ?>
                            <span class="label-success label label-default">Active</span>
                            <?php else: ?>
                            <span class="label-danger label label-default">In-active</span>
                            <?php endif;?>
                        </td>
                        <td>
                          <a href="<?=base_url()?>add-vendor/?edit=<?=base64_encode($c->vendor_id)?>" 
                          class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                          <?php if(auth_id() == 0):?>
                          <a onclick="return confirm('Data will be lost. Do you want to continue?');"
                          href="<?=base_url()?>vendor/action?delete=<?=base64_encode($c->vendor_id)?>" 
                          class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                          <?php endif;?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                  </table>
                  <?php //if(auth_id() == 0):?>
          <!--        <button type="button" onclick="deleteSelected('vendors');" class="btn btn-danger">Delete</button>-->
          <!--        <?php //endif;?>-->
          <!--        <a href="<?=base_url()?>report/export_vendor_data?c=<?=implode(",",$ids)?>"-->
          <!--class="btn btn-primary">Export Whole Data</a>-->
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
<p class="badge badge-danger">Vendor access denied.</p>
<?php endif;?>