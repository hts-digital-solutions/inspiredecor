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
		<h3 class="card-title text-center">Enter New Password</h3>
		<div class="card-text">
			<?php if($this->session->flashdata("error")):?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
			    <?=$this->session->flashdata("error");?>
			</div>
			<?php endif;?>
			<?php if($this->session->flashdata("success")):?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			    <?=$this->session->flashdata("success");?>
			</div>
			<?php endif;?>
			<form action="<?=base_url()?>home/forgot_password_recover?token=<?=$_GET['token']?>" 
			method="POST" name="newPass" id="newPass">
				<div class="form-group">
					<label for="exampleInputEmail1">New Password</label>
					<input type="password" 
					class="form-control form-control-sm" 
					id="newpass" name="newpass" tabindex="1"/>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Confirm Password</label>
					<input type="text" 
					class="form-control form-control-sm" 
					id="cpass" name="cpass" tabindex="2"/>
				</div>
        		<button type="submit" class="btn btn-primary btn-block" tabindex="3">Submit</button>
			</form>
		</div>
	</div>
</div>
</div>
<script>
    setTimeout(function(){
        document.querySelector('.alert').style.display = 'none';
    },3000);
    <?php unset($_SESSION['error']);unset($_SESSION['success']); ?>    
</script>