<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
        <div class="panel-heading ui-sortable-handle">
          <div class="btn-group">
            <p>Clients</p>
          </div>
        </div>
        <div class="panel-body">
          <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="cards">
              <div class="serach-lists">
                <form action="" method="get">
                <div class="col-md-5">
                  <div class="form-group">
                    <input type="text" name="crdf" id="crdf"
                    value="<?php echo isset($_GET['crdf']) ? $_GET['crdf']:''; ?>"
                    class="form-control" placeholder="Start Date Range" />
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <input type="text" name="crdt" id="crdt"
                    value="<?php echo isset($_GET['crdt']) ? $_GET['crdt']:''; ?>"
                    class="form-control" placeholder="End Date Range" />
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <button type="submit" class="btn btnss btn-success">Submit</button>
                  </div>
                </div>
                </form>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="panel panel-bd lobidisable">
                    <div class="panel-body">
                      <div id="crdiv"></div>
                    </div>
                  </div>
                </div>
                <div class="card-headers">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="crtable">
                      <thead>
                        <tr>
                          <th>Month</th>
                          <th>No. of Clients</th>
                          <th>Order place</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php $tc = $to = 0;?>
                          <?php if(isset($creport['a']) && !empty($creport['a'])):?>
                          <?php foreach($creport['a'] as $k=>$v):?>
                          <tr>
                            <td><?=ucfirst($k)?></td>
                            <td><?=$v?></td>
                            <td><?=$cro[$k]?></td>
                            <?php $tc += $v; ?>
                            <?php $to += $cro[$k]; ?>
                          </tr>
                          <?php endforeach;?>
                          <tr style="background:dodgerblue;color:#fff;">
                              <td>Total</td>
                              <td><?=$tc?></td>
                              <td><?=$to?></td>
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
  </div>
</section>
