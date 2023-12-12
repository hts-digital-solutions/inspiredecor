<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header">
   <div class="row">
      <div class="col-sm-12">
         <div class="panel panel-bd">
            <div class="panel-heading ">
               <div class="btn-group"> 
                  Import Lead
               </div>
            </div>
            <div class="panel-body">
               <form action="<?=base_url()?>lead/import_lead" id="liform" method="POST" enctype="multipart/form-data">
                  <div class="col-sm-12 col-md-6 col-xs-12">
                     <div class="cards">
                        <div class="card-headers">
                           <div class="importa-leading">
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <lable class="imprt-lable"> Select File</lable>
                                  </div>
                            </div>
                               <div class="col-md-8">
                                  <div class="form-group">
                                     <input type="file" name="leadfile" required="" class="file-set">
                                  </div>
                            </div>
                           </div>
                         <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <select class="form-control" name="group_id" required="">
                                    <option value="">Select Group</option>
                                    <?php if(isset($groups) && !empty($groups)):?>
                                    <?php foreach($groups as $g):?>
                                    <option value="<?=$g->group_id?>"><?=$g->group_name?></option>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                 </select>
                              </div>
                           </div>
                           <?php $fields = array_reverse($fields); if(isset($fields) && !empty($fields)): ?>
                           <?php foreach($fields as $f):?>
                           <?php if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
            && $_SESSION['roll']!=='admin' && $f->feild_value_name=='assign_to_agent'){continue;}?>
                           <?php if($f->feild_type == 'select'):?>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <select class="form-control" name="<?=$f->feild_value_name?>">
                                    <option value="">Select <?=$f->feild_name?></option>
                                    <?php $options = get_module_values($f->option_module); ?>
                                    <?php if(isset($options) && !empty($options)):?>
                                    <?php foreach($options as $o):?>
                                    <?php $id = $f->option_module."_id"; $v = $f->option_module."_name";?>
                                    <option value="<?=$o->$id?>"><?=$o->$v?></option>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                 </select>
                              </div>
                           </div>
                           <?php endif;?>
                           <?php endforeach;?>
                           <?php endif;?>
                           <div class="col-md-6" style="float:right; ">
                               <button class="btn btn-primary form-control" >Next</button>
                           </div><br/>
                           </div>
                            <div class="table-responsive">
                              <table class="table table-bordered table-hover">
                                 <thead>
                                    <tr>
                                       <th>List</th>
                                       <th>Subscriber</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if(isset($groups) && !empty($groups)):?>
                                    <?php foreach($groups as $g):?>
                                    <tr>
                                       <td><a href="<?=base_url()?>lead?group=<?=$g->group_id?>"><?=$g->group_name?></a></td>
                                       <td><?=get_subscriber_count($g->group_id)?></td>
                                       <td>
                                           <a onclick="return confirm('It will delete product Parmamently. Do you want to continue?')"
                                       href="<?=base_url()?>lead/action?delglist&g=<?=base64_encode($g->group_id)?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
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
               </form>
               <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="cards">
                     <div class="card-headers">
                        <form action="<?=base_url()?>lead/<?php echo isset($sg) ? 'update_group' : 'add_group';?>" method="POST">
                          <div class="row">
                           <div class="col-md-3">
                              <lable class="add-gr">Add Group</lable>
                           </div>
                           <div class="col-md-7">
                               <input type="hidden" name="group_id" 
                               value="<?php echo isset($sg->group_id) ? $sg->group_id : ''; ?>">
                              <div class="form-group">
                                 <input type="text" name="group_name"
                                 class="form-control"  required=""
                                 value="<?php echo isset($sg->group_name) ? $sg->group_name : ''; ?>">
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="reset-button">
                                 <button type="submit" class="btn btn-success form-control">
                                     <i class="fa fa-<?php echo isset($sg->group_id) ? 'pencil' : 'plus'; ?>"></i>
                                 </button>
                              </div>
                           </div>
                         </div>
                        </form>
                      
                          <div class="table-responsive">
                           <table class="table table-bordered table-hover">
                              <thead>
                                  <tr>
                                      <th>Group Name</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody id="groupTable">
                                <?php if(isset($groups) && !empty($groups)):?>
                                <?php foreach($groups as $g):?>
                                 <tr data-group="<?=base64_encode($g->group_name)?>">
                                    <td><?=$g->group_name?></td>
                                    <td>
                                       <a href="<?=base_url()?>import-lead?edit=<?=base64_encode($g->group_id)?>&g=true" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                       <a onclick="return confirm('It will delete product Parmamently. Do you want to continue?')"
                                       href="<?=base_url()?>lead/action?delg&g=<?=base64_encode($g->group_id)?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
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
   </div>
</section>