<?php defined("BASEPATH") OR exit("No direct access allowed.");?>

<section class="content content-header">
    <div class="row">
        <div class="panel panel-bd" style="display:inline-block;padding:20px 10px;width:100%;">
            <form action="<?=base_url()?>project/add_new_burning_report" method="POST">
            <input type="hidden" name="pid" value="<?=isset($burning_report->burning_report_id) ? base64_encode($burning_report->burning_report_id) : ''?>" />
            <div class="card-headers row">
             <?php if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
&& $_SESSION['roll']==='admin'):?>
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Business Associate</label>
                      <select class="form-control" name="agent_id">
                          <option value="">Select</option>
                          <?php foreach($agents as $agent):?>
                          <option value="<?=$agent->agent_id?>"
                          <?php echo isset($burning_report->agent_id) && $burning_report->agent_id == $agent->agent_id ? 'selected':'';?>
                          ><?=$agent->agent_name?></option>
                          <?php endforeach;?>
                      </select>
                  </div>
              </div>
              <?php endif;?>
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Client</label>
                      <select class="form-control" name="client_id" onchange="filterProject(event);" id="client_id" required>
                          <option value="">Select</option>
                          <?php foreach($clients as $client):?>
                          <option value="<?=$client->client_id?>"
                          <?php echo isset($burning_report->client_id) && $burning_report->client_id == $client->client_id ? 'selected':'';?>
                          ><?=$client->client_name?></option>
                          <?php endforeach;?>
                      </select>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Project</label>
                      <select class="form-control" name="project_id" required>
                          <option value="">Select</option>
                          
                      </select>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Category</label>
                      <select class="form-control" name="category_id" id="category_id" required>
                          <option value="">Select</option>
                          <?php foreach($categories as $category):?>
                          <option value="<?=$category->issue_category_id?>"
                          <?php echo isset($burning_report->category_id) && $burning_report->category_id == $category->issue_category_id ? 'selected':'';?>
                          ><?=$category->name?></option>
                          <?php endforeach;?>
                      </select>
                  </div>
              </div>
              <?php if(auth_id()==0):?>
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Date</label>
                      <input type="date" class="form-control" name="date" value="<?= !empty($burning_report->created) ? date('Y-m-d', strtotime($burning_report->created)) : ''?>"/>
                  </div>
              </div>
              <?php endif;?>
              
              <div class="col-md-12">
                  <label>Report</label>
                  <textarea class="form-control" name="text"><?=$burning_report->text ?? ''?></textarea>
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
    
    <?php if(isset($burning_report->client_id)):?>
        const id = '<?=$burning_report->client_id?>';
        const pid = '<?=$burning_report->project_id?>';
        const projects = JSON.parse('<?=$projects?>');
        const options = projects.filter(d => d.client_id == id).map(d => {
            return `<option value="${d.project_id}" ${d.project_id === pid ? 'selected' : ''}>${d.project_name}</option>`;
        }).join("");
        
        const blankOption = "<option value=''>Select</option>";
        
        document.querySelector("select[name='project_id']").innerHTML = (blankOption + options);
    <?php endif;?>
</script>