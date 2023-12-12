<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>
<!doctype html>
<html>
    <head>
        <title>System Setup</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url()?>resource/setup/apple-touch-icon.png" />
        <link rel="icon" sizes="32x32" type="image/png" href="<?=base_url()?>resource/setup/favicon-32x32.png" />
        <link rel="icon" sizes="16x16" type="image/png" href="<?=base_url()?>resource/setup/favicon-16x16.png" />
        <link rel="manifest" href="<?=base_url()?>resource/setup/site.webmanifest" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
        <style>
            @import url('https://fonts.googleapis.com/css?family=Roboto');

body{
	font-family: 'Roboto', sans-serif;
}
* {
	margin: 0;
	padding: 0;
}
i {
	margin-right: 10px;
}

/*------------------------*/
button{
    cursor:pointer;
}
input:focus,
button:focus,
.form-control:focus{
	outline: none;
	box-shadow: none;
}
.form-control:disabled, .form-control[readonly]{
	background-color: #fff;
}
/*----------step-wizard------------*/
.d-flex{
	display: flex;
}
.justify-content-center{
	justify-content: center;
}
.align-items-center{
	align-items: center;
}

/*---------signup-step-------------*/
.bg-color{
	background-color: #333;
}
.signup-step-container{
	padding: 50px 0px;
	padding-bottom: 60px;
}

    .wizard .nav-tabs {
        position: relative;
        margin-bottom: 0;
        border-bottom-color: transparent;
    }

    .wizard > div.wizard-inner {
            position: relative;
    margin-bottom: 50px;
    text-align: center;
    }

.connecting-line {
    height: 2px;
    background: #e0e0e0;
    position: absolute;
    width: 75%;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 15px;
    z-index: 1;
}

.wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
    color: #555555;
    cursor: default;
    border: 0;
    border-bottom-color: transparent;
}
span.round-tab {
    width: 30px;
    height: 30px;
    line-height: 30px;
    display: inline-block;
    border-radius: 50%;
    background: #fff;
    z-index: 2;
    position: absolute;
    left: 0;
    text-align: center;
    font-size: 16px;
    color: #0e214b;
    font-weight: 500;
    border: 1px solid #ddd;
}
span.round-tab i{
    color:#555555;
}
.wizard li.active span.round-tab {
        background: #0db02b;
    color: #fff;
    border-color: #0db02b;
}
.wizard li.active span.round-tab i{
    color: #5bc0de;
}
.wizard .nav-tabs > li.active > a i{
	color: #0db02b;
}

.wizard .nav-tabs > li {
    width: 25%;
}

.wizard li:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 0;
    margin: 0 auto;
    bottom: 0px;
    border: 5px solid transparent;
    border-bottom-color: red;
    transition: 0.1s ease-in-out;
}



.wizard .nav-tabs > li a {
    width: 30px;
    height: 30px;
    margin: 20px auto;
    border-radius: 100%;
    padding: 0;
    background-color: transparent;
    position: relative;
    top: 0;
}
.wizard .nav-tabs > li a i{
	position: absolute;
    top: -15px;
    font-style: normal;
    font-weight: 400;
    white-space: nowrap;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 12px;
    font-weight: 700;
    color: #000;
}

    .wizard .nav-tabs > li a:hover {
        background: transparent;
    }

.wizard .tab {
    position: relative;
    padding-top: 20px;
}


