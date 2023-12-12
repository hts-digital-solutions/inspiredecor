<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>
<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd">
            <div class="panel-heading">
                <h5>New ToDo</h5>
            </div>
            <div class="panel-body">
                <form action="<?=base_url()?>task/process_data/add<?php echo isset($_GET['ref'])?"?ref=".$_GET['ref']:'';?>" method="post">
                <div class="row">
                    <input type="hidden" name="task_id" 
                    value="<?php echo isset($task->task_id) ? base64_encode($task->task_id) : '';?>"
                    />
                    <div class="col-md-1"><label>Subject</label></div>
                    <div class="form-group col-md-5">
                        <input type="text" name="subject" class="form-control"
                        value="<?php echo isset($task->task_name) ? $task->task_name : '';?>"
                        required/>
                    </div>
                    <div class="col-md-1">
                        <label>Status</label>
                    </div>
                    <div class="form-group col-md-5">
                        <select class="form-control" name="status" id="status">
                          <option value="">Select</option>
                            <?php 
                            $list = get_select_module('task_status');
                            ?>
                            <?php if(isset($list) && !empty($list)):?>
                            <?php foreach($list as $s):?>
                            <option
                            <?php echo isset($task->task_status) && $task->task_status==$s->task_status_id ? 
                            'selected': '';?>
                            value="<?=$s->task_status_id?>"><?=$s->task_status_name?></option>
                            <?php endforeach;?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="">Priority</label>
                    </div>
                    <div class="form-group col-md-5">
                        <select class="form-control" name="priority" id="priority">
                            <option value="">Select</option>
                            <option 
                            <?php echo isset($task->task_priority) && $task->task_priority==10 ? 
                            'selected': '';?>
                            value="10">High</option>
                            <option 
                            <?php echo isset($task->task_priority) && $task->task_priority==5 ? 
                            'selected': '';?>
                            value="5">Medium</option>
                            <option 
                            <?php echo isset($task->task_priority) && $task->task_priority==0 ? 
                            'selected': '';?>
                            value="0">Low</option>
                        </select>
                    </div>
                    <div class="col-md-1"><label>Date</label></div>
                    <div class="form-group col-md-5">
                        <input type="text" id="task_date" name="date" 
                        autocomplete="off" class="form-control" 
                        value="<?php echo isset($task->task_date) ? date("d-m-Y h:i:s A",strtotime($task->task_date)) : '';?>"
                        />
                    </div>
                    <?php if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
                    && $_SESSION['roll']!=='admin'):?>
                    <input type="hidden" name="agent" value="<?= decrypt_me($_SESSION['login_id'])?>"/>
                    <?php else:?>
                    <div class="col-md-1">
                        <label>Agent</label>
                    </div>
                    <div class="form-group col-md-5">
                        <select class="form-control" name="agent" id="agent">
                          <option value="">Select</option>
                            <?php 
                            $list = get_select_module('agent');
                            ?>
                            <?php if(isset($list) && !empty($list)):?>
                            <?php foreach($list as $s):?>
                            <option
                            <?php echo isset($task->agent_id) && $task->agent_id==$s->agent_id ? 
                            'selected': '';?>
                            value="<?=$s->agent_id?>"><?=$s->agent_name?></option>
                            <?php endforeach;?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <?php endif;?>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-1">
                                <label>Access To</label>
                            </div>
                            <div class="form-group col-md-11">
                                <div class="form-control" style="min-height:200px;overflow-y:auto;overflow-x:hidden;">
                                  <div class="row">
                                      <?php 
                                        $list = get_select_module('agent');
                                        ?>
                                        <?php if(isset($list) && !empty($list)):?>
                                        <?php foreach($list as $s):?>
                                        <?php if($s->agent_id != auth_id()):?>
                                        <label class="col-md-4">
                                            <input type="checkbox" name="access_to_id[]" <?php echo isset($task->access_to_id) && in_array($s->agent_id, explode(",", $task->access_to_id)) ? 'checked': '';?> value="<?=$s->agent_id?>"/>
                                            <?=$s->agent_name?>
                                        </label>
                                        <?php endif; ?>
                                        <?php endforeach;?>
                                        <?php endif;?>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"><label>Description</label></div>
                    <div class="form-group col-md-11">
                        <textarea name="desc" class="form-control"><?php echo isset($task->description) ? $task->description : '';?></textarea>
                    </div>
                    <div class="from-group col-md-2" style="float:right;">
                        <button class="btn btn-sm btn-primary form-control" 
                        style="float:right;" type="submit">Submit</button>
                    </div>
                </div>
                </form>
                <br/>
                <div class="col-md-12">
                     <div class="table-responsive border-tbal">
                    <table class="table" id="task_c_table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Commented By</th>
                                <th>Status</th>
                                <th>Date and Time</th>
                                <th>Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($tcomments) && !empty($tcomments)): ?>
                            <?php $i=1; foreach($tcomments as $c):?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?php echo $c->commented_by!=0 ? get_module_value($c->commented_by,'agent') : 'Admin'?></td>
                                <td><?=get_module_value($c->status,'task_status')?></td>
                                <td><?=date("d-m-Y h:i:s A",strtotime($c->dateandtime))?></td>
                                <td><?=$c->comments?></td>
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
</section>
