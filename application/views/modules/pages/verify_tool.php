<?php defined("BASEPATH") OR exit("No direct access allowed.");?>

<section class="content content-header">
    <div class="row">
        <div class="panel panel-bd" style="display:inline-block;padding:20px 10px;width:100%;">
            <form class="card-headers row">
                <div class="col-md-4">
                  <div class="form-group">
                      <label>Business Associate</label>
                      <select class="form-control" name="agent_id" onchange="this.form.submit();">
                          <option value="">Select</option>
                          <?php foreach($agents as $agent):?>
                          <?php if($agent->agent_id !== auth_id()):?>
                          <option value="<?=$agent->agent_id?>"
                          <?php echo isset($_GET['agent_id']) && $_GET['agent_id'] == $agent->agent_id ? 'selected':'';?>
                          ><?=$agent->agent_name?></option>
                          <?php endif;?>
                          <?php endforeach;?>
                      </select>
                  </div>
              </div>
              
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Tool</label>
                      <select class="form-control" id="auzaar" name="auzaar" onchange="this.form.submit();">
                          <option value="">Select</option>
                          <?php foreach($auzaar_names as $c):?>
                          <option value="<?=strtolower($c->name)?>" <?php echo isset($_GET['auzaar']) && $_GET['auzaar'] == strtolower($c->name) ? 'selected':'';?>><?=$c->name?></option>
                          <?php endforeach;?>
                      </select>
                  </div>
              </div>
              
              <div class="col-md-3"><label>Available Qty:</label> <p class="form-control"><?=$tool->closing_qty ?? 0?></p></div>
            </form>
            <form action="<?=base_url()?>project/verify_aaujar" method="POST">
                <input type="hidden" name="from_agent" value="<?=$_GET['agent_id'] ?? ''?>" />
                <input type="hidden" name="tool" value="<?=$_GET['auzaar'] ?? ''?>" />
                
            <div class="card-headers row">
                     <div class="col-md-4">
                  <div class="form-group">
                      <label>Agent</label>
                      <select class="form-control" required name="agent_id">
                          <option value="">Select</option>
                          <?php foreach($agents as $agent):?>
                          <?php if(auth_id() ==0):?>
                          <?php if($agent->agent_id !== $_GET['agent_id'] ?? 0):?>
                          <option value="<?=$agent->agent_id?>"
                          ><?=$agent->agent_name?></option>
                          <?php endif;?>
                          <?php else:?>
                          <?php if($agent->agent_id == auth_id()):?>
                          <option selected value="<?=$agent->agent_id?>"
                          ><?=$agent->agent_name?></option>
                          <?php endif;?>
                          <?php endif;?>
                          <?php endforeach;?>
                      </select>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Quantity</label>
                      <input type="number" min="1" max="<?=isset($tool->closing_qty) ? $tool->closing_qty : 1?>" <?= isset($tool->closing_qty) && $tool->closing_qty !== 0 ? '' : 'disabled="disabled"' ?>  required class="form-control" name="qty" />
                  </div>
              </div>
              
              <div class="col-md-12 text-right">
                  <button class="btn btn-info" <?= isset($tool->closing_qty) && $tool->closing_qty !== 0 ? '' : 'disabled="disabled"' ?> >Submit</button>
              </div>
            </div>
            </form>
        </div>
    </div>
</section>