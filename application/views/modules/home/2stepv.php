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
		<h3 class="card-title text-center">2 Step Verification</h3>
		<div class="card-text">
			<?php if($this->session->flashdata("l-error")):?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
			    <?=$this->session->flashdata("l-error");?>
			</div>
			<?php elseif($this->session->flashdata("l-success")):?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			    <?=$this->session->flashdata("l-success");?>
			</div>
			<?php endif;?>
			<form action="<?=base_url()?>home/V2stepverify?os=yes" 
			method="POST" name="systemLogin" id="systemLogin">
				<!-- to error: add class "has-danger" -->
				<input type="hidden" name='roll' 
				value="<?php echo isset($_GET['r']) ?$_GET['r'] : '' ?>" />
				<input type="hidden" name='isv' 
				value="<?php echo isset($_GET['isv']) ?$_GET['isv'] : '' ?>" />
				<div class="form-group">
					<label for="exampleInputEmail1">Enter OTP</label>
					<input type="text" 
					class="form-control form-control-sm" 
					id="otp" name="otp" required tabindex="1"/>
				</div>
				<!--<a href="javascript:;" onclick="resendOtp()" style="float:right;">Resend</a>-->
				<button type="submit" class="btn btn-primary btn-block" tabindex="2">Sign in</button>
			</form>
		</div>
	</div>
</div>
</div>
<script>
    setTimeout(function(){
        document.querySelector('.alert').style.display = 'none';
    },1000);
        
</script>