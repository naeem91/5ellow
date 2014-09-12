<div id="forget-password">
	<?php echo $this->session->flashdata('status'); ?>
    <h1>Forgot Password</h1>
	<p class="msg">Enter your email address, a temporary password will be sent to your email address.</p>
	<form method="post" action="<?php echo base_url(); ?>forgetPassword" name="forget-password">
    	<label for="email address">Email Address</label>
        <input type="text" name="email-id" id="emailId" value="<?php echo set_value('email-id'); ?>" />
        <input type="submit" class="submit" value="Email Password" />
    </form>
    <div id="errors">
    	<?php echo validation_errors(); ?>
    </div>
</div>
<?php $this->load->view('templates/footer');?>
