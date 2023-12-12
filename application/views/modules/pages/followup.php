<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header pd-lft">
   <div class="row">
      <div class="col-sm-12">
       <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
             <div class=" panel-heading ui-sortable-handle">
          <div class="col-md-6 col-xs-6">
            <div class="btn-group"><p>Followup</p></div>
          </div>
          <div class="col-md-6 col-xs-6">
            <div class="reset-buttons">
               <button type="button" 
               class="btn btn-sm btn-primary" data-toggle="modal" data-target="#custome">
                Add Custom Field</button>
               </div>
            </div>
          </div>
       
          <?php if(isset($lead) && !empty($lead)):?>
            <div class="panel-body">
               <div class="col-sm-12 col-md-12 col-xs-12 ">
                  <div class="cards">
                     <div class="card-headers lead_fallow">
                        <div class="table-responsive mob-bord">
                              <form action="<?=base_url()?>lead/add_followup" name="addfollowup" id="addfollowup" method="post">
                                 
                                     <div class="row">
                                        
                                            <div class="mai-falows">
                                               <div class="col-md-6 left-border">
                                                 <div class="row bottoms-border">
                                                 <div class="col-md-4 col-xs-4">
                                                   <lable>Full Name  </lable>
                                                   </div>
                                                   <div class="col-md-8 col-xs-8">
                                                      
                                        <input type="hidden" name="lead_id" 
                                        value="<?php echo (isset($lead->lead_id))? $lead->lead_id : ''; ?>" />
                                        <input type="hidden" id="lmobile" 
                                        value="<?php echo (isset($lead->contact_no))? $lead->contact_no : ''; ?>" />
                                        <?php echo isset($lead->full_name)? $lead->full_name : '';?>
                                                   </div>
                                                   
                                                 </div>
                                                 <div class="row bottoms-border">
                                                     <div class="col-md-4 col-xs-4">Email Id</div>
                                                     <div class="col-md-8 col-xs-8"><?php echo isset($lead->email_id)? $lead->email_id : '';?></div>
                                                     
                                                 </div>
                                                 <div class="row bottoms-border">
                                                     <div class="col-md-4 col-xs-4">
                                                         <lable>Contact No.</lable>
                                                     </div>
                                                     <div class="col-md-8 col-xs-8">
                                                         <a href="tel:<?php echo isset($lead->contact_no)? $lead->contact_no : '';?>"><?php echo isset($lead->contact_no)? $lead->contact_no : '';?></a>
                                                     </div>
                                                    
                                                 </div>
                                                 <div class="row bottoms-border">
                                                     <div class="col-md-4 col-xs-4">
                                                         <lable>Service</lable>
                                                     </div>
                                                      <div class="col-md-8 col-xs-8">
                                                          <?php echo isset($lead->service)? get_module_value($lead->service,'product_service') : '';?>
                                                      </div>
                                                 </div>
                                                 <div class="row bottoms-border">
                                                     <div class="col-md-4 col-xs-4">
                                                         <lable>Lead Source</lable>
                                                     </div>
                                                     <div class="col-md-8 col-xs-8">
                                                        <?php echo isset($lead->lead_source)? get_module_value($lead->lead_source,'lead_source') : '';?> 
                                                     </div>
                                                 </div>
                                                 <div class="row bottoms-border none-border">
                                                     <div class="col-md-4 col-xs-4 pd-top"><lable>Agent Name </lable></div>
                                                     <div class="col-md-8 col-xs-8">
                                                          <select class="form-controls" name="followup_asign">
                                            <option value="">Assign to Agent</option>
                                            <?php 
                                            $list = get_select_module('agent');
                                            ?>
                                            <?php if(isset($list) && !empty($list)):?>
                                            <?php foreach($list as $s):?>
                                            <option value="<?=$s->agent_id?>"
                                            <?php echo ($lead->assign_to_agent==$s->agent_id) ? 'selected' : ''; ?>
                                            ><?=$s->agent_name?></option>
                                            <?php endforeach;?>
                                            <?php endif; ?>
                                          </select>
                                                     </div>
                                                 </div>
                                            </div>
                                    <div class="col-md-6">
                                            <div class="row status-bottom">
                                                <div class="col-md-4 col-xs-4 pd-top">
                                                    <lable>Status</lable>
                                                 </div> 
                                                <div class="col-md-8 col-xs-8">  
                                                
                                            <select class="form-controls" name="followup_status" onchange="fireFS()" id="followup_status" required>
                                            <option value="">Select Status</option>
                                            <?php 
                                            $list = get_select_module('status');
                                            ?>
                                            <?php if(isset($list) && !empty($list)):?>
                                            <?php foreach($list as $s):?>
                                            <option
                                            <?php echo get_lead_fdata($lead->lead_id,'followup_status_id') == $s->status_id ?
                                            'selected' : '';?>
                                            value="<?=$s->status_id?>"><?=$s->status_name?></option>
                                            <?php endforeach;?>
                                            <?php endif; ?>
                                          </select>
                                            <select class="form-controls" name="lost_reason_id" style='display:none;' id="lost_reason_id">
                                            <option value="">Lost Reason</option>
                                            <?php 
                                            $list = get_select_module('lost_reason');
                                            ?>
                                            <?php if(isset($list) && !empty($list)):?>
                                            <?php foreach($list as $s):?>
                                            <option value="<?=$s->lost_reason_id?>"><?=$s->lost_reason_name?></option>
                                            <?php endforeach;?>
                                            <?php endif; ?>
                                          </select>
                                            <input type="number" class="form-controls" name="won_amount" style='display:none;' id="won_amount">
                                             </div>
                                             </div>
                                              <div class="row status-bottom">
                                                 <div class="col-md-4 pd-top col-xs-4">Followup</div>
                                               <div class="col-md-8 col-xs-8">
                                                 <input type="text" name="followup_date" id="followup_date" 
                                          class="form-controls" placeholder="Followup date" 
                                          value="<?= get_lead_fdata($lead->lead_id,'followup_date') != '0000-00-00 00:00:00' && 
                                          get_lead_fdata($lead->lead_id,'followup_date') != ''?
                                          date(get_config_item('date_php_datetime_format'),strtotime(get_lead_fdata($lead->lead_id,'followup_date'))) : ''
                                          ?>"
                                          required>
                                             </div>
                                             </div>
                                             <div class="row status-bottom">
                                                  <div class="col-md-4 pd-top col-xs-4">
                                                        <lable>Description</lable> 
                                                     </div>
                                             <div class="col-md-8 col-xs-8">
                                             <textarea class="form-controls text-areasss" rows="3" name="followup_desc" id="followup_desc" placeholder="Enter description..." required><?php //echo get_lead_fdata($lead->lead_id,'followup_desc')?></textarea>
                                             </div>
                                             </div>
                                             
                                             <div class="row">
                                                <div class="col-md-12"> 
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">
                                                <div class="col-md-12">
                                                    <div class="add_calender">
                                            <label for="is_cal">
                                                Add to Calender 
                                                <input type="checkbox" id="is_cal" name="is_cal" value="yes"/>
                                            </label>
                                            </div>
                                    </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-xs-6">
                                                        <input type="submit" name="submit" value="Submit" class="btn btenss form-control btn-success">
                                                      </div>
                                                       <div class="col-md-6 col-xs-6">
                                                  <input type="button" onclick="openSmsM();" name="sms" value="Send SMS" class="btn btn-warning paddingsss form-control">
                                          </div>
                                         <div id="smsModal" class="modal fade" role="dialog">
                                              <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">SMS Content</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                    <label>Enter content</label>
                                                    <textarea class="form-controls" id="smsC"></textarea>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" onclick="sendFsms();">Send</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                  </div>
                                                </div>
                                            
                                              </div>
                                            </div></div>
                                            </div>
                              </div></div>
                                     </div>
                                            </div>
                                     
                                            
                                             
                                              
                                        </div>  
                                </div>
                             
                              </form>
                           </div>
                        
                   
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs mobiltabs bottom-border">
                       <li class="active"><a href="#tab6" data-toggle="tab" aria-expanded="true"><span class="tabnone">History</span> <i class="fa fa-history" aria-hidden="true"></i></a></li>
                     <li class=""><a href="#tab3" data-toggle="tab" aria-expanded="false"><span class="tabnone">All Details </span><i class="fa fa-info-circle" aria-hidden="true"></i></a></li>
                     <li class=""><a href="#tab4" data-toggle="tab" aria-expanded="false"><span class="tabnone">Additional Information </span><i class="fa fa-info" aria-hidden="true"></i></a></li>
                     <li class=""><a href="#tab5" data-toggle="tab" aria-expanded="true"><span class="tabnone">Attachment </span><i class="fa fa-paperclip" aria-hidden="true"></i></a></li>
                    
                  </ul>
                  <div class="cards-tab">
                     <div class="tab-content">
                        <!---------------------------------------------tab2------------------------------->
                        <div class="tab-pane fade" id="tab3">
                         <form action="<?=base_url()?>lead/update_lead"
                         name="ldform" method="post" enctype="multipart/form-data">
                           <div class="panel-body border-tbal">
                              <div class="row">
                                    <?php if(isset($all_details) && !empty($all_details)):?>
                                    <input type="hidden" name="lead_id" 
                                    value="<?php echo (isset($lead->lead_id))? $lead->lead_id : ''; ?>" />
                                    <?php foreach($all_details as $ad):?>
                                    <div class="col-md-6 col-xs-12 card">
                                        <div class="col-md-4 col-xs-12 pd-top">
                                            <label for="<?=$ad->feild_value_name?>"><?=$ad->feild_name?></label>
                                        </div>
                                        <div class="col-md-8 col-xs-12">
                                            <?php
                                            $n = $ad->feild_value_name;
                                            switch($ad->feild_type){
                                                case 'textarea':
                                                    $data = array(
                                                        'name'  => $ad->feild_value_name,
                                                        'id'    => $ad->feild_value_name,
                                                        'class' => 'form-control',
                                                        'rows'  => 3,
                                                        'value' => isset($lead->$n)? $lead->$n : ''
                                                    );
                                                    
                                                    echo form_textarea($data);
                                                    break;
                                                case 'select':
                                                    $data = array(
                                                        'name'  => $ad->feild_value_name,
                                                        'id'    => $ad->feild_value_name,
                                                        'class' => 'form-control',
                                                        'value' => isset($lead->$n)? $lead->$n : ''
                                                    );
                                                    $options = array();
                                                    if(!empty($ad->option_module)){
                                                        $options[''] = 'Select';
                                                        $module = get_module_values($ad->option_module);
                                                        if(!empty($module)){
                                                            foreach($module as $m){
                                                                $id = $ad->option_module."_id";
                                                                $name = $ad->option_module."_name";
                                                                $options[$m->$id] = $m->$name;
                                                            }  
                                                        }
                                                    }else{
                                                        $ov = explode(",",$ad->feild_options_value);
                                                        $ovn = explode(",",$ad->feild_options);
                                                        $options[''] = 'Select';
                                                        for($i=0; $i<count($ov); $i++){
                                                            $options[$ov[$i]] = $ovn[$i];
                                                        }
                                                    }
                                                    echo form_dropdown($data, $options, isset($lead->$n)? $lead->$n : '');
                                                    break;
                                                case 'radio':
                                                    $ov = explode(",",$ad->feild_options_value);
                                                    $ovn = explode(",",$ad->feild_options);
                                                    $lv = isset($lead->$n)? explode(",",$lead->$n):array();
                                                    for($i=0; $i<count($ov); $i++){
                                                        $checked = in_array($ov[$i], $lv) ? 'checked' : '';
                                                        $c = '<label class="clabel" for="'.$ov[$i].'"><input type="radio" id="'.$ov[$i].'"';
                                                        $c .= 'name="'.$ad->feild_value_name.'" value="'.$ov[$i].'" '.$checked.'/>'.$ovn[$i].'</label>';
                                                        echo $c;
                                                    }
                                                    break;
                                                case 'checkbox':
                                                    $ov = explode(",",$ad->feild_options_value);
                                                    $ovn = explode(",",$ad->feild_options);
                                                    $lv = isset($lead->$n)? explode(",",$lead->$n):array();
                                                    for($i=0; $i<count($ov); $i++){
                                                        $checked = in_array($ov[$i], $lv) ? 'checked' : '';
                                                        $c = '<label class="clabel" for="'.$ov[$i].'"><input type="checkbox" id="'.$ov[$i].'"';
                                                        $c .= 'name="'.$ad->feild_value_name.'[]" value="'.$ov[$i].'" '.$checked.'/>'.$ovn[$i].'</label>';
                                                        echo $c;
                                                    }
                                                    break;
                                                default:
                                                    $data = array(
                                                        'type'  => $ad->feild_type,
                                                        'name'  => $ad->feild_value_name,
                                                        'id'    => $ad->feild_value_name,
                                                        'placeholder' => $ad->feild_name,
                                                        'class' => 'form-control',
                                                        'value' => isset($lead->$n)? $lead->$n : ''
                                                    );
                                                    
                                                    echo form_input($data);
                                            }
                                            
                                            ?>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                    <?php endif; ?>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <div class="row">
                                        <div class="col-md-12">
                                        <div class="col-md-8 col-xs-8"></div>
                                        <div class="col-md-4 col-xs-4">
                                 <button type="submit" class="btn btn-sm btn-primary form-control">Submit</button>  
                                 </div></div>
                              </div>
                              </div>
                              </div>
                             
                           </div>
                         </form>
                        </div>
                        <!---------------------------------------------tab2------------------------------->         
                        <div class="tab-pane fade" id="tab4">
                         <form action="<?=base_url()?>lead/update_lead"
                         name="ldform" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="lead_id" 
                            value="<?php echo (isset($lead->lead_id))? $lead->lead_id : ''; ?>" />
                           
                              <div class="row">
                                    <?php if(isset($sections) && !empty($sections)):?>
                                    <?php foreach($sections as $s):?>
                                    <?php if($s->section_id != 1):?>
                                    <div class="col-sm-6 col-xs-12 ">
                                       <div class="card-headers">
                                          <div class="col-md-12 pd-0">
                                             <div class="address-sec">
                                                <?= $s->section_name ?>
                                             </div>
                                          </div>
                                          <?php $fields = get_fields($s->section_id); ?>
                                          <?php if(isset($fields) && !empty($fields)):?>
                                          <?php foreach($fields as $f):?>
                                          <?php 
                                            if(isset($f->for_lead_only) && $f->for_lead_only!=0 && $f->for_lead_only!=base64_decode(isset($_GET['lead']) ? $_GET['lead'] : '')){
                                                continue;
                                            }
                                            if(isset($f->for_ip) && !empty($f->for_ip) && $f->for_ip!=$_SERVER['REMOTE_ADDR'].":".$this->agent->browser()){
                                                continue;
                                            }
                                            if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
                                            && $_SESSION['roll']!=='admin' && $f->feild_value_name=='assign_to_agent'){continue;}
                                          ?>
                                          <div class="col-md-4 pd-top">
                                             <label for="<?=$f->feild_value_name?>"><?=$f->feild_name?></label>
                                          </div>
                                          <div class="col-md-8 card" style="padding:0px;">
                                                <?php
                                                $n = $f->feild_value_name;
                                                switch($f->feild_type){
                                                    case 'textarea':
                                                        $data = array(
                                                            'name'  => $f->feild_value_name,
                                                            'id'    => $f->feild_value_name,
                                                            'class' => 'form-control',
                                                            'rows'  => 3,
                                                            'value' => isset($lead->$n)? $lead->$n : ''
                                                        );
                                                        
                                                        echo form_textarea($data);
                                                        break;
                                                    case 'select':
                                                        $data = array(
                                                            'name'  => $f->feild_value_name,
                                                            'id'    => $f->feild_value_name,
                                                            'class' => 'form-control',
                                                            'value' => isset($lead->$n)? $lead->$n : ''
                                                        );
                                                        $options = array();
                                                        if(!empty($f->option_module)){
                                                            $options[''] = 'Select';
                                                            $module = get_module_values($f->option_module);
                                                            if(!empty($module)){
                                                                foreach($module as $m){
                                                                    $id = $f->option_module."_id";
                                                                    $name = $f->option_module."_name";
                                                                    if($ad->option_module == 'product_service') {
                                                                        if($m->$id != 0) {
                                                                            $options[$m->$id] = $m->$name;
                                                                        }
                                                                    } else {
                                                                        $options[$m->$id] = $m->$name;
                                                                    }
                                                                }  
                                                            }
                                                        }else{
                                                            $ov = explode(",",$f->feild_options_value);
                                                            $ovn = explode(",",$f->feild_options);
                                                            $options[''] = 'Select';
                                                            for($i=0; $i<count($ov); $i++){
                                                                $options[$ov[$i]] = $ovn[$i];
                                                            }
                                                        }
                                                        echo form_dropdown($data, $options,isset($lead->$n)? $lead->$n : '');
                                                        break;
                                                    case 'radio':
                                                        $ov = explode(",",$f->feild_options_value);
                                                        $ovn = explode(",",$f->feild_options);
                                                        $lv = isset($lead->$n)? explode(",",$lead->$n):array();
                                                        for($i=0; $i<count($ov); $i++){
                                                            $checked = in_array($ov[$i], $lv) ? 'checked' : '';
                                                            $c = '<label class="clabel" for="'.$ov[$i].'"><input type="radio" id="'.$ov[$i].'"';
                                                            $c .= 'name="'.$f->feild_value_name.'" value="'.$ov[$i].'" '.$checked.'/>'.$ovn[$i].'</label>';
                                                            echo $c;
                                                        }
                                                        break;
                                                    case 'checkbox':
                                                        $ov = explode(",",$f->feild_options_value);
                                                        $ovn = explode(",",$f->feild_options);
                                                        $lv = isset($lead->$n)? explode(",",$lead->$n):array();
                                                        for($i=0; $i<count($ov); $i++){
                                                            $checked = in_array($ov[$i], $lv) ? 'checked' : '';
                                                            $c = '<label class="clabel" for="'.$ov[$i].'"><input type="checkbox" id="'.$ov[$i].'"';
                                                            $c .= 'name="'.$f->feild_value_name.'[]" value="'.$ov[$i].'" '.$checked.'/>'.$ovn[$i].'</label>';
                                                            echo $c;
                                                        }
                                                        break;
                                                    default:
                                                        $data = array(
                                                            'type'  => $f->feild_type,
                                                            'name'  => $f->feild_value_name,
                                                            'id'    => $f->feild_value_name,
                                                            'placeholder' => $f->feild_name,
                                                            'class' => 'form-control',
                                                            'value' => isset($lead->$n)? $lead->$n : ''
                                                        );
                                                        
                                                        echo form_input($data);
                                                }
                                                if(isset($f->for_ip) && !empty($f->for_ip) && $f->for_ip==$_SERVER['REMOTE_ADDR'].":".$this->agent->browser())
                                                {
                                                    ?>
                                                    <i class="fa fa-trash" 
                                                    style="position: absolute;right: -15px;top: 11px;color: red;cursor:pointer;"
                                                    onclick="deleteField('<?=base64_encode(isset($_SESSION['fforl']) ? $_SESSION['fforl']:'')?>')"></i>
                                                    <?php
                                                }
                                                ?>
                                          </div>
                                          <?php endforeach;?>
                                          <?php endif;?>
                                       </div>
                                    </div>
                                    <?php endif;?>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        
                                        <div class="col-md-12">
                                        <div class="col-md-8 col-xs-8"></div>
                                        <div class="col-md-4 col-xs-4">
                                           <button type="submit" class="btn btn-sm btn-primary form-control">Submit</button>  
                                 </div>
                                 </div>
                             
                              </div>
                              
                              </div>
                             
                          
                         </form>
                        </div>
                        <div class="tab-pane fade" id="tab5">
                           <form id="uploadfile" name="uploadfile" enctype="multipart/form-data">
                            <input type="hidden" name="lead_id" 
                                    value="<?php echo (isset($lead->lead_id))? $lead->lead_id : ''; ?>" />
                            <div class="panel-body border-tbal">
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label class="file-upl-o"> Attach File</label>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <input type="file" name="upload_file" id="upload_file">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <input type="text" name="file_name" id="file_name"
                                    class="form-control" placeholder="Name">
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <button type="submit" class="btn btnss btn-success">Upload</button>
                                 </div>
                              </div>
                              <!-- Progress bar -->
                              <div class="progress">
                                <div class="progress-bar"></div>
                              </div>
                              <span class="text-danger">Max Size : <?=get_config_item('file_max_size')?> bytes</span>
                              <span id="uerror" class="text-danger"></span>
                              <span id="usuccess" class="text-success"></span>
                            </div>
                           </form>
                             <div class="col-md-12">
                               <div class="panel-body border-tbal">
                              <div class="table-responsive mob-bord">
                                 <table class="table table-bordered table-hover" id="uploadtable">
                                    <thead>
                                       <tr>
                                          <th class="list-serila">Serial</th>
                                          <th>Image</th>
                                          <th>Name</th>
                                          <th>Date </th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody id="lead_docs">
                                       <?php if(isset($lead_docs) && !empty($lead_docs)):?>
                                       <?php $i=1; foreach($lead_docs as $ld):?>
                                       <tr>
                                          <td class="list-serila"><?=$i?></td>
                                          <td>
                                              <?php if(in_array($ld->lead_doc_type, array("png","jpg","jpeg"))):?>
                                              <img src="<?php echo !empty($ld->lead_doc_file) ? base_url('resource/system_uploads/lead_docs/').$ld->lead_doc_file : ''; ?>" 
                                              class="img-circle" alt="img" height="30" width="30" style="object-fit:cover;">
                                              <?php elseif($ld->lead_doc_type == 'pdf'):?>
                                              <span style="font-size:2rem;"><i class="fa fa-file-pdf-o"></i></span>
                                              <?php else: ?>
                                              <span style="font-size:2rem;"><i class="fa fa-file-o"></i></span>
                                              <?php endif;?>
                                          </td>
                                          <td><?=$ld->lead_doc_name?></td>
                                          <td><?= date(get_config_item('date_php_datetime_format'), strtotime($ld->created))?></td>
                                          <td>
                                             <a href="<?php echo !empty($ld->lead_doc_file) ? base_url('resource/system_uploads/lead_docs/').$ld->lead_doc_file : ''; ?>" 
                                             download class="btn btn-info btn-xs"><i class="fa fa-download"></i>
                                             </a>
                                             <?php if(in_array($ld->lead_doc_type, array("png","jpg","jpeg","pdf"))):?>
                                             <button type="button" class="btn btn-info btn-xs" onclick="viewThis(this);" data-view="<?=$ld->lead_doc_id?>"><i class="fa fa-eye"></i>
                                             </button>
                                             <?php else:?>
                                             <a href="<?php echo !empty($ld->lead_doc_file) ? base_url('resource/system_uploads/lead_docs/').$ld->lead_doc_file : ''; ?>" 
                                             download class="btn btn-info btn-xs"><i class="fa fa-eye"></i>
                                             </a>
                                             <?php endif;?>
                                             <a onclick="return confirm('It will delete attachment Parmamently. Do you want to continue?');"
                                             href="<?=base_url()?>lead/action?delfile&f=<?=base64_encode($ld->lead_doc_id)?>&fu=<?=base64_encode($ld->lead_doc_file)?>" class="btn btn-danger btn-xs" ><i class="fa fa-trash-o"></i>
                                             </a>
                                          </td>
                                       </tr>
                                       <?php if(in_array($ld->lead_doc_type, array("png","jpg","jpeg","pdf"))):?>
                                       <tr>
                                           <div class="embed_overlay" title="close" onclick="closeThis(<?=$ld->lead_doc_id?>,this);" 
                                           id="ew<?=$ld->lead_doc_id?>"  style="display:none;"></div>
                                           <embed style="display:none;" id="view_<?=$ld->lead_doc_id?>" src="<?php echo !empty($ld->lead_doc_file) ? base_url('resource/system_uploads/lead_docs/').$ld->lead_doc_file : ''; ?>"/>
                                       </tr>
                                       <?php endif;?>
                                       <?php $i++; endforeach;?>
                                       <?php endif; ?>
                                    </tbody>
                                 </table>
                              </div></div>
                           </div>
                           
                        </div>
                        <div class="tab-pane fade active in" id="tab6">
                           <div class="panel-body border-tbal">
                              <div class="table-responsive mob-bord">
                                 <table class="table table-bordered" id="followup_table">
                                    <thead>
                                       <tr>
                                          <th style="width:120px;">NOTES BY</th>
                                          <th>DATE</th>
                                          <th>STATUS</th>
                                          <th>FOLLOWUP</th>
                                          <th>COMMENTS</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(isset($followup) && !empty($followup)):?>
                                    <?php foreach($followup as $f):?>
                                    <?php 
                                    $sstyle = ($f->followup_date < date("Y-m-d H:i")) ? "expired-no" : "available";
                                    ?>
                                       <tr class="<?=$sstyle?>" data-ex="<?=$f->followup_id?>">
                                          <td><?php echo ($f->commented_by==0) ? 'Admin' : get_module_value($f->commented_by,'agent') ?></td>
                                          <td><?= date(get_config_item('date_php_datetime_format'), strtotime($f->created))?></td>
                                          <td><?= get_module_value($f->followup_status_id,'status') ?>
                                          <?php if(strtolower(get_module_value($f->followup_status_id,'status')) == 'lost'):?>
                                          &nbsp;&nbsp;
                                          (<a href="#" class="text-danger" title="<?= get_module_value($f->followup_lost_reason_id,'lost_reason') ?>">reason :- <?= get_module_value($f->followup_lost_reason_id,'lost_reason') ?></a>)
                                          <?php endif;?>
                                          </td>
                                          <td><?= strtolower(get_module_value($f->followup_status_id,'status')) != 'lost'
                                          && strtolower(get_module_value($f->followup_status_id,'status'))!= 'won'? date(get_config_item('date_php_datetime_format'), strtotime($f->followup_date)) : '-'?></td>
                                          <td>
                                             <?= $f->followup_desc ?>
                                          </td>
                                       </tr>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php else:?>
            <p class="text-danger" style="padding:20px;">Lead doesn't exist.</p>
            <?php endif;?>
         </div>
      </div>
   </div>
         </div>
         </div>
        
    
   <div id="custome" class="modal fade" role="dialog" style="position">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add Custom Field</h4>
      </div>
      <div class="modal-body">
        <div class="panel panel-bd lobidrag">
          <div class="panel-body">
            <div class="alert alert-success" id="salert" style="display: none; padding: 2px 10px;"></div>
            <div class="alert alert-danger" id="ealert" style="display: none; padding: 2px 10px;"></div>
            <form name="custom_field" id="custom_field" method="post">
              <div class="row">
                <div class="col-md-3 form-group pd-tops">
                  New Field
                </div>
                <div class="col-md-9 form-group">
                  <input type="hidden" name="forlead" value="yes" id="forlead"/>
                  <input type="hidden" name="feild_id" id="feild_id" />
                  <input type="text" name="feild_name" id="feild_name" class="form-control" placeholder="Field name" required />
                </div>
              </div>
              <div class="row">
                <div class="col-md-9">
                    <?php if(isset($sections) && !empty($sections)):?>
                    <?php foreach($sections as $s): ?>
                    <?php if(strtolower($s->section_name)=='additional information'):?>
                    <input type="text" name="section" id="section" value="<?= $s->section_id ?>" hidden/>
                    <?php endif;?>
                    <?php endforeach; ?>
                    <?php endif;?>
                </div>
              </div>
              <div class="row" id="newsection" style="display: none;">
                <div class="col-md-3 form-group pd-tops">
                  New Section
                </div>
                <div class="col-md-9 form-group">
                  <input type="text" name="new_section" id="new_section" class="form-control" placeholder="New Section name" />
                </div>
              </div>
              <div class="row">
                <div class="col-md-3 form-group pd-tops">
                  Type 
                </div>
                <div class="col-md-9 form-group">
                  <select class="form-control" name="option_type" id="option_type">
                    <option value="">Select Type</option>
                    <optgroup label="Choose">
                      <option value="select">Select</option>
                      <option value="radio">Radio</option>
                      <option value="checkbox">Checkbox</option>
                    </optgroup>
                    <optgroup label="Input">
                      <option value="text">Text</option>
                      <option value="email">Email</option>
                      <option value="file">File</option>
                      <option value="date">Date</option>
                      <option value="time">Time</option>
                      <option value="datetime">Date &amp; Time</option>
                      <option value="textarea">Textarea</option>
                    </optgroup>
                  </select>
                </div>
              </div>
              <!--<div class="table-responsive">-->
                <table class="table table-bordered table-hover" id="makeSortable" style="display: none;">
                  <thead>
                    <tr>
                      <th>Option name <a href="javascript:;" style="float: right;" id="osort">Sort</a></th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="options">
                    <tr id="fop">
                      <td><input type="text" name="option_value_name[]" id="ovn1" class="form-control" placeholder="Option value name" /></td>
                      <td>
                        <button type="button" onclick="add_more_option();" id="addmore" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              <!--</div>-->
              <div class="col-md-9"></div>
              <div class="col-md-3 form-group">
                <div class="reset button text-center">
                  <button type="submit" class="btn btn-sm btn-primary form-control">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</section>