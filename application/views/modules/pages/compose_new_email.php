<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>
<section class="content content-header">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd">
        <div class="panel-heading">
           <form action="<?=base_url()?>client/send_compose_email" method="POST">
            <input type="hidden" name="rurl" value="<?=$_SERVER['HTTP_REFERER']?>" />
            <input type="hidden" name="clientid" value="<?php echo isset($_GET['c']) ? $_GET['c'] : ''?>" />
           <div class="panel-body">
              <p> Use variables to call dynamic data. For user name - <code>{user}</code>, For current date - <code>{date}</code>,
              For email <code>{email}</code>, For mobile <code>{mobile}</code></p> <br/>
              <label>Subject :</label>
              <div class="form-group">
                 <input class="form-control" type="text" name="csubject"
                 value="<?php echo isset($sub)? $sub:'' ?>"
                 />
              </div>
              <div class="form-group">
                 <textarea id="summernote3" name="ccontent"><?php echo isset($content)? $content:'' ?></textarea>
              </div>
           <div class="btn-group pull-right">
              <button type="submit" class="btn btn-success">Submit</button>
           </div>
        </div>
           </form>
        </div>
    </div>
  </div>
</section>
