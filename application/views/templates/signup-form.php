<div id="signup">
	<div id="inner-signup">
   		<form method="post" action="<?php echo base_url();?>signup" name="sign-up" id="sign-up">
        	<div>
   			<label for="user">Your Name</label>
        	<input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>"/>
            </div>
            <div>
			<label for="email">Email</label>	
        	<input type="text" name="email" id="email" value="<?php echo set_value('email'); ?>"/>
            </div>
            <div>
    		<label for="password">Password</label>
        	<input type="password" name="pass" id="pass"  />
            </div>
    		<input class="submit" type="submit" name="submit" value="Signup" />
		</form>    
    	<div id="errors">
    		<?php echo validation_errors(); ?>
    	</div>    
	</div>
</div>