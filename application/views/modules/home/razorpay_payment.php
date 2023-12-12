<?php defined("BASEPATH") OR die("No direct script access allowed.");?>
<?php 
$ci = &get_instance();
$ci->load->helper('razorpay_helper');

?>
<!doctype html>
<html>
    <head>
        <title>
            <?php echo isset($title) && !empty($title) ? $title : '404' ; ?>
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="favicon" href="<?=base_url()?>favicon.ico" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
        <style>
            .paycon{
                display:flex;
                justify-content:space-between;
                padding:20px;
            }
        </style>
    </head>
    <body>
        <?php if(isset($invoice) && !empty($invoice)):?>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-xs-12 paycon">
                    <div class="col-md-8 col-xs-12">
                        <h3>Client Details</h3>
                        <table class="table">
                            <tr>
                                <th>Client Name</th>
                                <td><?=get_client_info($invoice->client_id,'client_name')?></td>
                            </tr>
                            <tr>
                                <th>Client Email</th>
                                <td><?=get_client_info($invoice->client_id,'client_email')?></td>
                            </tr>
                            <tr>
                                <th>Client Mobile</th>
                                <td><?=get_client_info($invoice->client_id,'client_mobile')?></td>
                            </tr>
                            <tr>
                                <th>Billing Inovice</th>
                                <td><?php echo !empty($invoice->invoice_gid)?$invoice->invoice_gid:$invoice->performa_id?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <h3>Payment Details</h3>
                        <table class="table">
                            <tr>
                                <th>Subtotal:</th>
                                <td>
                                    <?php echo isset($invoice->invoice_subtotal) ? get_formatted_price($invoice->invoice_subtotal) : 0; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Discount:</th>
                                <td>
                                    <?php echo isset($invoice->discount) ? get_formatted_price($invoice->discount) : 0; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>GST <?=get_config_item('default_tax')?>%:</th>
                                <td>
                                    <?php echo isset($invoice->gst_total) ? get_formatted_price($invoice->gst_total) : 0; ?>
                                </td>
                            </tr>
                            <tr>
                                <th><h1>Total:</h1></th>
                                <td>
                                    <h1><?php echo isset($invoice->invoice_total) ? get_formatted_price($invoice->invoice_total) : 0; ?></h1>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button 
                                      class="btn btn-success btn-lg btn-block"
                                      id = "razor-pay-now"><i class="fa fa-credit-card"></i> Pay
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type="text/javascript">
        jQuery(document).on('click', '#razor-pay-now', function (e) {
        <?php
        $_SESSION['rpay']['client_id'] = $invoice->client_id;
        $_SESSION['rpay']['invoice_id'] = $invoice->invoice_id;
        $_SESSION['rpay']['invoice_gid'] = $invoice->invoice_gid;
        $_SESSION['rpay']['amount'] = $invoice->invoice_total;
        $_SESSION['rpay']['performa_id'] = $invoice->performa_id;
        ?>
        var total = (<?php echo isset($invoice->invoice_total) ? $invoice->invoice_total : 0; ?>)*100;
        var merchant_order_id = '<?php echo !empty($invoice->invoice_gid)?$invoice->invoice_gid:$invoice->performa_id; ?>';
        var merchant_surl_id = '<?= base_url()?>home/razorpay_success';
        var merchant_furl_id = '<?= base_url()?>razorpay_failed';
        var card_holder_name_id =  '<?php echo get_client_info($invoice->client_id,'client_name')?>';
        var merchant_total = total;
        var merchant_amount = '<?php echo isset($invoice->invoice_total) ? $invoice->invoice_total : 0; ?>';
        var currency_code_id = 'INR';
        var key_id = "<?php echo RAZOR_KEY_ID; ?>";
        var store_name = '<?=get_config_item('company_name')?>';
        var store_description = 'Invoice Payment';
        var store_logo = 'https://www.bizavtar.com/resources/media/1605532439-663754972logo.png';
        var email = '<?php echo get_client_info($invoice->client_id,'client_email')?>';
        var phone = '<?php echo get_client_info($invoice->client_id,'client_mobile')?>';
        jQuery('.text-danger').remove();
        
        var razorpay_options = {
            key: key_id,
            amount: merchant_total,
            name: store_name,
            description: store_description,
            image: store_logo,
            netbanking: true,
            currency: currency_code_id,
            prefill: {
                name: card_holder_name_id,
                email: email,
                contact: phone
            },
            notes: {
                soolegal_order_id: merchant_order_id,
            },
            handler: function (transaction) {
                jQuery.ajax({
                    url:'<?=base_url()?>home/razorpay_callback',
                    type: 'post',
                    data: {razorpay_payment_id: transaction.razorpay_payment_id, merchant_order_id: merchant_order_id, merchant_surl_id: merchant_surl_id, merchant_furl_id: merchant_furl_id, card_holder_name_id: card_holder_name_id, merchant_total: merchant_total, merchant_amount: merchant_amount, currency_code_id: currency_code_id}, 
                    dataType: 'json',
                    success: function (res) {
                        if(res.msg){
                            alert(res.msg);
                            return false;
                        } 
                        window.location = res.redirectURL;
                    }
                });
                
            },
            "modal": {
                "ondismiss": function () {
                    // code here
                }
            }
        };
        // obj  	
        var objrzpv1 = new Razorpay(razorpay_options);
        objrzpv1.open();
        e.preventDefault();
        });
        
        </script>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <?php else: ?>
        <code style="padding:10px;">Something went wrong! Please contact to system Administrator.</code>
        <?php endif;?>
    </body>
</html>