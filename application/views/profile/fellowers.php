<div id="fellowers" class="fellow">
	<div id="inner-fellowers">
    	
    	<div class="fellows">
        <?php if(isset($fellowers)): ?>
        	<?php if($fellowers != FALSE): ?>
    		<?php foreach($fellowers as $fellower): ?>
            	<a href="<?php echo base_url().$fellower['user']; ?>">
        		<ul>	
        			<li><img src="<?php echo base_url();?>uploads/thumbs/<?php echo $fellower['photo']; ?>" width="65" height="65" /></li>
        			<li><?php echo $fellower['name']; ?></li>
            	</ul>
                </a>
        	<?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
        <br class="clear" />
        </div>
    </div>
</div>