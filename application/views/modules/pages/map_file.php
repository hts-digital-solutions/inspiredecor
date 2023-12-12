<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header">
   <div class="row">
      <div class="col-sm-12 ">
         <div class="panel panel-bd ">
            <div class="panel-heading">
               <div class="btn-group"> 
                  Map File
               </div>
            </div>
            <div class="panel-body">
               <form action="<?=base_url()?>lead/import_lead_file" id="lmform" method="POST">
                  <div class="col-sm-12 col-md-12 col-xs-12">
                     <div class="cards">
                        <div class="card-headers"  style="padding:0px;">
                            <p>Please map your file column to given fields.</p>
                            <br/>
                        </div>
                        <div class="card-content">
                            <?php if(isset($cols) && !empty($cols)): ?>
                            <?php foreach($fields as $f):?>
                            <?php if($f->feild_type=='text' || $f->feild_type=='email'
                            || $f->feild_type=='textarea'):?>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    "<?=$f->feild_name?>" maps to
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <select class="form-control" name="colsmap[<?=$f->feild_value_name?>]">
                                        <option value="">Select Column</option>
                                        <?php if(isset($cols) && !empty($cols)): ?>
                                        <?php $i=0; foreach($cols as $c):?>
                                        <option value="<?=$i?>"><?=$c?></option>
                                        <?php $i++; endforeach;?>
                                        <?php endif;?>   
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php endif;?>
                            <?php endforeach;?>
                            <?php endif;?>
                        </div>
                        <div class="card-footer">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" style="float:right;">Import</button>
                            </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>