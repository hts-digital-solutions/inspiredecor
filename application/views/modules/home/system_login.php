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
	width:330px;
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
	    <?php if(empty($typeref)):?>
		<h3 class="card-title text-center">CRM Login</h3>
		<?php else:?>
		<h3 class="card-title text-center">Setting Access</h3>
		<?php endif;?>
		<div class="card-text">
			<?php if($this->session->flashdata("l-error")):?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
			    <?=$this->session->flashdata("l-error");?>
			</div>
			<?php endif;?>
			<?php if($this->session->flashdata("success")):?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			    <?=$this->session->flashdata("success");?>
			</div>
			<?php endif;?>
			<?php if(isset($_GET['dtrue'])): ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
			    Your account has been disabled! Please contact to administrator for more details.
			</div>
			<?php endif;?>
			<?php if(empty($typeref)):?>
			<form action="<?=base_url()?>home/validateLogin?ref=<?=base64_encode($_SERVER['REMOTE_ADDR'])?>" 
			method="POST" name="systemLogin" id="systemLogin">
			<?php else:?>
			<form action="<?=base_url()?>home/setting_access" 
			method="POST" name="systemLogin" id="systemLogin">
			<?php endif;?>
				<!-- to error: add class "has-danger" -->
				<input type="hidden" name="actype" value="<?php echo isset($typeref) ? $typeref :''; ?>" />
				<?php if(empty($typeref)):?>
				<div class="form-group">
					<label for="exampleInputEmail1">Email address/Username</label>
					<input type="text" 
					class="form-control form-control-sm" 
					id="username" name="username" tabindex="1"/>
				</div>
				<?php endif;?>
				<div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" class="form-control form-control-sm" 
					id="password" name="password" tabindex="2"/>
				</div>
				
				<?php if(empty($typeref)):?>
        		<button type="submit" class="btn btn-primary btn-block" tabindex="3">Sign in</button>
        		<?php else:?>
        		<button type="submit" class="btn btn-primary btn-block" tabindex="4">Access</button>
        		<?php endif;?>
        		<?php if(empty($typeref)):?>
				<a tabindex="5" href="<?=base_url()?>home/forgotpass" style="float:right;color:#009688;font-size:12px;">Forgot password?</a>
				<?php endif;?>
			</form>
		</div>
	</div>
</div>
</div>
<script>
    setTimeout(function(){
        document.querySelector('.alert').style.display = 'none';
    },3000);
    <?php unset($_SESSION['l-error']);unset($_SESSION['success']); ?>    
</script>