<div id="notifs">
	<div id="inner-notifs">
    	
        <?php if($all_notifs != FALSE): ?>
        	<ul>
        	<?php foreach($all_notifs as $notice): ?>
        		<li><?php echo $notice; ?></li>
        	<?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>