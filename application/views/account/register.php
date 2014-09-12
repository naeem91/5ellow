<?php $this->load->view('templates/head'); ?>
<div class="signup">
	<?php $this->load->view('templates/header'); ?>
    	<div id="forms-section">
        	<div id="inner-forms-section">
            <?php if($signup_enable == TRUE): ?>
    		<h1>SignUp</h1>
			<?php $this->load->view('templates/signup-form'); ?>
                    <br class="clear" />

        	<p>already a member? <a  class="signin" href="<?php echo base_url();?>login">sign in</a></p>
            <?php else: ?>
            	<h1>New Account registration is temporarily closed</h1>
            <?php endif; ?>
        	</div>
        </div> 
</div>      
<?php $this->load->view('templates/footer'); ?>
