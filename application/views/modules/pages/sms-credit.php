<?php defined("BASEPATH") OR die("No direct script access allowed.");?>

<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
        <div class="panel-heading ui-sortable-handle">
          <div class="btn-group">SMS Credit History</div>
        </div>
        <div class="panel-body">
          <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="cards">
              <div class="card-headers">
                <div class="table-responsive mob-bord">
                  <table class="table table-bordered table-hover" id="smsCredit">
                    <thead>
                      <tr>
                        <th>SMS Credit</th>
                        <th>Amount</th>
                        <th>Payment ID</th>
                        <th>Status</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($sms_credit) && !empty($sms_credit)):?>
                    <?php foreach($sms_credit as $c):?>
                      <tr>
                        <td><?=$c->sms_credit_req?></td>
                        <td><?=get_formatted_price($c->sms_credit_price)?></td>
                        <td><?=$c->payment_id?></td>
                        <td><?=ucfirst($c->status)?></td>
                        <td><?=date("d-m-Y h:i:s A", $c->created)?></td>
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
