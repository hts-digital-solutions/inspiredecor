<?php defined("BASEPATH") OR exit("No direct access allowed.");?>

<?php if(auth_id()==0):?>
<section class="content content-header">
    <div class="row">
        <div class="panel panel-bd" style="display:inline-block;padding:20px 10px;width:100%;">
            <form action="<?=base_url()?>project/add_new_site_issue_category" method="POST">
            <input type="hidden" name="pid" value="<?=isset($category->issue_category_id) ? base64_encode($category->issue_category_id) : ''?>" />
            <div class="card-headers row">
              <div class="col-md-12">
                  <div class="form-group">
                      <label>Category Name</label>
                      <input class="form-control" name="name" id="name" value="<?=$category->name ?? ''?>" type="text"/>
                  </div>
              </div>
              
              <div class="col-md-12 text-right">
                  <button class="btn btn-info">Submit</button>
              </div>
            </div>
            </form>
        </div>
    </div>
</section>
<?php else:?>
<p>Access denied</p>
<?php endif;?>