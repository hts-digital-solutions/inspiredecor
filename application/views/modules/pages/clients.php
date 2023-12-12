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
               <div class="btn-group"><p>Client </p></div>
                  <button type="button" style="float:right;color:#fff"; 
               class="btn btn-sm btn-primary">
               <a style="color:#fff"; href="<?=base_url()?>add-client">Add Client</a></button>
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
                    <input type="text" class="form-control" name="c_name"
                    placeholder="Client Name" value="<?php echo isset($_GET['c_name']) ? $_GET['c_name'] : ''; ?>"/>
                  </div>
                </div>
                <div class="col-md-2 pd-02">
                  <div class="form-group">
                    <input type="text" class="form-control" name="c_company"
                    placeholder="Company Name" value="<?php echo isset($_GET['c_company']) ? $_GET['c_company'] : ''; ?>" />
                  </div>
                </div>
                <div class="col-md-2 pd-02">
                  <div class="form-group">
                    <input type="text" class="form-control" name="c_mobile"
                    placeholder="Contact No" value="<?php echo isset($_GET['c_mobile']) ? $_GET['c_mobile'] : ''; ?>"/>
                  </div>
                </div>
                <div class="col-md-2 pd-02">
                  <div class="form-group">
                    <select name="product" class="form-control">
                        <option value="">Product/Service</option>
                        <?php $products = get_module_values('product_service');?>
                        <?php if(isset($products) && !empty($products)):?>
                        <?php foreach($products as $p):?>
                        <option 
                        <?php echo isset($_GET['product']) && $_GET['product']==base64_encode($p->product_service_id)
                        ?'selected': ''; ?>
                        value="<?=base64_encode($p->product_service_id)?>"><?=$p->product_service_name?></option>
                        <?php endforeach;?>
                        <?php endif;?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2 pd-02" style="float:right;">
                  <div class="form-group">
                    <button type="submit" class="btn btnss btn-success">Submit</button>
                  </div>
                </div>
                </form>
                <div class="table-responsive mob-bord">
                  <table class="table table-bordered table-hover" id="clientTable">
                    <thead>
                      <tr>
                        <th><input type="checkbox" class="check"/></th>
                        <th>Full Name</th>
                        <th>User ID</th>
                        <th>Company Name</th>
                        <?php if(auth_id() == 0):?>
                        <th>Contact No</th>
                        <th>Reference</th>
                        <?php endif;?>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $ids=array(); if(isset($clients) && !empty($clients)):?>
                    <?php foreach($clients as $c):?>
                    <?php array_push($ids, base64_encode($c->client_id)) ?>
                      <tr>
                        <td class="list-check">
                            <input type="checkbox" class="checkme" name="radioGroup" value="<?=base64_encode($c->client_id)?>" />
                        </td>
                        <td><a href="<?=base_url()?>add-client/?edit=<?=base64_encode($c->client_id)?>">
                            <?=$c->client_name?>
                        </a></td>
                        <td><?=$c->client_uid?></td>
                        <td><?=$c->client_company?></td>
                        <?php if(auth_id() == 0):?>
                        <td><?=$c->client_mobile?></td>
                        
                        <td>
                            <?php 
                            // if(get_client_services_name($c->client_id)[0] != '-' && count(get_client_services_name($c->client_id)) > 0) {
                            //     echo wordwrap(implode(', ', get_client_services_name($c->client_id)), 30, "<br>\n");
                            // } else {
                            //     echo '-';
                            // }
                            
                            echo $c->reference_name ? $c->reference_name . '('. $c->reference_contact_number . ')' : '';
                            ?>
                        </td>
                        <?php endif;?>
                        <td>
                            <?php if($c->client_status == '1'): ?>
                            <span class="label-success label label-default">Active</span>
                            <?php else: ?>
                            <span class="label-danger label label-default">In-active</span>
                            <?php endif;?>
                        </td>
                        <td>
                          <a href="<?=base_url()?>add-client/?edit=<?=base64_encode($c->client_id)?>" 
                          class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                          <?php if(auth_id() == 0):?>
                          <a onclick="return confirm('Data will be lost. Do you want to continue?');"
                          href="<?=base_url()?>client/action?delete=<?=base64_encode($c->client_id)?>" 
                          class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                          <?php endif;?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                  </table>
                  <?php if(auth_id() == 0):?>
                  <button type="button" onclick="deleteSelected('clients');" class="btn btn-danger">Delete</button>
                  <?php endif;?>
                  <a href="<?=base_url()?>report/export_client_data?c=<?=implode(",",$ids)?>"
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
<p class="badge badge-danger">Client access denied.</p>
<?php endif;?>