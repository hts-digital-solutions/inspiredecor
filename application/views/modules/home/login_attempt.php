<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

?>
<style>
    html,body { 
	height: 100%; 
}

.global-container,.wrapper{
	height:100%;
	display: flex;
	align-items: center;
	justify-content: center;
	background-color: #f5f5f5;
}

form{
	padding-top: 10px;
	font-size: 14px;
	margin-top: 30px;
}

.card-title{ font-weight:700; }

.login-form{ 
	max-width:550px;
	margin:20px;
}

.btn{
    display:flex;
    align-items:center;
	justify-content:center;
	padding:5px 10px;
	background:#009688;
	border-color:#009688;
}

.alert{
	margin-bottom:-30px;
	font-size: 13px;
	margin-top:20px;
}
</style>
<div class="global-container">
	<div class="card login-form">
	<div class="card-body">
		<h3 class="card-title text-center">Login Attempt Verify</h3>
		<div class="card-text">
			<p>It has been noticed that a new login location found. Ignore this if it was you else take action.</p>
			<br/>
			<h4>Login Details :</h4>
			<table class="table">
			    <tr>
			        <td>Login time :</td>
			        <td>
			            <mark>
			            <?php echo isset($ldetails->login_time) ? date("d-m-Y H:i:s A",strtotime($ldetails->login_time)) : ''; ?>
			            </mark>
			        </td>
			    </tr>
			    <tr>
			        <td>Login location :</td>
			        <td>
			            <mark>
			                <?php if(isset($ldetails->login_place)){
			                $p = @unserialize($ldetails->login_place);
			                print_r($p['regionName'].", ".$p['city'].", ".$p['country']);
			                }; ?>
			            </mark>
			        </td>
			    </tr>
			    <tr>
			        <td>Login IP :</td>
			        <td>
			            <mark>
			                <?php echo isset($ldetails->login_ip) ? $ldetails->login_ip : ''; ?>
			            </mark>
			        </td>
			    </tr>
			    <tr>
			        <td>Browser Used :</td>
			        <td>
			            <mark>
			                <?php echo isset($ldetails->browser_used) ? $ldetails->browser_used : ''; ?>
			            </mark>
			        </td>
			    </tr>
			    <tr>
			        <td>OS Used :</td>
			        <td>
			            <mark>
			                <?php echo isset($ldetails->platform) ? $ldetails->platform : ''; ?>
			            </mark>
			        </td>
			    </tr>
			    <tr>
			        <td><a href="<?=base_url('home/block/')?><?=$_GET['token']?>" 
			        class="btn btn-sm btn-block btn-primary">Block</a></td>
			        <td><a href="<?=base_url()?>home/ignore/<?=$_GET['token']?>" 
			        class="btn btn-sm btn-block btn-danger" style="background:red;">Ignore</a></td>
			    </tr>
			</table>
		</div>
	</div>
</div>
</div>