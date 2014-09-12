<div id="make-fellow">
<form method="post" action="<?php echo base_url(); ?>account/make_fellow">
	<input type="hidden" id="to-follow" name="to-follow" value="<?php echo $this_user_id; ?>" />
    <input type="hidden" id="fellower" name="fellower" value="<?php echo $signed_user_id; ?> "/>
    <input type="hidden" id="name" value="<?php echo $display_name; ?> "/>
	<input class="submit" id="be-fellow" title="follow <?php echo $display_name; ?>" type="submit" value="Be a Fellow" />    
</form>
</div>



<!--ajax script to make friends -->

<script type="text/javascript"> 
	$(document).ready
	(
		function()
		{
			$('#be-fellow').click
			(
				function()
				{
					var toFollow = $('#to-follow').val();
					var fellower = $('#fellower').val();
					var name = $('#name').val();
					
					$('#make-fellow').load("<?php echo base_url(); ?>account/make_fellow",{name:name,toFollow:toFollow,fellower:fellower});
					return false;
				}
			);			
		}
	);
</script>