.wizard h3 {
    margin-top: 0;
}
.prev-step,
.next-step{
    font-size: 13px;
    padding: 8px 24px;
    border: none;
    border-radius: 4px;
    margin-top: 30px;
}
.next-step{
	background-color: #0db02b;
}
.skip-btn{
	background-color: #cec12d;
}
.step-head{
    font-size: 20px;
    text-align: center;
    font-weight: 500;
    margin-bottom: 20px;
}
.term-check{
	font-size: 14px;
	font-weight: 400;
}
.custom-file {
    position: relative;
    display: inline-block;
    width: 100%;
    height: 40px;
    margin-bottom: 0;
}
.custom-file-input {
    position: relative;
    z-index: 2;
    width: 100%;
    height: 40px;
    margin: 0;
    opacity: 0;
}
.custom-file-label {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1;
    height: 40px;
    padding: .375rem .75rem;
    font-weight: 400;
    line-height: 2;
    color: #495057;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: .25rem;
}
.custom-file-label::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 3;
    display: block;
    height: 38px;
    padding: .375rem .75rem;
    line-height: 2;
    color: #495057;
    content: "Browse";
    background-color: #e9ecef;
    border-left: inherit;
    border-radius: 0 .25rem .25rem 0;
}
.footer-link{
	margin-top: 30px;
}
.all-info-container{

}
.list-content{
	margin-bottom: 10px;
}
.list-content a{
	padding: 10px 15px;
    width: 100%;
    display: inline-block;
    background-color: #f5f5f5;
    position: relative;
    color: #565656;
    font-weight: 400;
    border-radius: 4px;
}
.list-content a[aria-expanded="true"] i{
	transform: rotate(180deg);
}
.list-content a i{
	text-align: right;
    position: absolute;
    top: 15px;
    right: 10px;
    transition: 0.5s;
}
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #fdfdfd;
}
.list-box{
	padding: 10px;
}
.signup-logo-header .logo_area{
	width: 200px;
}
.signup-logo-header .nav > li{
	padding: 0;
}
.signup-logo-header .header-flex{
	display: flex;
	justify-content: center;
	align-items: center;
}
.list-inline li{
    display: inline-block;
}
.pull-right{
    float: right;
}
/*-----------custom-checkbox-----------*/
/*----------Custom-Checkbox---------*/
input[type="checkbox"]{
    position: relative;
    display: inline-block;
    margin-right: 5px;
}
input[type="checkbox"]::before,
input[type="checkbox"]::after {
    position: absolute;
    content: "";
    display: inline-block;   
}
input[type="checkbox"]::before{
    height: 16px;
    width: 16px;
    border: 1px solid #999;
    left: 0px;
    top: 0px;
    background-color: #fff;
    border-radius: 2px;
}
input[type="checkbox"]::after{
    height: 5px;
    width: 9px;
    left: 4px;
    top: 4px;
}
input[type="checkbox"]:checked::after{
    content: "";
    border-left: 1px solid #fff;
    border-bottom: 1px solid #fff;
    transform: rotate(-45deg);
}
input[type="checkbox"]:checked::before{
    background-color: #18ba60;
    border-color: #18ba60;
}

a,a:hover{
    text-decoration:none;
    color:#000;
}

