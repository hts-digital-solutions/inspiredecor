<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>
<style>.small{font-size:1.2rem;}.js-plotly-plot .plotly, .js-plotly-plot .plotly div {
    direction: ltr;
    font-family: "Open Sans", verdana, arial, sans-serif;
    margin: 0px;
    padding: 0px;
    display: flex;
    align-items: center;
    justify-content: center;
}</style>
<section class="content content-header">
   <div class="row">
       <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
         <div class="panel panel-bd">
            <div class="panel-heading">
               <div class="panel-title">
                  <h4>Leads Source Overview</h4>
               </div>
            </div>
            <div class="personal">
                <div id="income-source" style="padding-top:25px;">
                </div>
            </div>
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
         <div class="panel panel-bd lobidisable">
            <div class="panel-heading">
               <div class="panel-title">
                  <h4>Calender</h4>
               </div>
            </div>
            <div class="panel-body personal">
               <!-- monthly calender -->
               <div class="monthly_calender">
                  <div class="monthly" id="m_calendar"></div>
               </div>
            </div>
            <div id="map1" class="hidden-xs hidden-sm hidden-md hidden-lg"></div>
         </div>
      </div>
        
      <div class="col-xs-12 col-sm-12 col-md-4">
         <div class="panel panel-bd">
            <div class="panel-heading">
               <div class="panel-title">
                  <h4 style="display:inline-block;">Task</h4>
                  <a href="<?=base_url()?>task/add?ref=d" style="float:right;"
                  class="btn btn-xs btn-warning"><i class="fa fa-plus"></i> New</a>
               </div>
            </div>
            <div class="panel-body personal">
               <table class="table">
                    <?php if(isset($task) && !empty($task)):?>
                    <?php foreach($task as $t):?>
                    <tr>
                      <td style="padding: 8px 0px;">
                          <a href="<?=base_url()?>task/add?task=<?=base64_encode($t->task_id)?>">
                          <?php echo ($t->task_status==get_task_status_id('completed')) ? '<strike>'.$t->task_name.'</strike>': $t->task_name?></a>
                      </td>
                      <td style="padding: 8px 0px; position:relative; left:-5px;">
                      <?php echo ($t->task_priority==10) ? '<span class="btn btn-xs btn-danger">High<span>' 
                      : ($t->task_priority == 5 ? '<span class="btn btn-xs btn-warning">Medium<span>' : 
                      '<span class="btn btn-xs btn-info">Low<span>');
                      ?></td>
                      <td style="padding: 8px 0px;">
                        <button type="button" class="btn btn-xs btn-warning" title="Add Comment"
                        onclick="addTaskComment(this)" data-fire-t="<?=base64_encode($t->task_id)?>"><i class="fa fa-comment"></i></button>
                        <button type="button" class="btn btn-xs btn-success" title="Task Completed"
                        onclick="markTaskComplete(this)" data-fire-t="<?=base64_encode($t->task_id)?>"><i class="fa fa-check"></i></button>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif;?>
               </table>
           </div>
         </div>
      </div>
      </div>
   <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
         <div class="panel panel-bd cardbox">
            <div class="panel-body bd-panel personal" style="display:flex;justify-content:space-between;"> 
            
               <div class="statistic-box text-center">
                   <i class="fa fa-credit-card-alt fa-2x"></i>
                   <h4> Invoice Awaiting Payment</h4>
                  <h3>
                     
                  <?php echo isset($invoice_awaiting['amount']) ? get_formatted_price($invoice_awaiting['amount']) : 0;?>
                  (<span class="count-number">
                      <?php echo isset($invoice_awaiting['count']) ? $invoice_awaiting['count'] : 0;?>
                  </span>)
                  </h3>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
         <div class="panel panel-bd cardbox2">
            <div class="panel-body bd-panel" style="display:flex;justify-content:space-between;">
               
              
                <div class="statistic-box text-center">
                   <i class="fa fa-money fa-2x"></i>
                    <h4>Yearly Sales</h4>
                  <h3>
                  <?php echo isset($yearly_sales['amount']) ? get_formatted_price($yearly_sales['amount']) : 0;?>
                  (<span class="count-number">
                      <?php echo isset($yearly_sales['count']) ? $yearly_sales['count'] : 0;?>
                  </span>)
                  </h3>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
         <div class="panel panel-bd cardbox3">
            <div class="panel-body bd-panel" style="display:flex;justify-content:space-between;">
              
               <div class="statistic-box text-center">
                   <i class="fa fa-money fa-2x"></i>
                <h4>Monthly Sales</h4>
                  <h3>
                  <?php echo isset($monthly_sales['amount']) ? get_formatted_price($monthly_sales['amount']) : 0;?>
                  (<span class="count-number">
                      <?php echo isset($monthly_sales['count']) ? $monthly_sales['count'] : 0;?>
                  </span>)
                  </h3>
               </div>
            </div>
         </div>
      </div>
      
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
         <div class="panel panel-bd cardbox4">
            <div class="panel-body bd-panel" style="display:flex;justify-content:space-between;">
               <div class="statistic-box text-center">
                   <i class="fa fa-frown-o fa-2x"></i>
                     <h4>Miss opportunity</h4>
                  <h3>
                  <?php echo isset($miss_oppertunity['amount']) ? get_formatted_price($miss_oppertunity['amount']) : 0;?>
                  (<span class="count-number">
                      <?php echo isset($miss_oppertunity['count']) ? $miss_oppertunity['count'] : 0;?>
                  </span>)
                  </h3>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
         <div class="panel panel-bd cardbox3">
            <div class="panel-body bd-panel" style="display:flex;justify-content:space-between;">
               
                <div class="statistic-box text-center">
                   <i class="fa fa-tasks fa-2x"></i>
                   <h4>ToDo</h4>
                  <h3> <span class="count-number" style="color:red;"><?=get_task_card()?></span>/
                  <span class="count-number"><?=get_task_total()?> </span>
                  </h3>
               </div>
            </div>
         </div>
      </div>
      <?php 
      if(isset($_SESSION['logged_in']) && isset($_SESSION['roll']) 
        && $_SESSION['roll']==='admin'):?>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
         <div class="panel panel-bd cardbox3">
            <div class="panel-body bd-panel" style="display:flex;justify-content:space-between;">
               
                <div class="statistic-box text-center">
                   <i class="fa fa-comments fa-2x"></i>
                   <h4>SMS Status</h4>
                  <h3><span class="count-number">
                  <?php $sms = json_decode($sms_balance);?>
                  <?php echo
                  !isset($sms->error) ? ($sms->data->sms_credit ?? '') : '';
                  ?>
                  </span>
                  </h3>
               </div>
            </div>
         </div>
      </div>
      <?php endif;?>
   </div>
      <div class="row">
      <!-- datamap -->
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 ">
         <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
               <div class="panel-title">
                  <h4>Income Graph</h4>
               </div>
            </div>
            <div class="panel-body" style="padding:0px;">
               <div id="incomeGraph">
               </div>
            </div>
         </div>
      </div>
       <?php if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
            && $_SESSION['roll']==='admin'): ?>
       <div class="col-xs-12 col-sm-12 col-md-4">
         <div class="panel panel-bd ">
            <div class="panel-heading">
               <div class="panel-title">
                  <h4>Best Employee List 
                  <form method="post" name="empForm" id="empForm" style="float:right;">
                      <select name="duration" id="empDur" onchange="bestEmp();">
                          <option value="month">Month</option>
                          <option value="year">Year</option>
                          <option value="alltime">All Time</option>
                      </select>
                  </form>
                  </h4>
               </div>
            </div>
            <div class="panel-body" style="height:450px;overflow:auto;">
               <ul class="emply" id="bemplist">
                  <?php if(isset($bemp) && !empty($bemp)): ?>
                  <?= $bemp ?>
                  <?php else:?>
                  <li>Data not found!</li>
                  <?php endif;?>
               </ul>
            </div>
         </div>
      </div>
      <?php endif;?>
   </div>
      
      <div class="row">
      <canvas id="radarChart" style="display:none;"></canvas>
      
      <?php if(true):?>
      <div class="col-xs-12 col-sm-12 col-md-4">
         <div class="panel panel-bd ">
            <div class="panel-heading">
               <div class="panel-title">
                  <h4>Best Value Services 
                  <form method="post" name="bserviceForm" id="bserviceForm" style="float:right;">
                      <select name="duration" id="sDur" onchange="bestVS();">
                          <option value="month">Month</option>
                          <option value="year">Year</option>
                          <option value="alltime">All Time</option>
                      </select>
                  </form>
                  </h4>
               </div>
            </div>
            <div class="panel-body personal">
               <ul class="emply" id="bvslist">
                  <?php if(isset($bvservice) && !empty($bvservice)): ?>
                  <?= $bvservice ?>
                  <?php else:?>
                  <li>Data not found!</li>
                  <?php endif;?>
               </ul>
            </div>
         </div>
      </div>
      <?php endif;?>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
         <div class="panel panel-bd">
            <div class="panel-heading">
               <div class="panel-title">
                  <h4>System Information</h4>
               </div>
            </div>
            <div class="panel-body personal">
                <table class="table">
                    <tr>
                        <td>Current Version</td>
                        <th><?=get_system_install('version')?></th>
                    </tr>
                    <tr>
                        <td>Latest Version</td>
                        <th><?=get_system_install('latest')?></th>
                    </tr>
                    <tr>
                        <td>PHP Version</td>
                        <th><?=phpversion()?></th>
                    </tr>
                    <tr>
                        <td>SignUp Date</td>
                        <th><?=get_system_install('s_date')?></th>
                    </tr>
                    <tr>
                        <td>Expiry Date</td>
                        <th><?=get_system_install('e_date')?></th>
                    </tr>
                    <tr>
                        <td>Invoice Cron Run</td>
                        <th class="small"><?=date("d-m-Y h:i:s A",strtotime(get_config_item('inv_cron_run')))?></th>
                    </tr>
                    <tr>
                        <td>Task Cron Run</td>
                        <th class="small"><?=date("d-m-Y h:i:s A",strtotime(get_config_item('task_cron_run')))?></th>
                    </tr>
                    <tr>
                        <td>Followup Cron Run</td>
                        <th class="small"><?=date("d-m-Y h:i:s A",strtotime(get_config_item('followup_cron_run')))?></th>
                    </tr>
                </table>
            </div>
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
               <div class="panel-title">
                  <h4>Lastest Version Features</h4>
               </div>
            </div>
            <div class="panel-body personal">
               <table class="table">
                   <?php if(isset($feature) && !empty($feature)): ?>
                   <?php $i=1; foreach($feature as $f):?>
                   <tr>
                       <th><?=$i?>. </th>
                       <td><?=$f->feature_name?></td>
                   </tr>
                   <?php $i++; endforeach;?>
                   <?php endif;?>
                   <tr>
                       <th colspan="3" style="text-align:center;">
                       <a target="_blank" href="http://<?=get_domain($_SERVER['HTTP_HOST'])?>/crm-latest-features-list">View All</a>
                       </th>
                   </tr>
               </table>
            </div>
         </div>
      </div>
     
    
   </div>
   
   
   
</section>

 