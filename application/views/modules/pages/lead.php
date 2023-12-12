<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>
<?php if(isset($_GET['status']) && $_GET['status'] == '10') { 
    $won_amount_total = 0;
} ?>
<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
      <div class="addleade">
        <div class="panel-body">
          <div class="export-data">
              <div class="col-md-5 col-xs-12">
                <div class="row">
                  <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="btn-group">
                      <a class="btn btnes exports" href="<?=base_url()?>add-lead"> <i class="fa fa-plus"></i>&nbsp;  Add Lead </a>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-4 mobil-nns col-xs-4">
                    <div class="btn-group">
                      <a class="btn btnes exports" href="<?=base_url()?>import-lead"> <i class="fa fa-download" aria-hidden="true"></i>&nbsp;  Import </a>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="btn-group">
                          <a type="button" id="advS" class="btn btnes exports"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;  Advance</a>
                        </div>
                  </div>
                </div>
              </div>
              <div class="col-md-7 col-xs-12">
                <div class="ipades">
                <form id="bulkForm" method="POST">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <div class="btne-group">
                        <p>Bulk Action</p>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-3 col-xs-12">
                        <select class="form-control" name="bstatus" id="bstatus">
                          <option value="">Change Status</option>
                            <?php 
                            $list = get_select_module('status');
                            ?>
                            <?php if(isset($list) && !empty($list)):?>
                            <?php foreach($list as $s):?>
                            <option
                            value="<?=$s->status_id?>"><?=$s->status_name?></option>
                            <?php endforeach;?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <select class="form-control" name="agent" id="agent">
                          <option value="">Transfer to</option>
                          <?php 
                            $list = get_select_module('agent');
                            ?>
                          <?php if(isset($list) && !empty($list)):?>
                          <?php foreach($list as $s):?>
                          <option value="<?=base64_encode($s->agent_id)?>"><?=$s->agent_name?></option>
                          <?php endforeach;?>
                          <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <input type="submit" class="btn btnes btn-primary form-control " value="Submit" />
                    </div>
                  </div>
                </form>
                </div>
              </div>
          </div>
          <div class="row">
            <div class="panel-header">
              <div class="step-app">
                <div class="step-content">
                  <div class="step-tab-panel">
                    <form action="" method="get">
                      <div class="row">
                       
                          <div class="col-md-12 advS" <?php echo isset($_GET) && !empty($_GET) ? '' : 'style="display:none;"';?>>
                            <div class="col-md-3">
                              <div class="form-group">
                                <input type="search" name="name" 
                                value="<?php echo isset($_GET['name']) ? $_GET['name'] : "";?>"
                                class="form-control" placeholder="Name search.." />
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <input type="text" name="contact" 
                                value="<?php echo isset($_GET['contact']) ? $_GET['contact'] : "";?>"
                                class="form-control" placeholder="Contact No" />
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <input class="form-control" placeholder="Reference By" name="reference_contact_number" type="text" value="<?=$_GET['reference_contact_number'] ?? ''?>"/>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <select class="form-control" name="agent">
                                  <option value="">Agent</option>
                                  <?php 
                                    $list = get_select_module('agent');
                                    ?>
                                  <?php if(isset($list) && !empty($list)):?>
                                  <?php foreach($list as $s):?>
                                  <option 
                                  <?php echo isset($_GET['agent']) && base64_decode($_GET['agent']) == $s->agent_id ? 
                                  "selected": "";?>
                                  value="<?=base64_encode($s->agent_id)?>"><?=$s->agent_name?></option>
                                  <?php endforeach;?>
                                  <?php endif; ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <select class="form-control" name="status">
                                  <option value="">Status</option>
                                    <?php 
                                    $list = get_select_module('status');
                                    ?>
                                    <?php if(isset($list) && !empty($list)):?>
                                    <?php foreach($list as $s):?>
                                    <option
                                    <?php echo isset($_GET['status']) && $_GET['status']==$s->status_id ? 'selected' : "";?>
                                    value="<?=$s->status_id?>"><?=$s->status_name?></option>
                                    <?php endforeach;?>
                                    <?php endif; ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <input type="text" name="dfrom" 
                                value="<?php echo isset($_GET['dfrom']) ? $_GET['dfrom'] : "";?>"
                                class="form-control datepicker" placeholder="Date From" />
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <input type="text" name="dto" 
                                value="<?php echo isset($_GET['dto']) ? $_GET['dto'] : "";?>"
                                class="form-control datepicker" placeholder="Date To" />
                              </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <button type="submit" class="btn btnes btn-block btn-success form-control ">Submit</button>
                                </div>
                            </div>
                          </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="table-responsive mob-bord">
            <table class="table table-bordered table-hover" id="leadtable">
               <thead>
                <tr>
                  <th class="list-check"><input type="checkbox" class="check"/></th>
                  <th>Full Name</th>
                  <?php if(auth_id() == 0):?>
                  <th>Number</th>
                  <?php endif;?>
                  <th>Agent</th>
                  <?php if(auth_id() == 0):?>
                  <th>Reference By</th>
                  <?php endif;?>
                  <th>Source</th>
                  <?php if(isset($isf) && $isf=='yes'):?>
                  <th>Followup</th>
                  <?php else:?>
                  <th>Status</th>
                  <?php if(isset($_GET['status']) && $_GET['status'] == 10) { ?>
                    <th>Won Amount</th>
                  <?php } ?>
                  <?php endif;?>
                  <!--<th>Action</th>-->
                </tr>
              </thead>
               <tbody>
                <?php if(isset($all_leads) && !empty($all_leads)):?>
                <?php foreach($all_leads as $l):?>
                <?php if(isset($isf) && $isf=='yes'):?>
                <?php if(get_lead_fdata($l->lead_id,'lead_id') !== ''
                && get_module_value(get_lead_fdata($l->lead_id,'followup_status_id'),'status') !== 'Won'
                && get_module_value(get_lead_fdata($l->lead_id,'followup_status_id'),'status') !== 'Lost'):?>
                <?php 
                $sstyle = (date("Y-m-d H:i",strtotime(get_lead_fdata($l->lead_id,'followup_date'))) < date("Y-m-d H:i")) ? "expired" : "available";
                ?>
                <tr class="<?=$sstyle?>">
                    <td class="list-check">
                    <input type="checkbox" class="checkme" name="radioGroup" value="<?=base64_encode($l->lead_id)?>" />
                    </td>
                  <td style="cursor:pointer;"
                onclick="location.href='<?=base_url()?>followup/?lead=<?=base64_encode($l->lead_id)?>';">
                      <?=$l->full_name?>
                  </td>
                  <?php if(auth_id() == 0):?>
                  <td style="cursor:pointer;"
                onclick="location.href='<?=base_url()?>followup/?lead=<?=base64_encode($l->lead_id)?>';"><?=$l->contact_no?></td>
                <?php endif;?>
                  <td style="cursor:pointer;"
                onclick="location.href='<?=base_url()?>followup/?lead=<?=base64_encode($l->lead_id)?>';"><?=get_module_value($l->assign_to_agent, 'agent')?></td>
                  <?php if(auth_id() == 0):?>
                  <td style="cursor:pointer;"
                onclick="location.href='<?=base_url()?>followup/?lead=<?=base64_encode($l->lead_id)?>';"><?=$l->reference_contact_number?></td>
                  <?php endif;?>
                  <td style="cursor:pointer;"
                onclick="location.href='<?=base_url()?>followup/?lead=<?=base64_encode($l->lead_id)?>';"><?=get_module_value($l->lead_source,'lead_source')?></td>
                  <?php 
                    $sstyle = (date("Y-m-d h:i", strtotime(get_lead_fdata($l->lead_id,'followup_status_id')))
                    < date("Y-m-d h:i")) ? "expired" : "available";
                  ?>
                  <td><?=date(get_config_item('date_php_datetime_format'), strtotime(get_lead_fdata($l->lead_id,'followup_date'))) ." [ ".
                  get_module_value(get_lead_fdata($l->lead_id,'followup_status_id'),'status')." ]"?></td>
                  <?php if(isset($_GET['status']) && $_GET['status'] == '10') { ?>
                    <td>Rs. <?= get_lead_fdata($l->lead_id, 'followup_won_amount') ?></td>
                    <?php $won_amount_total += get_lead_fdata($l->lead_id, 'followup_won_amount') != '' ? get_lead_fdata($l->lead_id, 'followup_won_amount') : 0; ?>
                  <?php } ?>
                </tr>
                <?php endif;?>
                <?php else:?>
                
                <?php 
                $sstyle = (date("Y-m-d H:i",strtotime(get_lead_fdata($l->lead_id,'followup_date'))) < date("Y-m-d H:i")) ? "expired" : "available";
                ?>
                <tr class="<?=$sstyle?>">
                  <td class="list-check">
                    <?php if(strtolower(get_module_value($l->status,'status'))!='lost'
                    && strtolower(get_module_value($l->status,'status'))!='won'):?>
                    <input type="checkbox" class="checkme" name="radioGroup" value="<?=base64_encode($l->lead_id)?>" />
                    <?php endif;?>
                    </td>
                  <td style="cursor:pointer;"
                onclick="location.href='<?=base_url()?>followup/?lead=<?=base64_encode($l->lead_id)?>';">
                    <?=$l->full_name?>
                  </td>
                  <td style="cursor:pointer;"
                onclick="location.href='<?=base_url()?>followup/?lead=<?=base64_encode($l->lead_id)?>';"><?=$l->contact_no?></td>
                  <td style="cursor:pointer;"
                onclick="location.href='<?=base_url()?>followup/?lead=<?=base64_encode($l->lead_id)?>';"><?=get_module_value($l->assign_to_agent, 'agent')?></td>
                  <td style="cursor:pointer;"
                onclick="location.href='<?=base_url()?>followup/?lead=<?=base64_encode($l->lead_id)?>';"><?=get_module_value($l->service,'product_service')?></td>
                <td style="cursor:pointer;"
                onclick="location.href='<?=base_url()?>followup/?lead=<?=base64_encode($l->lead_id)?>';"><?=get_module_value($l->lead_source,'lead_source')?></td>
                  <td style="cursor:pointer;"
                onclick="location.href='<?=base_url()?>followup/?lead=<?=base64_encode($l->lead_id)?>';"><?=get_module_value($l->status,'status')?></td>
                  <?php if(isset($_GET['status']) && $_GET['status'] == '10') { ?>
                    <td>Rs. <?= get_lead_fdata($l->lead_id, 'followup_won_amount') ?></td>
                    <?php $won_amount_total += get_lead_fdata($l->lead_id, 'followup_won_amount') != '' ? get_lead_fdata($l->lead_id, 'followup_won_amount') : 0; ?>
                  <?php } ?>
                </tr>
                <?php endif;?>
                <?php endforeach; ?>
                <?php endif;?>
              </tbody>
            </table>
            <div>
                  <button type="button" onclick="deleteSelected('lead')" 
                  class="btn btn-danger pull-left">Delete</button>
                  <?php if(isset($_GET['status']) && $_GET['status'] == '10') { ?>
                  <h4 class="pull-right">Total Won Amount - Rs. <?= $won_amount_total; ?></h4>
                  <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