@media (max-width: 767px){
	.sign-content h3{
		font-size: 40px;
	}
	.wizard .nav-tabs > li a i{
		display: none;
	}
	.signup-logo-header .navbar-toggle{
		margin: 0;
		margin-top: 8px;
	}
	.signup-logo-header .logo_area{
		margin-top: 0;
	}
	.signup-logo-header .header-flex{
		display: block;
	}
}

    </style>
    </head>
    <body>
        <div class="container">
            <section class="signup-step-container">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="wizard">
                            <div class="wizard-inner">
                                <div class="connecting-line"></div>
                                <?php
                                
                                    if(!isset($_GET['step'])){
                                        redirect('System_Installer/setup?step=1');
                                    }
                                
                                    $step1 = $step2 = $step3 = $step4 = "disabled";
                                    if(isset($_GET['step']) && $_GET['step']==1){
                                        $step1 = "active";
                                    }
                                    if(isset($_GET['step']) && $_GET['step']==2){
                                        $step2 = "active";
                                    }
                                    if(isset($_GET['step']) && $_GET['step']==3){
                                        $step3 = "active";
                                    }
                                    if(isset($_GET['step']) && $_GET['step']==4){
                                        $step4 = "active";
                                    }
                                ?>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="<?=$step1?>">
                                        <a href="javascript:;" ><span class="round-tab">1 </span> <i>Environment Check</i></a>
                                    </li>
                                    <li role="presentation" class="<?=$step2?>">
                                        <a href="javascript:;" ><span class="round-tab">2</span> <i>Activation</i></a>
                                    </li>
                                    <li role="presentation" class="<?=$step3?>">
                                        <a href="javascript:;" ><span class="round-tab">3</span> <i>Database SetUp</i></a>
                                    </li>
                                    <li role="presentation" class="<?=$step4?>">
                                        <a href="javascript:;" ><span class="round-tab">4</span> <i>Account Details</i></a>
                                    </li>
                                </ul>
                            </div>
                            <?php
                            $config_file = "./application/config/config.php";
                            $database_file = "./application/config/database.php";
                            $autoload_file = "./application/config/autoload.php";
                            $route_file = "./application/config/routes.php";
                            $htaccess_file = ".htaccess";
                            $error = FALSE;
                            ?>
                            
                            <div class="col-md-12">
                                <?php if($this->session->flashdata('error')):?>
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <?= $this->session->flashdata('error') ?>
                                </div>
                                <?php endif;?>
                            </div>
                            
                            <div class="tab-content" id="main_form">
                                <?php if(isset($_GET['step']) && $_GET['step']==1): ?>
                                    <div class="tab active" role="tabpanel" id="step1">
                                        <div class="row">
                                            <div class="col-md-6" style="margin:50px auto;">
                                                <?php
                                                $next = false;
                                                if(
                                                    phpversion() > "5.3"
                                                    && extension_loaded('mysqli')
                                                    && extension_loaded('imap')
                                                    && extension_loaded('mbstring')
                                                    && extension_loaded('zip')
                                                    && extension_loaded('gd')
                                                    && extension_loaded('pdo')
                                                    && extension_loaded('curl')
                                                    && is_writeable($database_file)
                                                    && is_writeable($config_file)
                                                    && is_writeable($route_file)
                                                    && is_writeable($autoload_file)
                                                    && is_writeable($htaccess_file)
                                                    && is_writeable("./resource/tmp")
                                                    
                                                  ){
                                                     $next = true;
                                                      echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i>
                                                            Everything is fine :)
                                                            </div>";
                                                   }else{
                                                    
                                                    if(phpversion() < "5.3"){ $error = TRUE;
                                                        echo "<div class='alert alert-danger'>Your PHP version is ".phpversion()."<i class='fa fa-times'></i>! PHP 5.3 or higher required!</div>"; }
                                                    if(!extension_loaded('mysqli')){$error = TRUE; echo "<div class='alert alert-danger'><i class='fa fa-times'></i>Mysqli PHP extension missing!</div>";}
                                                    if(!extension_loaded('imap')){$error = TRUE; echo "<div class='alert alert-danger'><i class='fa fa-times'></i>IMAP PHP extension missing!</div>";}
                                                    if(!extension_loaded('mbstring')){$error = TRUE; echo "<div class='alert alert-danger'><i class='fa fa-times'></i>MBString PHP extension missing!</div>";}
                                                    if(!extension_loaded('zip')){$error = TRUE; echo "<div class='alert alert-danger'><i class='fa fa-times'></i>ZIP PHP extension missing!</div>";}
                                                    if(!extension_loaded('gd')){echo "<div class='alert alert-danger'>GD PHP extension missing!</div>";}
                                                    if(!extension_loaded('pdo')){$error = TRUE; echo "<div class='alert alert-danger'><i class='fa fa-times'></i>PDO PHP extension missing!</div>";}
                                                    if(!extension_loaded('curl')){$error = TRUE; echo "<div class='alert alert-danger'><i class='fa fa-times'></i>CURL PHP extension missing!</div>";}
                                                    if(!is_writeable($database_file)){$error = TRUE; echo "<div class='alert alert-danger'><i class='fa fa-times'></i>Database File (application/config/database.php) is not writeable!</div>";}
                                                    if(!is_writeable($config_file)){$error = TRUE; echo "<div class='alert alert-danger'><i class='fa fa-times'></i>Config File (application/config/config.php) is not writeable!</div>";}
                                                    if(!is_writeable($route_file)){$error = TRUE; echo "<div class='alert alert-danger'><i class='fa fa-times'></i>Route File (application/config/routes.php) is not writeable!</div>";}
                                                    if(!is_writeable($autoload_file)){$error = TRUE; echo "<div class='alert alert-danger'><i class='fa fa-times'></i>Autoload File (application/config/autoload.php) is not writeable!</div>";}
                                                    if(!is_writeable($htaccess_file)){$error = TRUE; echo "<div class='alert alert-danger'><i class='fa fa-times'></i>HTACCESS File (.htaccess) is not writeable!</div>";}
                                                    if(!is_writeable("./resource/tmp")){echo "<div class='alert alert-danger'><i class='fa fa-times'></i> /resource/tmp folder is not writeable!</div>";}
                                                    
                                                    $next = false;
                                                  
                                                   }
                                                 
                                                 ?>
                                            </div>
                                        </div>
                                        <ul class="list-inline pull-right">
                                            <li><a href="<?php echo ($next) ? base_url().'index.php/System_Installer/start': '';?>" 
                                            class="default-btn next-step">Continue to next step</a></li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <?php if(isset($_GET['step']) && $_GET['step']==2): ?>    
                                    <form action="<?=base_url().'index.php/System_Installer/verify'?>"
                                    method="post" name="verifyform" id="verifyform">
                                        <div class="tab" role="tabpanel" id="step2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Username</label> 
                                                    <input class="form-control" 
                                                    value="<?php echo isset($_SESSION['step2_data']['check_username'])? $_SESSION['step2_data']['check_username']: ''; ?>"
                                                    type="text" name="check_username" required /> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Host Ip Address</label> 
                                                    <input class="form-control" 
                                                    value="<?php echo isset($_SESSION['step2_data']['check_hostip'])? $_SESSION['step2_data']['check_hostip']: $_SERVER['SERVER_ADDR']; ?>"
                                                    type="text" name="check_hostip" required /> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Domain Name</label> 
                                                    <input class="form-control" 
                                                    value="<?php echo isset($_SESSION['step2_data']['check_domain'])? $_SESSION['step2_data']['check_domain']: $_SERVER['HTTP_HOST']; ?>"
                                                    type="text" name="check_domain" required /> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Purchase Key</label> 
                                                    <input class="form-control" style="text-transform:uppercase;"
                                                    value="<?php echo isset($_SESSION['step2_data']['check_purchase_key'])? $_SESSION['step2_data']['check_purchase_key']: ''; ?>"
                                                    type="text" name="check_purchase_key" required /> 
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-inline pull-right">
                                            <li><a href="<?=base_url().'index.php/System_Installer/setup?step=1'?>" class="default-btn prev-step">Back</a></li>
                                            <li><button type="submit" class="default-btn next-step">Continue</button></li>
                                        </ul>
                                    </div>
                                    </form>
                                <?php endif; ?>  
                                <?php if(isset($_GET['step']) && $_GET['step']==3): ?>    
                                    <form action="<?=base_url().'index.php/System_Installer/db_setup'?>" 
                                    method="post" id="formstep3" name="formstep3">
                                        <div class="tab" role="tabpanel" id="step3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Host Name</label> 
                                                    <input class="form-control" 
                                                    value="<?php echo isset($_SESSION['step3_data']['set_hostname'])? $_SESSION['step3_data']['set_hostname']: ''; ?>"
                                                    type="text" name="set_hostname" 
                                                    placeholder="localhost" required /> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Database Name</label> 
                                                    <input class="form-control" 
                                                    value="<?php echo isset($_SESSION['step3_data']['set_database'])? $_SESSION['step3_data']['set_database']: ''; ?>"
                                                    type="text" name="set_database" required /> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Username</label> 
                                                    <input class="form-control" 
                                                    value="<?php echo isset($_SESSION['step3_data']['set_db_user'])? $_SESSION['step3_data']['set_db_user']: ''; ?>"
                                                    type="text" name="set_db_user" required /> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Password</label> 
                                                    <input class="form-control" 
                                                    value="<?php echo isset($_SESSION['step3_data']['set_db_pass'])? $_SESSION['step3_data']['set_db_pass']: ''; ?>"
                                                    type="password" name="set_db_pass" required /> 
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <ul class="list-inline pull-right">
                                            <li><a href="<?=base_url().'index.php/System_Installer/setup?step=2'?>" class="default-btn prev-step">Back</a></li>
                                            <li><button type="submit" class="default-btn next-step">Continue</button></li>
                                        </ul>
                                    </div>
                                    </form>
                                <?php endif; ?> 
                                <?php if(isset($_GET['step']) && $_GET['step']==4): ?> 
                                    <form action="<?=base_url().'index.php/System_Installer/complete'?>"
                                    method="post" name="completeform" id="completeform">
                                        <?php
                                        $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
                                        $base_url .= "://".$_SERVER['HTTP_HOST'];
                                        $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
                                        ?>
                                        <div class="tab" role="tabpanel" id="step4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Company Domain</label> 
                                                    <input class="form-control" type="text" name="set_base_url" 
                                                    value="<?=$base_url?>" required /> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Full Name</label> 
                                                    <input class="form-control" type="text" name="set_admin_fullname"
                                                    required /> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Admin Username</label> 
                                                    <input class="form-control" type="text" name="set_admin_username"
                                                    required /> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Admin Password</label> 
                                                    <input class="form-control" type="password" name="set_admin_pass"
                                                    required /> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Admin Email</label> 
                                                    <input class="form-control" type="email" name="set_admin_email"
                                                    required /> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Company Name</label> 
                                                    <input class="form-control" type="text" name="set_company_name"
                                                    required /> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Company Email</label> 
                                                    <input class="form-control" type="email" name="set_company_email"
                                                    required /> 
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-inline pull-right">
                                            <li><a href="<?=base_url().'index.php/System_Installer/setup?step=3'?>" class="default-btn prev-step">Back</a></li>
                                            <li><button type="submit" class="default-btn next-step">Finish</button></li>
                                        </ul>
                                    </div>
                                    </form>
                                <?php endif; ?>   
                                    <div class="clearfix"></div>
                                </div>
                                
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </div> 
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        
    </script>
    </body>
</html>