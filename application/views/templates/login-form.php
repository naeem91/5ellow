<div id="login">
	<div id="inner-login">
    	<div id="errors">
			<?php echo validation_errors(); ?>
    	</div>
    	<form method="post" action="<?php echo base_url(); ?>login" name="sign-in" id="sign-in">
        	<div>
    		<label for="email">Email</label>
            <input type="text" name="useremail" id="useremail" value="<?php echo set_value('useremail'); ?>" />
            
            </div>
            <div>
        	<label for="password">Password</label>
            <input type="password" name="userpass" id="userpass"  />
            <a href="<?php echo base_url();?>forgetPassword" id="forgot">forgot password?</a>
            </div>
            <div class="keepin">
            	<input type="checkbox" name="keep-signin" id="keep-signin" />
                keep me signed in
            </div>
        	<input class="submit" type="submit" name="submit" value="Login" />
    	</form>
    	
	</div>
</div>