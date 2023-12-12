<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>
<style>
    #smsg code{font-size:1.5rem!important;}
</style>
<div class="loading">
    <div class="pad" id="load">
        <img src="<?=base_url()?>resource/image_bg/loading.gif" alt="loading" />
    </div>
    <div class="pad" id="load-success" style="display:none;">
        <img src="<?=base_url()?>resource/image_bg/success.png" alt="success" />
    </div>
</div>

<div class="loadingtext">
    <div class="pad">
        <span>Database uploading... Please wait.</span>
    </div>
</div>

<div class="success">
    <div class="pad">
        <span class="close"><i class="fa fa-times"></i></span>
        <img id="simg" src="<?=base_url()?>resource/image_bg/success.png" alt="success" />
        <h2 id="smsg"></h2>
    </div>
</div>

<!--task model to add comment-->
<div class="modal" id="TaskModelC" tabindex="-1" role="dialog">
  <form action="<?=base_url()?>task/addComment" id="taskcform" method="post">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header takss">
        <h3 class="modal-title">Comment on task</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
               <div class="col-md-3"><label>Date</label></div>
               <div class="col-md-9 form-group">
                   <input type="text" id="popupdate" name="date"
                   placeholder="click to select date"
                   class="form-control"/>
               </div>
               
               <div class="col-md-3">
                   <label>Task Status</label>
                </div>
                
               <div class="form-group col-md-9">
                   <input type='hidden' id="thid" name="task_id" />
                   <select class="form-control" name="tstatus" id="tstatus" required>
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
               <div class="col-md-3"><label>Comment</label></div>
               <div class="form-group col-md-9">
                   <textarea name="tcomment" id="tcomment" class="form-control"></textarea>
               </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  </form>
</div>
<script>var base_url = "<?=base_url()?>";var gst="<?=get_config_item('default_tax')?>";var date_php_format="<?=get_config_item('date_php_datetime_format')?>";var date_format="<?=get_config_item('date_format')?>";</script>
<script>
function show_success(s){$("#simg").attr("src",base_url+"resource/image_bg/success.png"),$(".success").show(),$("#smsg").html(s),setTimeout(function(){$(".success").hide()},1e3)}function show_error(s){$("#simg").attr("src",base_url+"resource/image_bg/error.png"),$(".success").show(),$("#smsg").html(s),setTimeout(function(){$(".success").hide()},5e3)}$("#taskcform").submit(()=>{$(".loading").show()}),$(".close").click(function(){$(".success").hide()});

<?php if($this->session->flashdata('success')){
  ?>
  show_success('<?=$this->session->flashdata('success')?>');
  <?php
  unset($_SESSION['success']);
}
?>

<?php if(isset($_GET['d']) && $_GET['d']==true):?>
    show_error("You can't add payment, if there is no due.");
<?php endif;?>

<?php if($this->session->flashdata('error')){
  ?>
  show_error('<?=$this->session->flashdata('error')?>');
  <?php
  unset($_SESSION['error']);
}
?>
</script> 

<script>
<?php if(isset($_GET['me']) || isset($_GET['refadd'])):?>
    $("#add-new-service").show();
    $([document.documentElement, document.body]).animate({
        scrollTop: $("#add-new-service").offset().top
    }, 500);
<?php endif;?>

<?php if(isset($page_type) && $page_type=='setting'):?>
 $(".mobil-accor .visible").click(function(){
      $($(this).attr("href")).toggle("slow");
      $(this).toggleClass("active");
      $('.tab-pane').not($(this).attr("href")).hide();
 });
<?php endif;?>


<?php if($_SERVER['REQUEST_URI'] != '/add-lead'): ?>
localStorage.removeItem('alinput');
localStorage.removeItem('altbox');
localStorage.removeItem('als');
<?php endif;?>
<?php
if(isset($_SESSION['sanother'])){
    ?>
    localStorage.removeItem("als");localStorage.removeItem("alinput");localStorage.removeItem("altbox");
    <?php
}
?>
<?php if(isset($page_type) && $page_type=='profile'): ?>
$(document).ready(function(){var e,a=$("#cropmodal"),o=document.getElementById("uploaded_image");$("#pimg").change(function(e){var n=e.target.files;n&&n.length>0&&(reader=new FileReader,reader.onload=function(e){var n;n=reader.result,o.src=n,a.modal("show")},reader.readAsDataURL(n[0]))}),a.on("shown.bs.modal",function(){e=new Cropper(o,{aspectRatio:1,viewMode:1,preview:".preview"})}).on("hidden.bs.modal",function(){e.destroy(),e=null}),$(".cropImage").click(function(){canvas=e.getCroppedCanvas({width:400,height:400}),canvas.toBlob(function(e){url=URL.createObjectURL(e);var o=new FileReader;o.readAsDataURL(e),o.onloadend=function(){var e=o.result;$(".loading").show(),$.ajax({url:"<?=base_url()?>agent/uploadProfileImg",type:"POST",data:{profileimg:e},success:function(e){a.modal("hide"),"done"==e?location.reload():show_error("Unable to upload new profile image.")}})}})})});
<?php endif;?>
<?php if(isset($_SESSION['pc']) && !empty($_SESSION['pc'])):?>
location.href = "<?=base_url('logout')?>";
<?php endif;?>
<?php if(isset($_SESSION['rfield']) && !empty($_SESSION['rfield'])):?>
setTimeout(()=>{$(".ferror").hide();},3000);
<?php endif;?>
</script>

