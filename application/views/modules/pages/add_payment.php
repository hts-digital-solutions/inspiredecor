<?php defined("BASEPATH") OR exit("No direct access allowed.");?>
<?php //if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true):?>
<section class="content content-header">
    <div class="row">
        <div class="panel panel-bd" style="display:inline-block;padding:20px 10px;width:100%;">
            <form action="<?=base_url()?>project/add_new_payment" method="POST">
            <input type="hidden" name="pid" value="<?=isset($payment->passbook_id) ? base64_encode($payment->passbook_id) : ''?>" />
            <div class="card-headers row">
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Client</label>
                      <select class="form-control" required onchange="filterProject(event);" name="client_id">
                          <option value="">Select</option>
                          <?php foreach($clients as $client):?>
                          <option value="<?=$client->client_id?>"
                          <?php echo isset($payment->client_id) && $payment->client_id == $client->client_id ? 'selected':'';?>
                          ><?=$client->client_name?></option>
                          <?php endforeach;?>
                      </select>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Project</label>
                      <select class="form-control" name="project_id" required>
                          <option value="">Select</option>
                          
                      </select>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Amount</label>
                      <input class="form-control" name="amount" value="<?=$payment->amount ?? 0?>" id="amount" type="text" required />
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Date</label>
                      <input class="form-control" name="date" value="<?=!empty($payment->date) ? date('Y-m-d', strtotime($payment->date)) : ''?>" id="date" type="date" required />
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Type</label>
                      <select class="form-control" name="type" required>
                          <option value="">Select</option>
                          <option value="cash" <?php echo isset($payment->type) && $payment->type == 'cash' ? 'selected':'';?>>Cash</option>
                          <option value="credit" <?php echo isset($payment->type) && $payment->type == 'credit' ? 'selected':'';?>>Credit</option>
                          <option value="paytm" <?php echo isset($payment->type) && $payment->type == 'paytm' ? 'selected':'';?>>Paytm</option>
                          <option value="googlepay" <?php echo isset($payment->type) && $payment->type == 'googlepay' ? 'selected':'';?>>Googlepay</option>
                          <option value="phonepay" <?php echo isset($payment->type) && $payment->type == 'phonepay' ? 'selected':'';?>>Phonepay</option>
                          <option value="online transfer" <?php echo isset($payment->type) && $payment->type == 'online transfer' ? 'selected':'';?>>Online Transfer</option>
                          <option value="adjustment" <?php echo isset($payment->type) && $payment->type == 'adjustment' ? 'selected':'';?>>Adjustment</option>
                          <option value="product upsell" <?php echo isset($payment->type) && $payment->type == 'product upsell' ? 'selected':'';?>>Product Upsell</option>
                      </select>
                  </div>
              </div>
              
              <div class="col-md-9">
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea class="form-control" name="comment" id="comment"><?= $payment->comment ?? '' ?></textarea>
                    </div>
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
    function filterProject(e)
    {
        const projects = JSON.parse('<?=$projects?>');
        const options = projects.filter(d => d.client_id == e.target.value).map(d => {
            return `<option value="${d.project_id}">${d.project_name}</option>`;
        }).join("");
        
        const blankOption = "<option value=''>Select</option>";
        
        document.querySelector("select[name='project_id']").innerHTML = (blankOption + options);
    }
    
    <?php if(isset($payment->client_id)):?>
        const id = '<?=$payment->client_id?>';
        const pid = '<?=$payment->project_id?>';
        const projects = JSON.parse('<?=$projects?>');
        const options = projects.filter(d => d.client_id == id).map(d => {
            return `<option value="${d.project_id}" ${d.project_id === pid ? 'selected' : ''}>${d.project_name}</option>`;
        }).join("");
        
        const blankOption = "<option value=''>Select</option>";
        
        document.querySelector("select[name='project_id']").innerHTML = (blankOption + options);
    <?php endif;?>
</script>
<?php //else:?>
<!--<p>Access denied!</p>-->
<?php //endif;?>