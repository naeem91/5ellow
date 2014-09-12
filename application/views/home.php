<?php $this->load->view('templates/head'); ?>
<div class="home">
<?php	$this->load->view('templates/header'); ?>
	<div id="hopts">
	<div id="promo">
    	<div id="inner-promo">
        	<img src="<?php echo base_url();?>images/promo.jpg"  />
        </div>
    </div>
	<div id="forms-section">
		<div id="inner-forms-section">
        	<h1>Sign in</h1>	
			<?php $this->load->view('templates/login-form'); ?>
            <?php if($signup_enable == TRUE): ?>
            
            <h1>Sign Up</h1>
				<?php $this->load->view('templates/signup-form'); ?>
           	<?php endif; ?>
    	</div>
	</div>
    <br class="clear" />
    </div>
</div>
<?php $this->load->view('templates/footer'); ?>