<?php if(isset($page_type) && $page_type=="addlead"):?>
<script src="<?=$rurl?>assets/js/addlead.js"></script>
<?php endif;?>
<?php if(isset($page_type) && $page_type=="lead" || $page_type=="flead"):?>
<script src="<?=$rurl?>assets/js/allleads.js"></script>
<?php endif;?>
<?php if(isset($page_type) && $page_type=="dashboard"):?>
<script src="<?=$rurl?>assets/js/dashboard.js"></script>
<?php endif;?>
<?php if(isset($page_type)&& $page_type=='create-invoice'): ?>
<script src="<?=$rurl?>assets/js/create_invoice.js"></script>
<script>
function addService() {
let new_service="",id=Math.floor(1e3*Math.random(2,100));new_service+='<div class="card-headers product-ser" id="id'+id+'">',new_service+='<div class="col-md-4 pd-top add-serciceee">',new_service+='<lable class="labelsess">Product/Service</lable></div>',new_service+='<div class="col-md-8 add-serciceee">',new_service+='<div class="form-group">',new_service+='<select class="form-control invp" id="invp_'+id+'" onchange="get_product_d(this);" name="inv_product[]">',new_service+='<option value="">Select</option>';
<?php $ps = get_module_values('product_service'); 
if(isset($ps) && !empty($ps)):?>
<?php foreach($ps as $p):?>
new_service += '<option value="<?=$p->product_service_id?>"><?=$p->product_service_name?></option>';
<?php endforeach;?>
<?php endif;?>   
new_service+="</select>",new_service+=" </div>",new_service+="</div>",new_service+='<div class="col-md-4 pd-top">',new_service+='<lable class="labelsess">Service Name</lable></div>',new_service+='<div class="col-md-8">',new_service+='<div class="form-group">',new_service+='<input type="text" class="form-control" id="invs_'+id+'" onkeyup="reflectS(this)" name="inv_sname[]" placeholder="Service Name" required="">',new_service+="</div>",new_service+="</div>",new_service+='<div class="col-md-4 pd-top">',new_service+='<lable class="labelsess">Billing Cycle</lable></div>',new_service+='<div class="col-md-8">',new_service+='<div class="form-group">',new_service+='<select class="form-control" id="invb_'+id+'" name="inv_bcycle[]" readonly>',new_service+='<option value="">Select</option>',new_service+='<option value="onetime">One Time</option>',new_service+='<option value="monthly">Monthly</option>',new_service+='<option value="quarterly">Quarterly</option>',new_service+='<option value="semesterly">Semesterly</option>',new_service+='<option value="yearly">Yearly</option>',new_service+="</select>",new_service+="</div>",new_service+="</div>",new_service+='<div class="col-md-4 pd-top">',new_service+='<lable class="labelsess">Price override</lable></div>',new_service+='<div class="col-md-8">',new_service+='<div class="form-group">',new_service+='<input type="text" class="form-control" onkeyup="overRideP(this);" id="invO_'+id+'" name="inv_poverride[]" placeholder="Price" />',new_service+="</div>",new_service+="</div>",new_service+='<div class="col-md-4 pd-top">',new_service+='<lable class="labelsess">Renewal Override</lable></div>',new_service+='<div class="col-md-8">',new_service+='<div class="form-group">',new_service+='<input type="text" class="form-control" id="invRO_'+id+'" name="inv_roverride[]" placeholder="Price" />',new_service+='<p class="remove-btn">',new_service+='<button class="btn btn-danger text-left" type="button" onclick="removeInvMe('+id+')">Remove</button></p>',new_service+="</div>",new_service+="</div>",$(".service-con").append(new_service);
}
</script>
<?php endif;?>
<?php if(isset($page_type)&& $page_type=='task' || $page_type=='new-task'): ?>
<script src="<?=$rurl?>assets/js/task.js"></script>
<?php endif;?>
<?php if(isset($page_type)&& $page_type=='clients' || $page_type=='add-client'): ?>
<script src="<?=$rurl?>assets/js/clients.js"></script>
<?php endif;?>
<?php if(isset($page_type)&& $page_type=='vendors' || $page_type=='add-vendor'): ?>
<script src="<?=$rurl?>assets/js/vendros.js"></script>
<?php endif;?>
<?php if(isset($page_type)&& $page_type=='product-and-services'): ?>
<script src="<?=$rurl?>assets/js/product_and_service.js"></script>
<?php endif;?>
<?php if(isset($page_type) && $page_type == 'list-invoice'):?>
<script src="<?=$rurl?>assets/js/list_invoice.js"></script>
<?php endif;?>
<?php if(isset($page_type) && $page_type == 'setting'):?>
<script src="<?=$rurl?>assets/js/setting.js"></script>
<?php endif;?>
<script src="<?=$rurl?>assets/js/commonjs.js"></script>