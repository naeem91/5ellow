<?php $this->load->view('templates/head'); ?>
<div class="login">
	<?php $this->load->view('templates/header'); ?>
    	<div id="forms-section">
        	<div id="inner-forms-section">
            	
    				<h1>Login</h1>
                
				<?php $this->load->view('templates/login-form'); ?>
            	<br class="clear" />
            	<p>need an account? <a class="signup" href="<?php echo base_url(); ?>signup">SignUp</a></p>
            </div>
        </div>
</div>
<?php $this->load->view('templates/footer');?>
