<div id="search-results">
	<div id="inner-search-results">
    	<h1 class="title">Search results: <?php echo $this->input->get('q'); ?></h1>
        
        <?php if($uresults != FALSE): ?>
        	<div class="fellows">
            <h1>Fellows</h1>
        	<?php foreach($uresults as $ur): ?>
            	<ul>
                	<a href="<?php echo base_url().$ur['user_name']; ?>"><strong></strong>
            			<li><img src="<?php echo base_url();?>uploads/thumbs/<?php echo $ur['photo']; ?>" width="65" height="65" /></li>
                		<li><?php echo $ur['display_name']; ?></li>
                    </a>
                </ul>
            <?php endforeach; ?>
            <br class="clear" />
           	</div>
        <?php endif; ?>
        
        <?php if($gresults != FALSE): ?>
        	<ul class="groups">
            <h1>Groups</h1>
        	<?php foreach($gresults as $gr): ?>
            	<li><a href="<?php echo base_url().'groups/'.$gr['group_name']; ?>"><?php echo $gr['group_display_name']; ?></a></li>
            <?php endforeach; ?>
           	</ul>
        <?php endif; ?>
              
    </div>
</div>


<script type="text/javascript">
	var q = '<?php echo $this->input->get('q');  ?>';
	$('#search').val(q);
</script>