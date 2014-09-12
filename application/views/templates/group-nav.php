<div id="group-nav">
	<img src="<?php echo base_url().'uploads/group_covers/'.$group_info['group_cover']; ?>" width="765" height="200" />	
  	<ul>
      <a href="<?php echo base_url().'groups/'.$group_info['group_name']; ?>"><li class="gname"><?php echo $group_info['group_display_name']; ?></li></a>
      <a href="<?php echo base_url().'groups/'.$group_info['group_name']; ?>/info"><li class="ginfo">Info</li></a>
      <a href="<?php echo base_url().'groups/'.$group_info['group_name']; ?>/photos"><li class="gpotos">Photos</li></a>
      <a href="<?php echo base_url().'groups/'.$group_info['group_name']; ?>/videos"><li class="gvids">Videos</li></a>
      <a href="<?php echo base_url().'groups/'.$group_info['group_name']; ?>/files"><li class="gfils">Files</li></a>
      <?php if($is_group_admin == TRUE): ?>
      	<a href="<?php echo base_url().'groups/'.$group_info['group_name']; ?>/settings"><li class="gseting">Settings</li></a>
      <?php endif; ?>
      
      <br class="clear" />
  </ul>
  <br class="clear" />
</div>