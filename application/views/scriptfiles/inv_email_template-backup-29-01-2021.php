<php defined("BASEPATH") OR exit("No direct script access allowed");?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo isset($inv->invoice_gid) ? "#".$inv->invoice_gid : ''; ?></title>
  </head>
  <body style="font-family: Arial, Helvetica, sans-serif; background-color: #464646; font-size: 12px; color: #000000; margin: 0 auto;">
    <div style="width:100%; background-color: #fff; margin: 5px auto; padding: 10px; overflow: hidden; position: relative;">
      <!-- section 1 begin -->
      <div style="width: 100%;  padding-bottom: 12px;">
        <div style="width: 50%; float: left;">
          <img src="<?php echo !empty(get_config_item('invoice_logo')) ? base_url().'resource/system_uploads/inv_logo/'.get_config_item('invoice_logo') : '';?>" style="height: 80px; object-fit: contain;" />
        </div>
        <div style="width: 50%; float: left;">
          <?php if(isset($inv->order_status) && $inv->order_status=='paid'):?>
          <div
            class="paid_box"
            style="
              width: 50%;
              height: 65px;
              background: #97df4a;
              line-height: 55px;
              text-align: center;
              color: #fff;
              border: solid 3px #68bd3e;
              font-size: 28px;
              font-weight: bold;
              transform: rotate(35deg);
              position: absolute;
              right: 0px;
              top: 15px;
              letter-spacing: 0.5px;
            "
          >
            PAID
          </div>
          <?php elseif(isset($inv->order_status) && $inv->order_status=='pending' || $inv->order_status=='due'):?>
          <div
            class="paid_box"
            style="
              width: 50%;
              height: 65px;
              background: #fc584b ;
              line-height: 55px;
              text-align: center;
              color: #fff;
              border: solid 3px #f83727;
              font-size: 28px;
              font-weight: bold;
              transform: rotate(35deg);
              position: absolute;
              right: 0px;
              top: 15px;
              letter-spacing: 0.5px;
            "
          >
            PENDING
          </div>
          <?php endif;?>
          <div class="company_name" style="text-align: left; padding-top: 70px;">
            <h4 style="font-size: 19px; font-weight: normal; margin: 0px; padding: 0px;"><?=get_config_item('company_name')?></h4>
            <?php if(get_config_item('company_cin')): ?>
            <p style="margin: 5px 0; font-size: 13px;">CIN: <?=get_config_item('company_cin')?></p>
            <?php endif;?>
            <?php if(get_config_item('company_gst')): ?>
            <p style="margin: 5px 0; font-size: 13px;">GST: <?=get_config_item('company_gst')?></p>
            <?php endif;?>
            <?php if(get_config_item('company_pan')): ?>
            <p style="margin: 5px 0; font-size: 13px;">PAN No.: <?=get_config_item('company_pan')?></p>
            <?php endif;?>
            <p style="margin: 5px 0; font-size: 13px;">Email ID: <?=get_config_item('company_email')?></p>
            <p style="margin: 5px 0; font-size: 13px;">Address: <?=get_config_item('company_address')?></p>
          </div>
        </div>
      </div>
      <!-- section 1 end -->

      <!-- section 2 begin -->

      <div style="width: 100%; float: left;">
        <div style="width: 100%; float: left;">
          <div class="company_name" style="padding: 10px; background-color: #efefef;">
            <h4 style="font-size: 19px; font-weight: normal; margin: 0px; padding: 0px;"><strong>Invoice #<?php echo !empty($inv->invoice_gid) ? $inv->invoice_gid : $inv->performa_id; ?></strong></h4>

            <p style="margin: 5px 0; font-size: 13px;">Invoice Date: <?php echo isset($inv->invoice_date) ? get_formatted_date($inv->invoice_date ): ''; ?></p>
            <p style="margin: 5px 0; font-size: 13px;">Due Date: <?php echo isset($inv->invoice_due_date) ? get_formatted_date($inv->invoice_due_date ): ''; ?></p>
          </div>
        </div>
      </div>

      <!-- section 2 End -->

      <!-- section 3 begin -->
      <div style="width: 100%; margin: 20px 0px 20px 0px; float: left;">
        <div style="width: 100%; float: left; margin: 0px 0px 0px 0px;"></div>
        <div style="width: 50%; float: left; margin: 0px 0px 0px 0px;">
          <p style="font-size: 16px; font-weight: 700; margin: 30px 0px 0px 0px;">Invoiced To</p>
          
            <?php if(get_client_info($inv->client_id,'client_name')): ?>
            <p style="margin: 5px 0; font-size: 13px;"><?=get_client_info($inv->client_id,'client_company')?></p>
            <p style="margin: 5px 0; font-size: 13px;">ATTN: <?=get_client_info($inv->client_id,'client_name')?></p>
            <?php endif;?>
            <?php if(get_client_info($inv->client_id,'client_gst')): ?>
            <p style="margin: 5px 0; font-size: 13px;">GST: <?=get_client_info($inv->client_id,'client_gst')?></p>
            <?php endif;?>
            <?php if(get_client_info($inv->client_id,'client_pan')): ?>
            <p style="margin: 5px 0; font-size: 13px;">PAN No.: <?=get_client_info($inv->client_id,'client_pan')?></p>
            <?php endif;?>
            <p style="margin: 5px 0; font-size: 13px;">Email ID: <?=get_client_info($inv->client_id,'client_email')?></p>
            <p style="margin: 5px 0; font-size: 13px;">Address: <?=get_client_info($inv->client_id,'client_fulladdress')?></p>
          
          </p>
        </div>
      </div>
      <!-- section 3 end -->

      <!-- section 4 begin -->

      <div class="description" style="width: 100%; margin: 10px 0px 10px 0px; float: left;">
        <table style="width: 100%;">
          <tr style="border: solid 1px #ccc;">
            <th style="width: 75%; padding: 5px; border: 1px solid #ddd; text-align: left; background-color: #efefef; text-align: center;">Description</th>
            <th style="width: 25%; padding: 5px; border: 1px solid #ddd; text-align: left; background-color: #efefef; text-align: center;">Total</th>
          </tr>
          <?php if(isset($products) && isset($cp) && !empty($cp)):?>
          <?php $i=1; for($j=0; $j<count($cp); $j++):?>
          <tr>
            <td style="padding: 10px 10px; border: 1px solid #ddd;">
                <?php echo isset($products[$j]->product_service_name) ? $products[$j]->product_service_name : '';?> 
                [<?php echo isset($cp[$j]->service_name) ? $cp[$j]->service_name : '';?>]<br/>
                ( <?= ucfirst($cp[$j]->billing_cycle) ?> 
                : <?= get_formatted_date($cp[$j]->add_date) ?> - <?= get_formatted_date($cp[$j]->next_due_date) ?> )
            </td>
            <td style="text-align: center; border: 1px solid #ddd;">
                <?php echo isset($products[$j]->payment) ? get_formatted_price($products[$j]->payment + $products[$j]->set_up_fee) : '';?>
            </td>
          </tr>
          <?php $i++; endfor;?>
          <?php endif;?>
          <tr>
            <td style="background-color: #efefef; border: 1px solid #ddd; padding: 5px; text-align: right; font-weight: 600;">Discount</td>
            <td style="background-color: #efefef; border: 1px solid #ddd; padding: 5px; text-align: center; font-weight: 600;">
                <?php echo isset($inv->discount) ? get_formatted_price($inv->discount) : '';?>
            </td>
          </tr>
          
          <tr>
            <td style="background-color: #efefef; border: 1px solid #ddd; padding: 5px; text-align: right; font-weight: 600;">Sub Total</td>
            <td style="background-color: #efefef; border: 1px solid #ddd; padding: 5px; text-align: center; font-weight: 600;">
                <?php echo isset($inv->invoice_subtotal) ? get_formatted_price($inv->invoice_subtotal) : '';?>
            </td>
          </tr>
          <tr>
            <td style="background-color: #efefef; border: 1px solid #ddd; padding: 5px; text-align: right; font-weight: 600;">GST <?=get_config_item('default_tax')?>%</td>
            <td style="background-color: #efefef; border: 1px solid #ddd; padding: 5px; text-align: center; font-weight: 600;">
                <?php echo isset($inv->gst_total) ? get_formatted_price($inv->gst_total) : '';?>
            </td>
          </tr>
          <tr>
            <td style="background-color: #efefef; border: 1px solid #ddd; padding: 5px; text-align: right; font-weight: 600;">Credit</td>
            <td style="background-color: #efefef; border: 1px solid #ddd; padding: 5px; text-align: center; font-weight: 600;">
                <?php echo isset($inv->paid_amount) ? get_formatted_price($inv->paid_amount) : '';?>
            </td>
          </tr>
          <tr>
            <td style="background-color: #efefef; border: 1px solid #ddd; padding: 5px; text-align: right; font-weight: 600;">Total</td>
            <td style="background-color: #efefef; border: 1px solid #ddd; padding: 5px; text-align: center; font-weight: 600;">
                <?php echo isset($inv->invoice_total) ? get_formatted_price($inv->invoice_total) : '';?>
            </td>
          </tr>
          <?php if($inv->invoice_total!=0):?>
          <tr>
              <td>Pay now with </td>
              <td>
              <?php if(get_config_item('is_razorpay')=='yes'):?>
              <a style="padding:5px 2px;color:dodgerblue;float:left;display:inline;"
              href="<?=base_url()?>home/pay_with_razorpay/<?=encrypt_me($inv->invoice_id)?>">Razorpay</a>
              <?php endif; if(get_config_item('is_payu')=='yes'):?>
              <a style="padding:5px 2px;color:green;float:right;display:inline;"
              href="<?=base_url()?>home/pay_with_payumoney/<?=encrypt_me($inv->invoice_id)?>">PayUMoney</a>
              <?php endif;?>
              </td>
          </tr>
          <?php endif;?>
        </table>
      </div>
      <!-- section 4 end -->

      <!-- section 5 begin -->

      <div class="transactions" style="width: 100%; margin: 10px 0px 10px 0px; float: left;">
        <h4>Transactions</h4>
        <?php
        $this->load->model("Invoice_Model");
        $txn = $this->Invoice_Model->get_txn(base64_encode($inv->invoice_id));
        ?>
        <table style="width: 100%;">
          <tr style="border: solid 1px #ccc;">
            <th style="width: 25%; border: 1px solid #ddd; padding: 5px; text-align: left; background-color: #efefef; text-align: center;">Transaction Date</th>
            <th style="width: 25%; border: 1px solid #ddd; padding: 5px; text-align: left; background-color: #efefef; text-align: center;">Gateway</th>
            <th style="width: 25%; border: 1px solid #ddd; padding: 5px; text-align: left; background-color: #efefef; text-align: center;">Transaction ID</th>
            <th style="width: 25%; border: 1px solid #ddd; padding: 5px; text-align: left; background-color: #efefef; text-align: center;">Amount</th>
          </tr>
          <?php $totxn = 0; if(isset($txn) && !empty($txn)):?>
          <?php foreach($txn as $t):?>
          <tr>
            <td style="width: 25%; border: 1px solid #ddd; text-align: center; padding: 5px; font-size: 13px;"><?=get_formatted_date($t->created)?></td>
            <td style="width: 25%; border: 1px solid #ddd; text-align: center; padding: 5px; font-size: 13px;"><?=ucfirst($t->pay_method)?></td>
            <td style="width: 25%; border: 1px solid #ddd; text-align: center; padding: 5px; font-size: 13px;"><?=($t->txn_id)?></td>
            <td style="width: 25%; border: 1px solid #ddd; text-align: center; padding: 5px; font-size: 13px;"><?=get_formatted_price($t->amount)?></td>
          </tr>
          <?php endforeach;?>
          <?php else:?>
          <tr><td colspan="8" style="color:red;">No transactions found!</td></tr>
          <?php endif;?>
          <tr>
            <td style="width: 25%; border: 1px solid #ddd; background-color: #efefef; padding: 5px; font-weight: 600;"></td>
            <td style="width: 25%; border: 1px solid #ddd; background-color: #efefef; padding: 5px; font-weight: 600;"></td>
            <td style="width: 25%; border: 1px solid #ddd; background-color: #efefef; padding: 5px; text-align: right; font-weight: 600;">Balance</td>
            <td style="width: 25%; border: 1px solid #ddd; background-color: #efefef; padding: 5px; text-align: center; font-weight: 600;"><?=get_formatted_price($inv->invoice_total)?></td>
          </tr>
        </table>
        <p style="text-align: center; padding-top: 10px;">PDF Generated on <?=get_formatted_date($inv->created)?></p>
      </div>
      <!-- section 5 end -->
    </div>
  </body>
</html>
