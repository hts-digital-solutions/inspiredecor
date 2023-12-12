<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
        <div class="panel-heading ui-sortable-handle">
          <div class="col-md-6">
            <div class="btn-group">Income Report</div>
          </div>
        </div>
        <div class="panel-body">
          <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="cards">
              <div class="serach-lists" style="padding:0px;">
                <form action="" method="get">
                <div class="col-md-3">
                  <div class="form-group">
                    <select class="form-control" name="income_type">
                      <option value="">Select Type</option>
                      <option value="all"
                      <?php echo isset($_GET['income_type']) && $_GET['income_type']== 'all' ? 'selected': '';?>
                      >All</option>
                      <option value="fresh"
                      <?php echo isset($_GET['income_type']) && $_GET['income_type']== 'fresh' ? 'selected': '';?>
                      >Fresh</option>
                      <option value="client"
                      <?php echo isset($_GET['income_type']) && $_GET['income_type']== 'client' ? 'selected': '';?>
                      >Client</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <select class="form-control" name="product">
                      <option value="">Select product</option>
                      <?php if(isset($ps) && !empty($ps)): ?>
                      <?php foreach($ps as $p):?>
                      <option 
                      <?php echo isset($_GET['product']) && $_GET['product']== base64_encode($p->product_service_id)
                      ? 'selected': '';?>
                      value="<?=base64_encode($p->product_service_id)?>"><?=$p->product_service_name?></option>
                      <?php endforeach;?>
                      <?php endif;?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <select class="form-control" name="employee">
                      <option value="">Select Employee</option>
                      <?php if(isset($agent) && !empty($agent)): ?>
                      <?php foreach($agent as $a):?>
                      <option 
                      <?php echo isset($_GET['employee']) && $_GET['employee']== base64_encode($a->agent_id)
                      ? 'selected': '';?>
                      value="<?=base64_encode($a->agent_id)?>"><?=$a->agent_name?></option>
                      <?php endforeach;?>
                      <?php endif;?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input id="irdatef" name="irdatef" placeholder="Choose Date From"
                    type="text" class="form-control" autocomplete="off"
                    value="<?php echo isset($_GET['irdatef']) ? $_GET['irdatef'] : '';?>"
                    />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input id="irdatet" name="irdatet" placeholder="Choose Date To"
                    type="text" class="form-control" autocomplete="off"
                    value="<?php echo isset($_GET['irdatet']) ? $_GET['irdatet'] : '';?>"
                    />
                  </div>
                </div>
                <div class="col-md-2 col-sm-12">
                  <div class="form-group">
                    <button type="submit" class="btn btn-success form-control">Submit</button>
                  </div>
                </div>
                </form>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="panel panel-bd lobidisable">
                    <div class="panel-body">
                      <div id="irchart" height="200"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.row -->
              <div class="card-headers">
                <div class="table-responsive mob-bord">
                  <table class="table table-bordered table-hover" id="irtable">
                    <thead>
                      <tr>
                        <th>Month</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $total = 0;?>
                      <?php if(isset($ireport['a']) && !empty($ireport['a'])):?>
                      <?php foreach($ireport['a'] as $k=>$v):?>
                      <tr>
                        <td><?=ucfirst($k)?></td>
                        <td><?=get_formatted_price($v)?></td>
                        <?php $total += $v; ?>
                      </tr>
                      <?php endforeach;?>
                      <tr style="background:#000;color:#fff;">
                          <td>Total</td>
                          <td><?=get_formatted_price($total)?></td>
                      </tr>
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
</section>
