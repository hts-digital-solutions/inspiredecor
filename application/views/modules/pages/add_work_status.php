<?php defined("BASEPATH") OR exit("No direct access allowed.");?>

<section class="content content-header">
    <div class="row">
        <div class="panel panel-bd" style="display:inline-block;padding:20px 10px;width:100%;">
            <form action="<?=base_url()?>project/add_work_status" method="POST">
            <input type="hidden" name="pid" value="<?=isset($work_status->work_status_id) ? base64_encode($work_status->work_status_id) : ''?>" />
            <div class="card-headers row">
                <?php if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
&& $_SESSION['roll']==='admin'):?>
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Business Associate</label>
                      <select class="form-control" name="agent_id" required>
                          <option value="">Select</option>
                          <?php foreach($agents as $agent):?>
                          <option value="<?=$agent->agent_id?>"
                          <?php echo isset($work_status->created_by_id) && $work_status->created_by_id == $agent->agent_id ? 'selected':'';?>
                          ><?=$agent->agent_name?></option>
                          <?php endforeach;?>
                      </select>
                  </div>
              </div>
              <?php endif;?>
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Client</label>
                      <select class="form-control" required onchange="filterProject(event);" name="client_id">
                          <option value="">Select</option>
                          <?php foreach($clients as $client):?>
                          <option value="<?=$client->client_id?>"
                          <?php echo isset($work_status->client_id) && $work_status->client_id == $client->client_id ? 'selected':'';?>
                          ><?=$client->client_name?></option>
                          <?php endforeach;?>
                      </select>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Project</label>
                      <select class="form-control" name="project_id" required>
                          <option value="">Select</option>
                          
                      </select>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Date</label>
                      <input type="date" name="date" value="<?= isset($work_status->created) ? date('Y-m-d', strtotime($work_status->created)) : ''?>" class="form-control" />
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="form-group">
                      <label>Today Work Status</label>
                      <textarea class="form-control" placeholder="आज साइट पर कितने मिस्त्री और कितनी लेबर लगी ?
आज साइट पर क्या-क्या काम हुआ ?" name="work_status_today" required><?= isset($work_status) && $work_status->work_status_today ? preg_replace('/"([^"]+)"/', "", $work_status->work_status_today) : ''?></textarea>
                  </div>
              </div>
              
              <div class="col-md-12">
                  <div class="form-group">
                      <label>Tomorrow Work Plan</label>
                      <textarea class="form-control" placeholder="कल साइट पर कितने मिस्त्री और कितने मजदूर लगेंगे ?
कल साइट पर क्या-क्या काम होगा?" name="work_status_tomorrow" required><?= isset($work_status) && $work_status->work_status_tomorrow ? preg_replace('/"([^"]+)"/', "", $work_status->work_status_tomorrow) : ''?></textarea>
                  </div>
              </div>
              
              <div class="col-md-12">
                  <div class="form-group">
                      <label>Day After Tomorrow Work Plan</label>
                      <textarea class="form-control" name="day_after_status" required><?=$work_status->day_after_status ?? ''?></textarea>
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

<script>
    function filterProject(e)
    {
        const projects = JSON.parse('<?=$projects?>');
        const options = projects.filter(d => d.client_id == e.target.value).map(d => {
            return `<option value="${d.project_id}">${d.project_name}</option>`;
        }).join("");
        
        const blankOption = "<option value=''>Select</option>";
        
        document.querySelector("select[name='project_id']").innerHTML = (blankOption + options);
    }
    
    <?php if(isset($work_status->client_id)):?>
        const id = '<?=$work_status->client_id?>';
        const pid = '<?=$work_status->project_id?>';
        const projects = JSON.parse('<?=$projects?>');
        const options = projects.filter(d => d.client_id == id).map(d => {
            return `<option value="${d.project_id}" ${d.project_id === pid ? 'selected' : ''}>${d.project_name}</option>`;
        }).join("");
        
        const blankOption = "<option value=''>Select</option>";
        
        document.querySelector("select[name='project_id']").innerHTML = (blankOption + options);
    <?php endif;?>
    
</script>