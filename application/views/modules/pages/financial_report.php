<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<section class="content content-header pd-lft">
  <div class="row">
    <div class="col-sm-12">
        <form class="row" style="margin-bottom:2px;">
           <div class="col-md-3 form-group">
               <label>Client</label>
               <select name="client" class="form-control" onchange="this.form.submit();">
                   <option value="">Select Client</option>
                   <?php foreach($clients as $c):?>
                    <option value="<?=$c->client_id?>" <?=isset($_GET['client']) && $_GET['client'] === $c->client_id ? 'selected' : ''?>><?=$c->client_name?></option>
                   <?php endforeach;?>
               </select>
           </div>
           <div class="col-md-3 form-group">
               <label>Project</label>
               <select name="project" class="form-control" onchange="this.form.submit();">
                   <option value="">Select Project</option>
                   <?php foreach($projects as $p):?>
                   <?php if(isset($_GET['client']) && $_GET['client'] === $p->client_id ):?>
                    <option value="<?=$p->project_id?>" <?=isset($_GET['project']) && $_GET['project'] === $p->project_id ? 'selected' : ''?>><?=$p->project_name?></option>
                   <?php endif;?>
                   <?php endforeach;?>
               </select>
           </div>
           <div class="col-md-3 form-group">
                <label>Date</label>
                <input type="date" name="date" onchange="this.form.submit();" value="<?=$_GET['date'] ?? date('Y-m-d')?>" class="form-control"/>
           </div>
       </form>
      <div class="panel panel-bd">
       
        <div class="panel-body">
          <div class="row">
            <div class="cards">
              <div class="card-headers">
                <div class="table-responsive mob-bord">
                  <table class="table table-bordered table-hover" id="projectTable">
                    <thead>
                      <tr>
                        <th>Project Name</th>
                        <th>Client Name</th>
                        <th>Payment Received</th>
                        <th>Total Expense</th>
                        <th>Profit/Loss</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $ids=array(); if(isset($projects) && !empty($projects)):?>
                    <?php foreach($projects as $p):?>
                    <?php array_push($ids, base64_encode($p->project_id)) ?>
                      <tr>
                        <td><a href="<?=base_url()?>add-project/?edit=<?=base64_encode($p->project_id)?>">
                            <?=$p->project_name?>
                        </a></td>
                        <td><?=$p->client_name?></td>
                        
                        <?php 
                        $ci = &get_instance();
                        $q = $ci->db->where("client_id", $p->client_id)
                            ->select("SUM(total_price) as total_expense")
                            ->where("project_id", $p->project_id)
                            ->where("DATE(created) <=", isset($_GET['date']) && !empty($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : date('Y-m-d'))
                            ->get("crm_project_expenses");
                        $q = $q->row();
                        
                        //old expenses
                        /*$date = isset($_GET['date']) && !empty($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : date('Y-m-d');
                        $q0 = $ci->db->where("client_id", $p->client_id)
                            ->select("SUM(total_price) as total_expense")
                            ->where("project_id", $p->project_id)
                            ->where("DATE(created) <=", date('Y-m-d', strtotime($date . ' -1day')))
                            ->get("crm_project_expenses");
                        $q0 = $q0->row();
                        
                        $last_expense = $q0->total_expense ?? 0; */
                        
                        $total_expense = $q->total_expense;
                        
                        $q2 = $ci->db->where("client_id", $p->client_id)
                            ->select("SUM(amount) as total_received")
                            ->where("project_id", $p->project_id)
                            ->where("DATE(created) <=", isset($_GET['date']) && !empty($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : date('Y-m-d'))
                            ->get("crm_client_passbook");
                        $q2 = $q2->row();
                        
                        $total_received = $q2->total_received;
                        ?>
                        
                        <td><?=get_formatted_price($total_received)?></td>
                        <td><?=get_formatted_price($total_expense)?></td>
                        <td style="<?=($total_received - $total_expense) < 0 ? 'color:white;background:red;' : ($total_received - $total_expense == 0 ? 'color:black;background:white;': 'color:white;background:green;');?>"><?=$total_received - $total_expense?></td>
                      </tr>
                    <?php endforeach; ?>
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