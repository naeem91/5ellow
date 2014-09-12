<div id="follows" class="fellow">
	<div id="inner-follows">
    	<h1><?php echo $display_name; ?> follows</h1>
    	<div class="fellows">
        <?php if(isset($follows)): ?>
    		<?php foreach($follows as $follow): ?>
            	<a href="<?php echo base_url().$follow['user']; ?>">
        		<ul>	
        			<li><img src="<?php echo base_url();?>uploads/thumbs/<?php echo $follow['photo']; ?>" /></li>
        			<li><?php echo $follow['name']; ?></li>
            	</ul>
                </a>
        	<?php endforeach; ?>
        <?php endif; ?>
        <br class="clear" />
        </div>
    </div>
</div>