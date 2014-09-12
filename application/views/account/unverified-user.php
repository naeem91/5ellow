<div id="unverified-view">
	<div id="inner-unverified-view">
    	<img src="<?php echo base_url(); ?>images/unverified.jpg" />
        <?php echo $this->session->flashdata('status'); ?>
        <div class="warn">
        	<h1 class="user">Hi, <?php echo $user; ?><?php echo $this->session->flashdata('welcome_msg'); ?></h1>
    		<p>Your account is not activated yet. To activate your account, click on the verification link sent to your email address</p>
        	<div class="resend">
        		<span>Have not received verification email?</span>
        		<a href="<?php echo base_url();  ?>resendVerificationEmail">resend verification email</a>
        	</div>
    	</div>
        <br class="clear" />
    </div>
</div>


