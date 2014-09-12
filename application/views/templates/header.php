<div class="header" id="general">
    <div id="inner-header">
		<h3><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>images/5ellow-Logo-3.jpg" alt="5ellow logo" /></a></h3>
	</div>
    <?php if(isset($unverified)): ?>
    	<div id="header-buttons">
    		<div id="inner-header-buttons">
        		<ul>
            		<a href="<?php echo base_url(); ?>account/logout"  title="logout" ><li class="out">Log Out</li></a>                
            	</ul>
            <br class="clear" />	
        	</div>
    	</div>
    <?php endif; ?>
</div>
<div id="wrapper">
        	

<script type="text/javascript">
	$('.out img').mouseover
	(
		function()
		{
			$(this).attr('src','<?php echo base_url(); ?>images/out.gif');
		}
	);
	$('.out img').mouseout
	(
		function()
		{
			$(this).attr('src','<?php echo base_url(); ?>images/out-normal.png');
			//$(this).attr('width','28');
		}
	);
</script>