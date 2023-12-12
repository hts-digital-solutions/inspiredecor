<?php defined("BASEPATH") OR die("No direct script access allowed.");?>

<section class="content content-header">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
        <div class="panel-heading ui-sortable-handle">
          <div class="btn-group">Send SMS History</div>
        </div>
        <div class="panel-body">
          <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="cards">
              <div class="card-headers">
                <form action="" method="GET">
                <div class="col-md-1">
                  <div class="form-group">
                    <lable class="search-lable">Search By</lable>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="text" name="client" class="form-control" placeholder="Client Name" 
                    value="<?php echo isset($_GET['client'])?$_GET['client']:''; ?>"/>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="text" class="form-control" id="smsFrom" name="smsFrom" placeholder="Date From" 
                    value="<?php echo isset($_GET['smsFrom'])?$_GET['smsFrom']:''; ?>"/>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="text" class="form-control" id="smsTo" name="smsTo" placeholder="Date To" 
                    value="<?php echo isset($_GET['smsTo'])?$_GET['smsTo']:''; ?>"/>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <select name="status" class="form-control">
                        <option value="">Select</option>
                        <option value="1"
                        <?php echo isset($_GET['status']) && $_GET['status']== 1 ? 'selected':''; ?>
                        >Success</option>
                        <option value="0"
                        <?php echo isset($_GET['status']) && $_GET['status']== 0 ? 'selected':''; ?>
                        >Failed</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2" style="float:right;">
                  <div class="form-group">
                    <button type="submit" class="btn btn-block btn-success">Submit</button>
                  </div>
                </div>
                </form>
                <div class="table-responsive">
                  <table class="table table-bordered table-hover" id="smsSent">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Client Name</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($sms) && !empty($sms)):?>
                    <?php $i=1; foreach($sms as $s):?>
                      <tr>
                        <td><?=$i?></td>
                        <td><?= isset($s->client_id) && $s->client_id!=0
                        ? get_client_info($s->client_id,'client_name') : $s->sent_to ?></td>
                        <td>
                            <?= $s->sms_subject ?> <br>
                            <?= $s->sms_content ?>
                        </td>
                        <td><?= get_formatted_date($s->created) ?></td>
                        <td>
                            <?php if($s->is_sent == 1):?>
                            <span class="label-success label label-default">Success</span>
                            <?php else: ?>
                            <span class="label-danger label label-default">Failed</span>
                            <?php endif;?>
                        </td>
                      </tr>
                    <?php $i++; endforeach;?>
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
