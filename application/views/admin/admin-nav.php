<div id="admin-nav">
	<ul>
    	<a href="<?php echo base_url().'admin'; ?>"><li class="stats">Stats</li></a>
        <a href="<?php echo base_url().'admin/services'; ?>"><li class="srvcs">Services</li></a>
    	<a href="<?php echo base_url().'admin/users'; ?>"><li class="users">Users</li></a>
 		<?php if($super_admin == TRUE): ?>
        	<a href="<?php echo base_url().'admin/admins'; ?>"><li class="admins">Admins</li></a>
        <?php endif; ?>
        <br class="clear" />
    </ul>
</div>