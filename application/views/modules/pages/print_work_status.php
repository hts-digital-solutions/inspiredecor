<?php defined("BASEPATH") OR exit("No direct access allowed.");?>

<section class="content content-header">
    <div class="row">
        <div class="col-md-12 row">
            <form class="row" style="margin-bottom:2px;">
                <?php if(auth_id() == 0):?>
               <div class="col-md-3">
                   <select name="agent" class="form-control" onchange="this.form.submit();">
                       <option value="">Select Business Associate</option>
                       <option value="0" <?=isset($_GET['agent']) && $_GET['agent'] === '0' ? 'selected' : ''?>>Admin</option>
                       <?php foreach($agents as $a):?>
                        <option value="<?=$a->agent_id?>" <?=isset($_GET['agent']) && $_GET['agent'] === $a->agent_id ? 'selected' : ''?>><?=$a->agent_name?></option>
                       <?php endforeach;?>
                   </select>
               </div>
               <?php endif;?>
               <div class="col-md-3">
                   <select name="client" class="form-control" onchange="this.form.submit();">
                       <option value="">Select Client</option>
                       <?php foreach($clients as $c):?>
                        <option value="<?=$c->client_id?>" <?=isset($_GET['client']) && $_GET['client'] === $c->client_id ? 'selected' : ''?>><?=$c->client_name?></option>
                       <?php endforeach;?>
                   </select>
               </div>
               <div class="col-md-3">
                   <select name="project" class="form-control" onchange="this.form.submit();">
                       <option value="">Select Project</option>
                       <?php foreach($projects as $p):?>
                       <?php if(isset($_GET['client']) && $_GET['client'] === $p->client_id ):?>
                        <option value="<?=$p->project_id?>" <?=isset($_GET['project']) && $_GET['project'] === $p->project_id ? 'selected' : ''?>><?=$p->project_name?></option>
                       <?php endif;?>
                       <?php endforeach;?>
                   </select>
               </div>
               <div class="col-md-3" style="display:flex;">
                   <label>Filter by Date</label>
                    <input type="date" name="date" onchange="this.form.submit();" value="<?=$_GET['date'] ?? ''?>" class="form-control"/>
               </div>
           </form>
        </div>
        <div class="panel panel-bd" id="printable" style="height:70vh; overflow-y:auto;display:inline-block;padding:20px 10px;width:100%;">
            <table class="table table-bordered" id="projectTable">
                <style>
                    .table-bordered td,.table-bordered th {
                        border-color:#000!important;
                        border-width:2px!important;
                    }
                </style>
                <thead>
                    <tr>
                        <th colspan="5"><input style="border:none; width:100%;text-align:center;" value="Action Plan"/></th>
                    </tr>
                    <tr>
                        <th colspan="5"><textarea style="border:none; width:100%;text-align:center;" >The Law of Good Work- I Must Practice Civil Daily, My Time Is For Clients, I Must Catch All Instructions And Leads Moved Towards Me And Note Them Down.</textarea></th>
                    </tr>
                    <tr>
                        <th colspan="5"><input style="border:none; width:100%;text-align:center;" value="Tarai is MUST at all sites."/></th>
                    </tr>
                    <tr>
                        <?php $date=isset($_GET['date']) && !empty($_GET['date']) ? date('d-m-Y', strtotime($_GET['date'])) : date('d-m-Y', strtotime('tomorrow'));?>
                        <th colspan="5"><input style="border:none; width:100%;text-align:center;" value="<?=$date?>" /></th>
                    </tr>
                    <tr>
                        <th colspan="5"><input style="border:none; width:100%;text-align:center;" value="CIVIL SHEET" /></th>
                    </tr>
                  <tr style="background:pink;">
                    <th style="width:150px;">Project Name</th>
                    <th style="width:200px;">Action Plan for tomorrow</th>
                    <th>Manual Notes</th>
                    <th>Supervisor</th>
                    <th>Work Stage</th>
                  </tr>
                </thead>
                <tbody>
                <?php $ids=array(); if(isset($active_projects) && !empty($active_projects)):?>
                <?php foreach($active_projects as $p):?>
                <?php
                
                if(isset($_GET['date']) && !empty($_GET['date'])) {
                    $this->db->where("DATE(created)", date('Y-m-d', strtotime($_GET['date'])));
                }else {
                    $this->db->where("DATE(created)", date('Y-m-d'));
                }
                
                $work_status = $this->db->where("project_id", $p->project_id)->get("crm_work_status")->row() ?? ''; 
                
                ?>
                  <tr>
                    <td><?=$p->project_name?></td>
                    <td>
                        <?=$work_status->work_status_tomorrow ?? ''?>
                    </td>
                    <td  style="height:100px;">
                        
                    </td>
                    <td><?=empty($work_status->created_by_id) ? 'Admin' : get_info_of('agent', 'agent_name', $work_status->created_by_id, 'agent_id') ?></td>
                    <td>
                      
                    </td>
                  </tr>
                <?php endforeach; ?>
                <?php endif;?>
                </tbody>
              </table>
        </div>
        <button class="btn btn-primary" onclick="printMe();">Print</button>
    </div>
</section>
<script>
    function printMe() {
        var printContents = document.getElementById('printable').innerHTML;
        var originalContents = document.body.innerHTML;
    
        document.body.innerHTML = printContents;
    
        window.print();
    
        document.body.innerHTML = originalContents;
    }
</script>
