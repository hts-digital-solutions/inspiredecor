<?php defined("BASEPATH") OR exit("No direct access allowed.");?>

<section class="content content-header">
    <div class="row">
        <div class="panel panel-bd" style="display:inline-block;padding:20px 10px;width:100%;">
            <form class="col-md-12">
                <?php if(auth_id() == 0):?>
                <div class="form-group col-md-3" style="padding:0px 8px;">
                    <label>Business Associate</label>
                    <select name="agent" onchange="this.form.submit();" class="form-control">
                        <option value="">Select</option>
                        <?php foreach($agents as $a):?>
                            <option value="<?=$a->agent_id?>" <?=$a->agent_id === ($_GET['agent'] ?? '') ? 'selected' : ''?>><?=$a->agent_name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Date</label>
                    <input type="date" onchange="this.form.submit();" class="form-control" name="date" value="<?=$_GET['date'] ?? ''?>" />
                </div>
              <?php endif;?>
            </form>
            <form action="<?=base_url()?>project/add_new_petty_cash" method="POST">
            <input type="date" hidden name="date" value="<?=$_GET['date'] ?? ''?>" />
            <input type="hidden" name="agent_id" value="<?=$_GET['agent'] ?? ($petty_cash->agent_id ?? '')?>" />
            <input type="hidden" name="pid" value="<?=isset($petty_cash->petty_cash_id) ? base64_encode($petty_cash->petty_cash_id) : ''?>" />
            <div class="card-headers row">
                
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Opening Balance</label>
                      <input type="text" class="form-control" required name="opening_balance" value="<?= $petty_cash->opening_balance ?? ($petty->opening_balance ?? 0); ?>"/>
                  </div>
              </div>
              
              <div class="col-md-12" id="amounts">
                  <?php $receivers = isset($petty_cash) ? json_decode($petty_cash->received_history) : null;?>
                  <?php if(is_array($receivers) && count($receivers) > 0):?>
                  <?php foreach($receivers as $key => $r):?>
                  <div class="row" id="id-<?=$key?>">
                      <div class="col-md-3">
                          <label>Received From</label>
                          <input type="text" name="received_from[]" value="<?=$r->from ?? ''?>" required class="form-control"/>
                      </div>
                      <div class="col-md-3">
                          <label>Received Amount</label>
                          <input type="text" name="received_amount[]" value="<?=$r->amount ?? ''?>"  required class="form-control"/>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label>Type</label>
                              <select class="form-control" name="type[]" required>
                                  <option value="">Select</option>
                                  <option value="cash" <?php echo isset($r->type) && $r->type == 'cash' ? 'selected':'';?>>Cash</option>
                                  <option value="credit" <?php echo isset($r->type) && $r->type == 'credit' ? 'selected':'';?>>Credit</option>
                                  <option value="paytm" <?php echo isset($r->type) && $r->type == 'paytm' ? 'selected':'';?>>Paytm</option>
                                  <option value="googlepay" <?php echo isset($r->type) && $r->type == 'googlepay' ? 'selected':'';?>>Googlepay</option>
                                  <option value="phonepay" <?php echo isset($r->type) && $r->type == 'phonepay' ? 'selected':'';?>>Phonepay</option>
                                  <option value="online transfter" <?php echo isset($r->type) && $r->type == 'online transfer' ? 'selected':'';?>>Online Transfer</option>
                                  <option value="adjustment" <?php echo isset($r->type) && $r->type == 'adjustment' ? 'selected':'';?>>Adjustment</option>
                                  <option value="product upsell" <?php echo isset($r->type) && $r->type == 'product upsell' ? 'selected':'';?>>Product Upsell</option>
                              </select>
                          </div>
                      </div>
                      <?php if($key > 0):?>
                      <div class="col-md-2">
                        <a style="margin-top:15px;display:block;" href="javascript:;" onclick="removeMe('id-<?=$key?>')" class="text-danger">Remove</a>
                      </div>
                      <?php endif;?>
                  </div>
                  <?php endforeach;?>
                  <?php else:?>
                  <div class="row">
                      <div class="col-md-3">
                          <label>Received From</label>
                          <input type="text" name="received_from[]" required class="form-control"/>
                      </div>
                      <div class="col-md-3">
                          <label>Received Amount</label>
                          <input type="text" name="received_amount[]" required class="form-control"/>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label>Type</label>
                              <select class="form-control" name="type[]" required>
                                  <option value="">Select</option>
                                  <option value="cash" <?php echo isset($r->type) && $r->type == 'cash' ? 'selected':'';?>>Cash</option>
                                  <option value="credit" <?php echo isset($r->type) && $r->type == 'credit' ? 'selected':'';?>>Credit</option>
                                  <option value="paytm" <?php echo isset($r->type) && $r->type == 'paytm' ? 'selected':'';?>>Paytm</option>
                                  <option value="googlepay" <?php echo isset($r->type) && $r->type == 'googlepay' ? 'selected':'';?>>Googlepay</option>
                                  <option value="phonepay" <?php echo isset($r->type) && $r->type == 'phonepay' ? 'selected':'';?>>Phonepay</option>
                                  <option value="online transfter" <?php echo isset($r->type) && $r->type == 'online transfer' ? 'selected':'';?>>Online Transfer</option>
                                  <option value="adjustment" <?php echo isset($r->type) && $r->type == 'adjustment' ? 'selected':'';?>>Adjustment</option>
                                  <option value="product upsell" <?php echo isset($r->type) && $r->type == 'product upsell' ? 'selected':'';?>>Product Upsell</option>
                              </select>
                          </div>
                      </div>
                  </div>
                  
                  <?php endif;?>
              </div>
              <div class="col-md-12" style="margin-top:10px;">
                  <button type="button" onclick="addNew();" class="btn btn-primary">Add More</button>
              </div>
              <div class="col-md-12 text-right">
                  <button class="btn btn-info">Submit</button>
              </div>
            </div>
            </form>
        </div>
    </div>
</section>

<script>
    function addNew() {
        
        const id = Math.random().toString(16).replace(".", "");
        const html = `<div class="row" id="id-${id}" style="margin-top:10px;">
              <div class="col-md-3">
                  <label>Received From</label>
                  <input type="text" name="received_from[]" required class="form-control"/>
              </div>
              <div class="col-md-3">
                  <label>Received Amount</label>
                  <input type="text" name="received_amount[]" required class="form-control"/>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Type</label>
                      <select class="form-control" name="type[]" required>
                          <option value="">Select</option>
                          <option value="cash" >Cash</option>
                          <option value="credit">Credit</option>
                          <option value="paytm" >Paytm</option>
                          <option value="googlepay" >Googlepay</option>
                          <option value="phonepay" >Phonepay</option>
                          <option value="online transfter">Online Transfer</option>
                          <option value="adjustment">Adjustment</option>
                          <option value="product upsell">Product Upsell</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-2">
                <a style="margin-top:15px;display:block;" href="javascript:;" onclick="removeMe('id-${id}')" class="text-danger">Remove</a>
              </div>
          </div>`;
         
        document.getElementById("amounts").insertAdjacentHTML("beforeend", html);
    }
    
    function removeMe(id) {
        document.getElementById(id).remove();       
    }
</script>