<div class="header" id="signin-header">
    <div id="inner-header">
		<h3><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>images/5ellow-Logo-3-small.png" alt="5ellow logo" /></a></h3>
	</div>
    <?php require_once('search-form.php'); ?>
    
    <div id="header-buttons">
    	<div id="inner-header-buttons">
        	<ul>
            <a href="<?php echo base_url(); ?>account/logout" title="logout"><li class="lout"></li></a> 
                        	<a href="<?php echo base_url(); ?>account/settings" title="settings"><li class="settings"></li></a>
 
            	<?php if($is_admin == TRUE): ?>
	             	<a href="<?php echo base_url(); ?>admin" title="admin panel"><li class="admin">Admin</li></a>           		
                <?php endif; ?>
            	              
            </ul>
            <br class="clear" />	
        </div>
    </div>
</div>
<div id="wrapper">
        	
