<?php defined("BASEPATH") OR die("No direct script access allowed.");?>
<section class="content content-header pd-lft">
  <div class="row">
    <div class="addleade">
      <div class="panel-body">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
          <div class="panel panel-bd cardbox">
            <div class="panel-body">
              <div class="statistic-box  text-center">
                  <i class="fa fa-credit-card fa-2x"></i>
                  <h4>Balance</h4>
                  <h3>
                  <?php $sms = json_decode($sms_balance);?>
                  <?php echo
                  !isset($sms->error) ? $sms->data->sms_credit : '';
                  ?>
              </h3>
              <span class="text-danger">
                  <?php echo
                  isset($sms->error) ? 'Balance fetch error!' : '';
                  ?>
              </span>
              </div>
             
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
          <div class="panel panel-bd cardbox2">
            <div class="panel-body">
            <?php $sms_this_month = json_decode($sms_this_month) ?>
              <div class="statistic-box text-center">
                   <i class="fa fa-envelope-o fa-2x"></i>
                   <h4>Message Send this Month</h4>
                  <h3>
                  <?php echo
                  isset($sms_this_month->success) ? $sms_this_month->total: 0;
                  ?>
              </h3></div>
             
            </div>
          </div>
        </div>
        <?php if(false):?>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
          <a href="<?=base_url()?>sent-sms">
            <div class="panel panel-bd cardbox3">
              <div class="panel-body">
                <div class="statistic-box text-center">
                    <i class="fa fa-envelope-o fa-2x"></i>
                    <h4>Send SMS History</h4></div>
               
              </div>
            </div>
          </a>
        </div>
        <?php endif;?>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
          <a href="<?=base_url()?>sms-credit">
            <div class="panel panel-bd cardbox4">
              <div class="panel-body">
                
                <div class="statistic-box text-center">
                    <i class="fa fa-envelope-o fa-2x"></i>
                    <h4>SMS Credit History</h4>
                    </div>
              </div>
            </div>
          </a>
        </div>
        <form action="https://<?=get_domain(base_url())?>sms_credit" method="GET">
          
              <div class="col-md-12 col-xs-12">
                  <div class="sms-maxwidth">
                    <div class="cardses">
              <div class="row">
                <div class="card-headers">
                  <lable class="col-md-4 quantity">Choose Quantity</lable>
                  <div class="form-group col-md-7">
                      <input type="hidden" name="return" value="<?=base_url('sms')?>" />
                      <input type="hidden" name="user" value="<?=encrypt_me(get_config_item('sms_user'))?>" />
                      <input type="hidden" name="id" value="<?=encrypt_me(get_config_item('sms_userid'))?>" />
                      <input type="hidden" name="e" value="<?=encrypt_me(get_config_item('company_email'))?>" />
                      <input type="hidden" name="c" value="<?=encrypt_me(get_config_item('company_name'))?>" />
                      <input type="hidden" name="m" value="<?=encrypt_me(get_config_item('company_mobile'))?>" />
                      <input type="hidden" name="qty" id="pqty" />
                      
                      <select class="form-control" name="sms_pack" id="sms_pack">
                        <option value="">Quantity</option>
                        <?php if(isset($qtys) && !empty($qtys)):?>
                        <?php foreach($qtys as $q):?>
                        <option data="<?= base64_encode(($q->sms_price)+(($q->sms_price*18)/100))?>" 
                        value="<?= encrypt_me(($q->sms_price)+(($q->sms_price*18)/100))?>"><?=$q->sms_qty?></option>
                        <?php endforeach;?>
                        <?php endif;?>
                      </select>
                      
                  </div>
                
                </div>
              </div>
            </div>
            </div>
          </div>
           
                <div class="payment col-md-12" style="display:none;" id="paymentSms">
                     <div class="cardses">
                       <div class="row">
                    <div class="col-md-12">
                <div class="card-headers">
                  <div class="table-responsive mob-bord">
                      <p>Payable Amount</p>
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>Quantity</th>
                          <th>Price</th>
                         
                        </tr>
                      </thead>
                      <tbody>
                         
                        <tr>
                            <td>10000SMS</td>
                            <td>Rs.2000</td>
                        </tr>
                        <tr>
                            <td>GST+(18%)</td>
                            <td>Rs.20</td>
                        </tr>
                         <tr style="background:dodgerblue;color:#fff;">
                              <td>Total</td>
                             <td>220</td>
                        </tr>
                        
                       
                      </tbody>
                    </table>
                    <div class="row">
                    <div class="col-md-12 col-xs-12 text-center">
                   <div class="form-group">
                        <button class="btn btnses btn-primary" style='text-align:center;'>Proceed to payment</button>
                  </div>
                  </div>
                  </div>
                  </div>
                </div></div>
              </div>
                      
        	        
                    <div class="bg-primary" 
                    style="padding:10px;display:table;width:100%;">
                    <span id="pamt" style="font-weight: 700;font-size: 2.2rem;"></span>
                    <span>  [ Included 18% GST ]</span>
                    
                    </div>
                  </div>
            </div>
        </form>
       
        </div>
      </div>
    </div>
  </div>
</section>
