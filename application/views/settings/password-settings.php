<div id="reset-password">
	<form method="post" action="<?php echo base_url();?>account/change-password" name="reset-pw" id="resetPass"> 
        	
        		<label for="old password">Old Password</label>
        		<input type="password" name="old-pw" id="oldPass" />
            
    			<label for="new password">New Password</label>
        		<input type="password" name="new-pw" id="newPass" />
            
            <input type="submit"  class="submit" name="submit" value="Save"/>
		</form>
    	<?php if(!empty($notice)):?>
        	<?php echo '<p class="status">'.$notice.'</p>'; ?>
        <?php endif; ?>
        <div id="errors">
        	<?php echo validation_errors(); ?>
        </div>
</div>