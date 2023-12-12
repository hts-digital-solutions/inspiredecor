<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header">
  <div class="row">
    <div class="col-sm-12">
      <div class="addleade">
        <div class="panel-body">
          <div class="export-data">
              <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="row">
                  <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="btn-group">
                      <a class="btn exports" href="<?=base_url()?>task/add"> <i class="fa fa-plus"></i>&nbsp; New ToDo</a>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="btn-group">
                          <a type="button" id="advS" class="btn btnes exports"> <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Advance</a>
                        </div>
                  </div>
                </div>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="ipades">
                <form id="bulkTaskForm" method="POST">
                  <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                      <div class="btne-group">
                        <p>Bulk Action</p>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <select class="form-control" name="bstatus" id="bstatus">
                          <option value="">Change Status</option>
                            <?php 
                            $list = get_select_module('task_status');
                            ?>
                            <?php if(isset($list) && !empty($list)):?>
                            <?php foreach($list as $s):?>
                            <option
                            value="<?=$s->task_status_id?>"><?=$s->task_status_name?></option>
                            <?php endforeach;?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
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
                        <input type="submit" class="btn btn-primary form-control" value="Submit" />
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
                                    $list = get_select_module('task_status');
                                    ?>
                                    <?php if(isset($list) && !empty($list)):?>
                                    <?php foreach($list as $s):?>
                                    <option
                                    <?php echo isset($_GET['status']) && $_GET['status']==base64_encode($s->task_status_id) ? 'selected' : "";?>
                                    value="<?=base64_encode($s->task_status_id)?>"><?=$s->task_status_name?></option>
                                    <?php endforeach;?>
                                    <?php endif; ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <button type="submit" class="btn btnes btn-block btn-success form-control">Submit</button>
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
          <div class="table-responsive border-tbal">
            <table class="table table-bordered table-hover" id="tasktable">
              <thead>
                <tr>
                  <th class="list-check"><input type="checkbox" class="check"/></th>
                  <th>Subject</th>
                  <th>Status</th>
                  <th>Followup Date</th>
                  <th>Comments</th>
                  <th>Agent Name</th>
                  <th>Priority</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($task) && !empty($task)):?>
                <?php foreach($task as $t):?>
                <?php 
                $sstyle = (date("Y-m-d H:i",strtotime($t->task_date)) < date("Y-m-d H:i")) ? "expired" : "available";
                ?>
                <tr class="<?=$sstyle?>">
                  <td class="list-check">
                    <input type="checkbox" class="checkme" name="radioGroup" value="<?=base64_encode($t->task_id)?>" />
                    </td>
                  <td>
                      <a href="<?=base_url()?>task/add?task=<?=base64_encode($t->task_id)?>">
                      <?php echo ($t->task_status==get_task_status_id('completed')) ? '<strike>'.$t->task_name.'</strike>': $t->task_name?></a>
                      </td>
                  <td><?=get_module_value($t->task_status,'task_status')?></td>
                  <td><?=date(get_config_item('date_php_datetime_format'),strtotime($t->task_date))?></td>
                  <td><?=$t->description?></td>
                  <td><?php echo get_module_value($t->agent_id, 'agent')=='-' ? 'Admin' :
                  get_module_value($t->agent_id, 'agent')?></td>
                  <td>
                  <?php echo ($t->task_priority==10) ? '<span class="btn btn-xs btn-danger">High<span>' 
                  : ($t->task_priority == 5 ? '<span class="btn btn-xs btn-warning">Medium<span>' : 
                  '<span class="btn btn-xs btn-info">Low<span>');
                  ?></td>
                  <td class="butons-table">
                    <a href="<?=base_url()?>task/add?task=<?=base64_encode($t->task_id)?>" title="Edit Task" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                    <a onclick="return confirm('It will delete it Parmamently. Do you want to continue?');" title="Delete Task"
                    href="<?=base_url()?>task/remove?me=<?=base64_encode($t->task_id)?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                   
                    <a  class="btn btn-xs btn-warning" title="Add Comment"
                    onclick="addTaskComment(this)" data-fire-t="<?=base64_encode($t->task_id)?>"><i class="fa fa-comment"></i></a>
                   
                    <a  class="btn btn-xs btn-success" title="Task Completed"
                    onclick="markTaskComplete(this)" data-fire-t="<?=base64_encode($t->task_id)?>"><i class="fa fa-check"></i></a>
                  </td>
                </tr>
                <?php endforeach; ?>
                <?php endif;?>
              </tbody>
            </table>
            <div>
                <a href="<?=base_url()?>report/export_task_data?<?= http_build_query($_GET)?>"
          class="btn btn-primary">Export Whole Data</a>
                  <button type="button" onclick="deleteSelected('task')" 
                  class="btn btn-danger">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section></div>
