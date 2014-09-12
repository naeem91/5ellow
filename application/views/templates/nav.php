<div id="nav">
   <div id="inner-nav">
   		<div class="profile-pic">
        	<a href="<?php echo base_url().$signed_user_name; ?>" >
            	<img src="<?php echo base_url();?>uploads/thumbs/<?php echo $signed_user_photo; ?>" width="65" height="65" />
                <p class="display-name"><?php echo $signed_user_display; ?></p>
            </a>
            <br class="clear" />
       </div>
       <ul>
           <a href="<?php echo base_url(); ?>community"><li class="home">Home</li></a>
           <a href="<?php echo base_url().$signed_user_name ?>"><li class="info">My Stream</li></a>                      
           <a href="<?php echo base_url().$signed_user_name ?>/notifications">
           		<li class="notif">
           			Notifications
                	<?php if($notifications == FALSE): ?>
                		<span class="notify"></span>
                	<?php else: ?>
                	<span class="notify"><img src="<?php echo base_url(); ?>images/notifs.png" /></span>
                		<?php endif; ?>
           		</li>
           </a>
           <a href="<?php echo base_url().$signed_user_name ?>/messages">
           		<li class="msgs">
                	Messages
                	<?php if($msgs == TRUE): ?>
                		<span class="new-msg"><img src="<?php echo base_url(); ?>images/notifs.png" /></span>
               		<?php else: ?>
                		<span class="new-msg"></span>
                	<?php endif; ?>
           </li>
           </a>
           <a href="<?php echo base_url().$signed_user_name ?>/groups">
           		<li class="groups">
                	Groups
                </li>
           </a>
       </ul>
       <ul class="alerts">
       		<span class="link"><a href="<?php echo base_url().$signed_user_name; ?>/notifications">all notifications</a></span>
       		<?php if($notifications == FALSE): ?>
				<li class="msg">No new notifications</li>
           	<?php else: ?>
            	<?php foreach($notifications as $notice): ?>
                	<li><?php echo $notice; ?></li>
                <?php endforeach; ?>
            <?php endif; ?>       
       </ul>
	</div>
</div>    


