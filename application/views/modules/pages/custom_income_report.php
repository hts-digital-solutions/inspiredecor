<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>
<section class="content content-header">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
        <div class="panel-heading ui-sortable-handle">
          <div class="col-md-6">
            <div class="btn-group">
              <p><?php echo isset($_GET['rtype']) ? ucfirst($_GET['rtype']) : 'Monthly'?> Performance</p>
              <p><?php echo isset($_GET['rtype']) ? ucfirst($_GET['rtype']) : 'Monthly'?> Performance for 
              <?php echo isset($_GET['month']) ? ucfirst($_GET['month']) ." ".$_GET['year'] : date('M Y');?></p>
              <p>This report shows a <?php echo isset($_GET['rtype']) ? ($_GET['rtype']) : 'Monthly'?>
              activity summary for a given <?php echo isset($_GET['rtype'])&&$_GET['rtype']=='daily' ? 'month' : 'year'?>.</p>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="cards">
              <form action="" method="get">
              <div class="serach-lists">
                <div class="col-md-3">
                  <div class="form-group">
                    <select class="form-control" name="rtype" id="rtype" onchange="showCIRO()">
                      <option value="">Select Report Type</option>
                      <option value="daily"
                      <?php echo isset($_GET['rtype']) && $_GET['rtype']=='daily' ? 'selected' :''; ?>
                      >Daily</option>
                      <option value="monthly"
                      <?php echo isset($_GET['rtype']) && $_GET['rtype']=='monthly' ? 'selected' :''; ?>
                      >Monthly</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3" style="display:none;" id="ciry">
                  <div class="form-group">
                    <select class="form-control" name="year">
                      <option value="">Year</option>
                      <?php for($i=date("Y");$i>=date("Y")-20;$i--):?>
                      <option value="<?=$i?>" 
                      <?php echo isset($_GET['year']) && $_GET['year']==$i ? 'selected' :''; ?>
                      ><?=$i?></option>
                      <?php endfor;?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4" style="display:none;" id="cirm">
                  <div class="form-group">
                    <select class="form-control" name="month">
                      <option value="">Month</option>
                      <option value="jan"
                      <?php echo isset($_GET['month']) && $_GET['month']=='jan' ? 'selected' :''; ?>
                      >January</option>
                      <option value="feb"
                      <?php echo isset($_GET['month']) && $_GET['month']=='feb' ? 'selected' :''; ?>
                      >February</option>
                      <option value="mar"
                      <?php echo isset($_GET['month']) && $_GET['month']=='mar' ? 'selected' :''; ?>
                      >March</option>
                      <option value="apr"
                      <?php echo isset($_GET['month']) && $_GET['month']=='apr' ? 'selected' :''; ?>
                      >April</option>
                      <option value="may"
                      <?php echo isset($_GET['month']) && $_GET['month']=='may' ? 'selected' :''; ?>
                      >May</option>
                      <option value="jun"
                      <?php echo isset($_GET['month']) && $_GET['month']=='jun' ? 'selected' :''; ?>
                      >June</option>
                      <option value="jul"
                      <?php echo isset($_GET['month']) && $_GET['month']=='jul' ? 'selected' :''; ?>
                      >July</option>
                      <option value="aug"
                      <?php echo isset($_GET['month']) && $_GET['month']=='aug' ? 'selected' :''; ?>
                      >August</option>
                      <option value="sept"
                      <?php echo isset($_GET['month']) && $_GET['month']=='sept' ? 'selected' :''; ?>
                      >September</option>
                      <option value="oct"
                      <?php echo isset($_GET['month']) && $_GET['month']=='oct' ? 'selected' :''; ?>
                      >October</option>
                      <option value="nov"
                      <?php echo isset($_GET['month']) && $_GET['month']=='nov' ? 'selected' :''; ?>
                      >November</option>
                      <option value="dec"
                      <?php echo isset($_GET['month']) && $_GET['month']=='dec' ? 'selected' :''; ?>
                      >December</option>
                    </select>
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
                <!-- Bar Chart -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="panel panel-bd lobidisable">
                    <div class="panel-body">
                      <div id="daily-income-report"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.row -->
              <div class="card-headers">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover" id="cirtable">
                    <thead>
                      <tr>
                        <th>Date/Month</th>
                        <th>Lead</th>
                        <th>Client</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(isset($cireport_l['a']) && !empty($cireport_l['a'])):?>
                      <?php foreach($cireport_l['a'] as $k=>$v):?>
                      <tr>
                        <td><?=ucfirst($k)?></td>
                        <td><?=get_formatted_price($v)?></td>
                        <td><?=get_formatted_price($cireport_c['a'][$k])?></td>
                        <td><?=get_formatted_price($v+$cireport_c['a'][$k])?></td>
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
</section>
