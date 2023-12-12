
<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>
<?php
$tabindex=1;
if(isset($_GET['existing']) && !empty($_GET['existing'])){
    $c = array(
        "full_name" => "client_name",
        "email_id" => "client_email",
        "company_name" => "client_company",
        "website" => "client_website",
        "contact_no" => "client_mobile",
        "position" => "client_position",
        "alternative_no" => "client_alt_no",
        "full_address" => "client_fulladdress",
        "country" => "client_country",
        "state" => "client_state",
        "city" => "client_city",
        "pincode" => "client_pincode"
    );
}else{
    $c = array();
}
?>
<section class="content content-header pd-lft">
   <div class="row">
       
      <div class="col-sm-12">
         <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable">
            <div class="panel-heading ui-sortable-handle">
               <div class="btn-group"><p>Lead Information </p></div>
               <button type="button" style="float:right;" 
               class="btn btn-sm btn-primary" data-toggle="modal" data-target="#custome">
                Add Custom Field</button>
            </div>
            <div class="panel-body">
               <form 
               action="<?=base_url()?>lead/<?php echo isset($lead) && !empty($lead) ? 'add_new_lead' : 'add_new_lead';?>"
               name="addlead" id="addlead" method="post">
                <?php if(isset($all_details) && !empty($all_details)):?>
                    <input type="hidden" name="client_id" 
                    value="<?php echo (isset($lead->client_id))? $lead->client_id : ''; ?>" />
                    <?php foreach($all_details as $ad):?>
                    <div class="col-md-6  mob-left-right col-xs-12">
                      <div class="col-md-4 pd-top mobile-hids">
                         <label for="<?=$ad->feild_value_name?>"><?=$ad->feild_name?>
                         <?php if($ad->is_required == 1): ?>
                         <span class="text-danger">*</span>
                         <?php endif;?>
                         </label>
                      </div>
                      <div class="col-md-8 mob-left-right col-xs-12">
                         <div class="form-group">
                            <?php
                            $n = isset($c[$ad->feild_value_name])?$c[$ad->feild_value_name]:$ad->feild_value_name;
                            switch($ad->feild_type){
                                case 'textarea':
                                    $data = array(
                                        'name'  => $ad->feild_value_name,
                                        'id'    => $ad->feild_value_name,
                                        'class' => 'form-control',
                                        'rows'  => 3,
                                        'value' => isset($lead->$n)? $lead->$n : '',
                                        'tabindex' => $tabindex
                                    );
                                    
                                    if($ad->is_required == 1){
                                        $data['required'] = 'required';
                                    }
                                    
                                    echo form_textarea($data);
                                    $tabindex++;
                                    break;
                                case 'select':
                                    $data = array(
                                        'name'  => $ad->feild_value_name,
                                        'id'    => $ad->feild_value_name,
                                        'class' => 'form-control',
                                        'value' => isset($lead->$n)? $lead->$n : '',
                                        'tabindex' => $tabindex
                                    );
                                    if($ad->is_required == 1){
                                        $data['required'] = 'required';
                                    }
                                    $options = array();
                                    if(!empty($ad->option_module)){
                                        $options[''] = 'Select';
                                        $module = get_module_values($ad->option_module);
                                        if(!empty($module)){
                                            foreach($module as $m){
                                                $id = $ad->option_module."_id";
                                                $name = $ad->option_module."_name";
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
                                        $ov = explode(",",$ad->feild_options_value);
                                        $ovn = explode(",",$ad->feild_options);
                                        $options[''] = 'Select';
                                        for($i=0; $i<count($ov); $i++){
                                            $options[$ov[$i]] = $ovn[$i];
                                        }
                                    }
                                    echo form_dropdown($data, $options, isset($lead->$n)? $lead->$n : (isset($_GET['existing'])&&$_GET['existing']!=''?17:''));
                                    $tabindex++;
                                    break;
                                case 'radio':
                                    $ov = explode(",",$ad->feild_options_value);
                                    $ovn = explode(",",$ad->feild_options);
                                    $lv = isset($lead->$n)? explode(",",$lead->$n):array();
                                    for($i=0; $i<count($ov); $i++){
                                        $checked = in_array($ov[$i], $lv) ? 'checked' : '';
                                        $c = '<label class="clabel" for="'.$ov[$i].'"><input type="radio" id="'.$ov[$i].'"';
                                        $c .= 'name="'.$ad->feild_value_name.'" value="'.$ov[$i].'" '.$checked.' '.'tabindex="'. $tabindex.'"/>'.$ovn[$i].'</label>';
                                        echo $c;
                                        $tabindex++;
                                    }
                                    break;
                                case 'checkbox':
                                    $ov = explode(",",$ad->feild_options_value);
                                    $ovn = explode(",",$ad->feild_options);
                                    $lv = isset($lead->$n)? explode(",",$lead->$n):array();
                                    for($i=0; $i<count($ov); $i++){
                                        $checked = in_array($ov[$i], $lv) ? 'checked' : '';
                                        $c = '<label class="clabel" for="'.$ov[$i].'"><input type="checkbox" id="'.$ov[$i].'"';
                                        $c .= 'name="'.$ad->feild_value_name.'[]" value="'.$ov[$i].'" '.$checked.' tabindex="'.$tabindex.'"/>'.$ovn[$i].'</label>';
                                        echo $c;
                                        $tabindex++;
                                    }
                                    break;
                                default:
                                    $data = array(
                                        'type'  => $ad->feild_type,
                                        'name'  => $ad->feild_value_name,
                                        'id'    => $ad->feild_value_name,
                                        'placeholder' => $ad->feild_name,
                                        'class' => 'form-control',
                                        'value' => isset($lead->$n)? $lead->$n : '',
                                        'tabindex' => $tabindex
                                    );
                                    if($ad->is_required == 1){
                                        $data['required'] = 'required';
                                    }
                                    echo form_input($data);
                                    $tabindex++;
                            }
                            
                            ?>
                            <span class="text-danger ferror">
                             <?php if(isset($_SESSION['al_ferror'][$ad->feild_value_name])): ?>
                             <?=$_SESSION['al_ferror'][$ad->feild_value_name]?>
                             <?php endif;?>
                         </span>
                         </div>
                      </div>
                    </div>
                    <?php endforeach;?>
                <?php endif; ?> 
                <?php if(isset($sections) && !empty($sections)):?>
                <?php foreach($sections as $s):?>
                <?php if($s->section_id != 1):?>
                <div class="col-sm-6 mob-left-right col-xs-12">
                   <div class="row">
                      <div class="row address_information" <?php echo ($s->section_id==2) ? '':''?>>
                         <div class="address-sec">
                            <?= $s->section_name ?>
                         </div>
                      </div>
                      <div class="col-md-12">
                      <?php $fields = get_fields($s->section_id); ?>
                      <?php if(isset($fields) && !empty($fields)):?>
                      <?php foreach($fields as $f):?>
                      <?php 
                        if(isset($f->for_ip) && !empty($f->for_ip) && $f->for_ip!=$_SERVER['REMOTE_ADDR'].":".$this->agent->browser()){
                            continue;
                        }else if(isset($f->for_lead_only) && !empty($f->for_lead_only)){
                            continue;
                        }else if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
            && $_SESSION['roll']!=='admin' && $f->feild_value_name=='assign_to_agent'){ continue;}
                      ?>
                      <div class="col-md-4 pd-top mobile-hids">
                         <label for="<?=$f->feild_value_name?>"><?=$f->feild_name?>
                         <?php if($f->is_required == 1): ?>
                         <span class="text-danger">*</span>
                         <?php endif;?>
                         </label>
                      </div>
                      <div class="col-md-8 mob-left-right col-xs-12  card">
                            <?php
                            $n = isset($c[$f->feild_value_name])?$c[$f->feild_value_name]:$f->feild_value_name;
                            switch($f->feild_type){
                                case 'textarea':
                                    $data = array(
                                        'name'  => $f->feild_value_name,
                                        'id'    => $f->feild_value_name,
                                        'class' => 'form-control',
                                        'rows'  => 3,
                                        'value' => isset($lead->$n)? $lead->$n : '',
                                        'tabindex' => $tabindex
                                    );
                                    if($f->is_required == 1){
                                        $data['required'] = 'required';
                                    }
                                    echo form_textarea($data);
                                    $tabindex++;
                                    break;
                                case 'select':
                                    $data = array(
                                        'name'  => $f->feild_value_name,
                                        'id'    => $f->feild_value_name,
                                        'class' => 'form-control',
                                        'value' => isset($lead->$n)? $lead->$n : '',
                                        'tabindex' => $tabindex
                                    );
                                    if($f->is_required == 1){
                                        $data['required'] = 'required';
                                    }
                                    $options = array();
                                    if(!empty($f->option_module)){
                                        $options[''] = 'Select';
                                        $module = get_module_values($f->option_module);
                                        if(!empty($module)){
                                            foreach($module as $m){
                                                $id = $f->option_module."_id";
                                                $name = $f->option_module."_name";
                                                $options[$m->$id] = $m->$name;
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
                                    echo form_dropdown($data, $options, isset($lead->$n)? $lead->$n : '');
                                    $tabindex++;
                                    break;
                                case 'radio':
                                    $ov = explode(",",$f->feild_options_value);
                                    $ovn = explode(",",$f->feild_options);
                                    $lv = isset($lead->$n)? explode(",",$lead->$n):array();
                                    for($i=0; $i<count($ov); $i++){
                                        $checked = in_array($ov[$i], $lv) ? 'checked' : '';
                                        $c = '<label class="clabel" for="'.$ov[$i].'"><input type="radio" id="'.$ov[$i].'"';
                                        $c .= 'name="'.$f->feild_value_name.'" value="'.$ov[$i].'" '.$checked.' tabindex="'.$tabindex.'"/>'.$ovn[$i].'</label>';
                                        echo $c;
                                        $tabindex++;
                                    }
                                    break;
                                case 'checkbox':
                                    $ov = explode(",",$f->feild_options_value);
                                    $ovn = explode(",",$f->feild_options);
                                    $lv = isset($lead->$n)? explode(",",$lead->$n):array();
                                    for($i=0; $i<count($ov); $i++){
                                        $checked = in_array($ov[$i], $lv) ? 'checked' : '';
                                        $c = '<label class="clabel" for="'.$ov[$i].'"><input type="checkbox" id="'.$ov[$i].'"';
                                        $c .= 'name="'.$f->feild_value_name.'[]" value="'.$ov[$i].'" '.$checked.' tabindex="'.$tabindex.'"/>'.$ovn[$i].'</label>';
                                        echo $c;
                                        $tabindex++;
                                    }
                                    break;
                                default:
                                    $data = array(
                                        'type'  => $f->feild_type,
                                        'name'  => $f->feild_value_name,
                                        'id'    => $f->feild_value_name,
                                        'placeholder' => $f->feild_name,
                                        'class' => 'form-control',
                                        'value' => isset($lead->$n)? $lead->$n : '',
                                        'tabindex' => $tabindex
                                    );
                                    if($f->is_required == 1){
                                        $data['required'] = 'required';
                                    }
                                    echo form_input($data);
                                    $tabindex++;
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
                            <span class="text-danger ferror">
                             <?php if(isset($_SESSION['al_ferror'][$f->feild_value_name])): ?>
                             <?=$_SESSION['al_ferror'][$f->feild_value_name]?>
                             <?php endif;?>
                         </span>
                        </div>
                        
                      <?php endforeach;?>
                      <?php endif;?>
                      </div>
                   </div>
                </div>
                <?php endif;?>
                <?php endforeach;?>
                <?php endif;?>  
                <div class="col-md-6  mob-left-right col-xs-12">
                    <div class="address-sec fallowese">
                        Followup
                    </div>
                    <div>
                        <div class="form-group">
                      <div class="col-md-4 pd-top mobile-hids">
                         <label for="followup">Description</label>
                      </div>
                      <div class="col-md-8 mob-left-right col-xs-12  card">
                        <textarea name="followup_desc" 
                        tabindex="<?=$tabindex+1?>"
                        class="form-control"></textarea>   
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4 pd-top mobile-hids">
                         <label for="followup">Followup Date</label>
                      </div>
                      <div class="col-md-8 mob-left-right col-xs-12  card" >
                        <input type="text" id="faddleadf" name="followup" 
                        tabindex="<?=$tabindex+1?>"
                        class="form-control"/>   
                      </div>
                    </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xs-12" style="float:right;">
                    <div class="col-md-5">
                        <label for="addtocal">
                            Add to calender <input type="checkbox" name="addtocal" value="yes" 
                            tabindex="<?=$tabindex+1?>"
                            id="addtocal"/>
                        </label>
                    </div>
                    <input type="hidden" name="isAddNew" id="isAddNew" value="no" />
                    <div class="col-md-4 col-xs-6">
                      <button type="button" onclick="SaveAndAddAnother('yes');" class="btn btnes btn-sm btn-primary fontsize" 
                      tabindex="<?=$tabindex+1?>"
                      >Save and Add another</button>
                    </div>
                    <div class="col-md-3 col-xs-6">
                      <button type="button" onclick="SaveAndAddAnother('no');" class="btn btnes btn-sm btn-primary pull-right fontsize" 
                      tabindex="<?=$tabindex+1?>"
                      >Submit</button>
                    </div>
                </div>
                
               </form> 
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

