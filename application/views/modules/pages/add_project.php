<?php defined("BASEPATH") OR exit("No direct access allowed.");?>
<?php 
if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
&& $_SESSION['roll']==='admin'):?>
<section class="content content-header">
    <div class="row">
        <div class="panel panel-bd" style="display:inline-block;padding:20px 10px;width:100%;">
            <form action="<?=base_url()?>project/add_new" method="POST">
            <input type="hidden" name="pid" value="<?=isset($project->project_id) ? base64_encode($project->project_id) : ''?>" />
            <div class="card-headers row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Project/Site Name</label>
                      <input type="text" class="form-control" required name="project_name" value="<?= $project->project_name ?? ''; ?>"/>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Client</label>
                      <select class="form-control" name="client_id" required>
                          <option value="">Select</option>
                          <?php foreach($clients as $client):?>
                          <option value="<?=$client->client_id?>"
                          <?php echo isset($project->client_id) && $project->client_id == $client->client_id ? 'selected':'';?>
                          ><?=$client->client_name?></option>
                          <?php endforeach;?>
                      </select>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Project/Site Status</label>
                      <select class="form-control" name="status" required>
                          <option value="">Select</option>
                          <option value="1"
                          <?php echo isset($project->status) && $project->status == 1 ? 'selected':'';?>
                          >Active</option>
                          <option value="0"
                          <?php echo isset($project->status) && $project->status == 0 ? 'selected':'';?>
                          >Completed</option>
                      </select>
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
<p class="badge badge-danger">Projects access denied.</p>
<?php endif;?>