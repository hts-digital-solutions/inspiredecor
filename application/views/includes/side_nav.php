<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
$this->load->helper('lead_helper');
?>
<aside class="main-sidebar">
   <div class="sidebar">
       <img src="<?=base_url()?>logo.jpeg" alt="logo" style="margin:2px auto;object-fit:contain;width:50px;height:50px;display:block;border-radius:1px;"/>
      <h2 style="text-align:center;">Inspire <br/>Decor & Builders</h2>
      <span class="close">X</span>
      <div class="user-panel">
         <div class="image pull-center">
            <?php
            $src = isset($profile->profile_image) && $profile->profile_image!=='' 
            ? base_url('resource/system_uploads/agent/').$profile->profile_image 
            : base_url().'resource/assets/dist/img/avatar5.png';
            ?>
            <img src="<?=$src?>" class="img-circle" alt="User Image">
         </div>
         <div class="info">
            <h4>Welcome</h4>
            <p><?=get_module_value(decrypt_me($_SESSION['login_id']),'agent')=='-' ? 
            'Admin' : get_module_value(decrypt_me($_SESSION['login_id']),'agent');
            ?></p>
         </div>
      </div>
      <ul class="sidebar-menu">
          <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true || isset($_SESSION['ca']) && $_SESSION['ca']==='yes'):?>
         <li class="treeview">
            <a href="#">
            <i class="fa fa-cogs"></i><span>Sites Management</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true):?>
                <li><a href="<?=base_url()?>projects">All Projects</a></li>
                <?php endif;?>
                <li><a href="<?=base_url()?>print-work-status">Tomorrow's Action Plan <br/>Clients</a></li>
                <li><a href="<?=base_url()?>lead-tomorrow-action-plan">Tomorrow's Action Plan <br/> Leads</a></li>
                <li><a href="<?=base_url()?>add-petty-cash">Add Cash Flow</a></li>
                <li><a href="<?=base_url()?>petty-cash">Cash Flow</a></li>
                <li><a href="<?=base_url()?>expenses">All Expenses</a></li>
               <li><a href="<?=base_url()?>add-expense">Add Expenses</a></li>
               <li><a href="<?=base_url()?>work-status">Work Status</a></li>
               <li><a href="<?=base_url()?>add-work-status">Add Work Status</a></li>
               <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true):?>
               <li><a href="<?=base_url()?>client-payments">Client Payments</a></li>
               <?php endif;?>
               <li><a href="<?=base_url()?>add-payment">Add Client Payment</a></li>
               <li><a href="<?=base_url()?>burning-report">Site Issues</a></li>
               <li><a href="<?=base_url()?>add-burning-report">Add Site Issues</a></li>
               <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true):?>
               <li><a href="<?=base_url()?>add-site-issue-category">Add Site Issue Category</a></li>
               <li><a href="<?=base_url()?>site-issue-category">Site Issue Category</a></li>
               <?php endif;?>
               <li><a href="<?=base_url()?>auzaar">Tools</a></li>
               <li><a href="<?=base_url()?>add-auzaar">Add Tool</a></li>
               <li><a href="<?=base_url()?>verify-tool">Verify Tool</a></li>
            </ul>
         </li>
         <?php endif;?>
         <li class="treeview"><a href="<?=base_url()?>"><i class="fa fa-home"></i><span>Dashboard</span></a></li>
         <li class="treeview">
            <a href="#">
            <i class="fa fa-user-md"></i><span>Lead</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?=base_url()?>add-lead">Add Lead</a></li>
               <li><a href="<?=base_url()?>lead">All Leads</a></li>
               <li><a href="<?=base_url()?>followup-leads">Followup Leads</a></li>
            </ul>
         </li>
         <li class="treeview">
            <a href="<?=base_url()?>task">
            <i class="fa fa-sitemap"></i><span>TODO List</span>
            </a>
         </li>
         <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true
         || isset($_SESSION['ca']) && $_SESSION['ca']==='yes'):?>
         <li class="treeview">
            <a href="<?=base_url()?>clients"><i class="fa fa-list-alt"></i> <span>Clients</span></a>
         </li>
          <li class="treeview">
            <a href="<?=base_url()?>vendors"><i class="fa fa-list-alt"></i> <span>Vendors</span></a>
         </li>
         <?php endif;?>
         
         
         
         <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true):?>
         <li class="treeview">
            <a href="<?=base_url()?>product-and-services">
            <i class="fa fa-product-hunt"></i><span>Product and Services</span>
            </a>
         </li>
         <?php endif;?>
         <li class="treeview">
            <a href="#">
            <i class="fa fa-credit-card-alt"></i><span>Invoice</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="<?=base_url()?>list-invoice">List Invoice</a></li>
               <li><a href="<?=base_url()?>create-invoice">Create Open Invoice</a></li>
            </ul>
         </li>
         <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true):?>
         <li class="treeview"><a href="<?=base_url()?>report"><i class="fa fa-file-text"></i><span>All Reports</span></a>
         </li>
         <?php endif;?>
         <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true):?>
         <li class="treeview">
            <a href="<?=base_url()?>sms">
            <i class="fa fa-envelope"></i><span>SMS</span>
            </a>
         </li>
         <?php endif;?>
         <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true):?>
         <li>
            <a href="<?=base_url()?>setting">
            <i class="fa fa-cog"></i><span>Settings</span> 
            </a>
         </li>
         <?php endif;?>
      </ul>
   </div>
   <!-- /.sidebar -->
