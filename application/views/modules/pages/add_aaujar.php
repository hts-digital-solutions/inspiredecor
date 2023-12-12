<?php defined("BASEPATH") OR exit("No direct access allowed.");?>

<section class="content content-header">
    <div class="row">
        <div class="panel panel-bd" style="display:inline-block;padding:20px 10px;width:100%;">
            <form action="<?=base_url()?>project/add_new_aaujar" method="POST">
            <input type="hidden" name="pid" value="<?=isset($aaujar->aaujar_id) ? base64_encode($aaujar->aaujar_id) : ''?>" />
            <input type="hidden" name="transfer_qty" value="<?=$aaujar->transfer_qty ?? 0?>"/>
            <div class="card-headers row">
             <?php if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
&& $_SESSION['roll']==='admin'):?>
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Business Associate</label>
                      <select class="form-control" name="agent_id" required>
                          <option value="">Select</option>
                          <?php foreach($agents as $agent):?>
                          <option value="<?=$agent->agent_id?>"
                          <?php echo isset($aaujar->agent_id) && $aaujar->agent_id == $agent->agent_id ? 'selected':'';?>
                          ><?=$agent->agent_name?></option>
                          <?php endforeach;?>
                      </select>
                  </div>
              </div>
              <?php endif;?>
              
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Date</label>
                      <input type="date" class="form-control" name="date" value="<?= !empty($aaujar->created) ? date('Y-m-d', strtotime($aaujar->created)) : ''?>"/>
                  </div>
              </div>
              
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Tool</label>
                      <select class="form-control" id="auzaar" name="auzaar" required>
                          <option value="">Select</option>
                          <?php foreach($auzaar_names as $c):?>
                          <option value="<?=strtolower($c->name)?>" <?php echo isset($aaujar->tool_name) && $aaujar->tool_name == strtolower($c->name) ? 'selected':'';?>><?=$c->name?></option>
                          <?php endforeach;?>
                          <option value="other" <?php echo isset($aaujar->tool_name) && $aaujar->tool_name == 'other' ? 'selected':'';?>>Other</option>
                      </select>
                  </div>
              </div>
              
              <div class="col-md-12" style="display:none;" id="auzaar-other">
                  <div class="form-group">
                      <label>Tool Name</label>
                      <input class="form-control" name="auzaar_name" id="auzaar_name" value="<?=$aaujar->tool_name ?? ''?>" type="text"/>
                  </div>
              </div>
              
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Total Quantity</label>
                      <input type="tel" class="form-control" name="total_qty" value="<?=$aaujar->total_qty ?? ''?>" />
                  </div>
              </div>
              
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Used Quantity</label>
                      <input type="tel" class="form-control" name="used_qty" value="<?=$aaujar->used_qty ?? ''?>" />
                  </div>
              </div>
              
              <div class="col-md-12">
                  <label>Details</label>
                  <textarea class="form-control" name="details"><?=$aaujar->details ?? ''?></textarea>
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
    document.querySelector("#auzaar").onchange = function(e){
        if(e.target.value === 'other') {
            document.querySelector("#auzaar-other").style.display = 'block';
        }else {
            document.querySelector("#auzaar-other").style.display = 'none';
        }
    }
</script>