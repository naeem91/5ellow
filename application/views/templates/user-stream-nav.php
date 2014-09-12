<?php if($show_postbox == FALSE): ?>
            	<div class="profile-pic">
    				<a href="<?php echo base_url().$user_name ?>">
        				<img src="<?php echo base_url();?>uploads/thumbs/<?php echo $profile_pic; ?>" width="80" height="80" />
        				<p class="display-name"><?php echo $display_name; ?></p>
            		</a>
                </div>
<?php endif; ?>
<div id="user-stream-nav">
	<div id="inner-user-stream-nav">
    	<ul>
        	<a href="<?php echo base_url().$user_name ?>/info"><li class="info">Profile</li></a>
        	<a href="<?php echo base_url().$user_name ?>/fellows"><li class="felow">Fellows</li></a>            
        	<a href="<?php echo base_url().$user_name ?>/photos"><li class="poto">Photos</li></a>                       
            <a href="<?php echo base_url().$user_name ?>/videos"><li class="vido">Videos</li></a>                        
         	<a href="<?php echo base_url().$user_name ?>/files"><li class="fils">Files</li></a>                        
        </ul>
        <br class="clear" />
    </div>
</div>