</aside>
<div class="content-wrapper">
<header class="main-header">
   <!-- Header Navbar -->
   <nav class="navbars navbar-static-tops ">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> 
      <span class="sr-only">Toggle navigation</span>
      <span class="fa fa-tasks"></span>
      </a>
      <p class="breadcrumb" style="max-width:600px;">
         <span><a href="<?=base_url()?>"><i class="pe-7s-home"></i> Home /</a></span>
         <span class="active" style="color:#fff;"><?=$track?></span>
      </p>
      <div class="navbar-custom-menu">
         <ul class="nav navbar-nav">
            <!-- Notifications -->
            <li class="dropdown notifications-menu">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               <i class="pe-7s-bell"></i>
               <span class="label label-warning totale_userc"><?php echo (intval(get_forgot_leads()) + intval(get_pending_invoice()) + intval(get_calendar_task())+ intval(get_calendar_leads()));?></span>
               </a>
               <ul class="dropdown-menu">
                  <li class="header"><i class="fa fa-bell"></i>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo (intval(get_forgot_leads()) + intval(get_pending_invoice()) + intval(get_calendar_task()) + intval(get_calendar_leads()));?> Notifications</li>
                  <li>
                     <ul class="menu">
                        <li>
                           <a href="<?=base_url('followup-leads')?>" class="border-gray"><i class="fa fa-user-md"></i> Missed Follow Up Leads  <span class=" label-success label label-default pull-right">
                               <?php echo intval(get_forgot_leads());?>
                           </span></a>
                        </li>
                        <li>
                           <a href="<?=base_url('list-invoice?status=pending')?>" class="border-gray"><i class="fa fa-credit-card-alt"></i> Pending Invoice<span class=" label-success label label-default pull-right">
                               <?php echo intval(get_pending_invoice());?>
                           </span> </a>
                        </li>
                        <li>
                           <a href="<?=base_url('task')?>" class="border-gray"><i class="fa fa-sitemap"></i> Today Calendar Task<span class="label-success label label-default pull-right"><?=get_calendar_task()?></span> </a>
                        </li>
                        <li>
                           <a href="<?=base_url('followup-leads?fcal=yes')?>" class="border-gray"><i class="fa fa-calendar"></i> Today Calendar Follow Up<span class="label-success label label-default pull-right"><?=get_calendar_leads()?></span> </a>
                        </li>
                     </ul>
                  </li>
                  <!--<li class="footer">-->
                  <!--   <a href="#"> See all Notifications <i class=" fa fa-arrow-right"></i></a>-->
                  <!--</li>-->
               </ul>
            </li>
            <!-- user -->
            <li class="dropdown dropdown-user admin-user">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <div class="user-image">
                      <?php
                        $src = isset($profile->profile_image) && $profile->profile_image!=='' 
                        ? base_url('resource/system_uploads/agent/').$profile->profile_image 
                        : base_url().'resource/assets/dist/img/avatar5.png';
                        ?>
                     <img src="<?=$src?>" class="img-circle" height="40" width="40" alt="User Image">
                  </div>
               </a>
               <ul class="dropdown-menu">
                  <?php if(!isset($_SESSION['is_admin'])):?>
                  <li><a href=""><i class="fa fa-users"></i> User Profile</a></li>
                  <?php endif;?>
                  <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true):?>
                  <li><a href="<?=base_url()?>setting"><i class="fa fa-gear"></i> Settings</a></li>
                  <?php else:?>
                  <li><a href="<?=base_url()?>profile"><i class="fa fa-gear"></i> Profile</a></li>
                  <?php endif;?>
                  <li><a href="<?=base_url()?>logout"><i class="fa fa-sign-out"></i> Logout</a></li>
               </ul>
            </li>
         </ul>
      </div>
   </nav>
</header>

