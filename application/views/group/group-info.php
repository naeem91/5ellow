<div id="group-info">
	<div id="inner-group-info">
    	<?php $this->load->view('templates/group-nav'); ?>
        
        <div class="group-info">
        	<p><?php echo $group_info['group_description']; ?></p>
        </div>
        
        <div class="gm">
        <h1>Group Members</h1>
        <?php if($is_group_admin): ?>
            <div class="add-member">
                <div>
                    <label>Add Member</label>
                    <input type="text" id="member"  />
                    <input type="button" id="add-member" value="add" class="submit" />
                </div>
                <p class="warn"></p>    
            </div>
        <?php endif; ?>
        <div class="group-members">
			<?php if($group_info['members'] != FALSE): ?>
            	
                <?php foreach($group_info['members'] as $member): ?>
                    <ul id="memr<?php echo $member['user_id']; ?> " class="mem">	
                    	<a href="<?php echo base_url().$member['user_name']; ?>">
                        	<li><img src="<?php echo base_url();?>uploads/thumbs/<?php echo $member['photo']; ?>" width="65" height="65" /></li>
                        	<li class="display"><?php echo $member['display_name']; ?></li>
                        </a>
                        <?php if($is_group_admin == TRUE && $member['user_id'] != $group_info['group_creator']): ?>
                        	<a href="#" title="Delete from group" class="del-member" id="del<?php echo $member['user_id']; ?>"><img src="<?php echo base_url();?>images/del-hov.png"  /></a>
                        <?php endif;?>
                    </ul>
                <?php endforeach; ?>
                	<br class="clear" />
            <?php endif; ?>
            <br class="clear" />
            </div>
        </div>
        
         </div>
         
            <div id="warn" title="Confirm delete?">
         	
         	</div>
        
        
    </div>
</div>


<script type="text/javascript">
	$(document).ready
	(
		function()
		{
			/*$('.add-member').hide();*/
			$('.del-member').hide();
			
			
			
			$('#add').click
			(
				function()
				{
					$('.add-member').toggle('slow');
				}
			);
			
			$('ul.mem').livequery
			(
				'hover',
				function()
				{
					var id = parseInt(this.id.replace("memr", ""));
					$('#del'+id).toggle();
				}
			);
			
			$('.del-member').click
			(
				function()
				{
					var uid = parseInt(this.id.replace("del", ""));
					var gid = '<?php echo $group_info["group_id"]; ?>';
					
					
					
					var warn = "Are you sure you want to delete this member from group?";
					$('#warn').html(warn).dialog({modal: true,
					width : '370px',height : 'auto', resizable:false, closeOnEscape:true,
					focus:true,buttons:
					{
						"Yes":function()
						{
							//alert($('ul#memr'+uid).attr('class'));
							$.post
							(
								"<?php echo base_url(); ?>group/del_member",
								{user:uid,group:gid},
								function(data)
								{
									//$('#mem'+uid).remove();
									//alert(data);
									if(data == '1')
									{
										//alert(uid);
										$('#mem'+uid).remove();
									}
								}								
							);
							
							
							$( this ).dialog( "close" );
						},
						"Cancel":function()
						{
							$( this ).dialog( "close" );
						}
					}});
					
					
					return false;
				}
			);
			
			var mid = '';
			$('#member').autocomplete
			(
				{
					source:"<?php echo base_url(); ?>members/get_members",
					select: function( event, ui ) 
					{
						mid = ui.item.id;
						//alert( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
					} 	
				}
			);
			
			$('#add-member').click
			(
				function()
				{
					
					var gid = '<?php echo $group_info["group_id"]; ?>';
					var uname = $('#member').val();
					
					if(uname == '')
					{
						$('#member').focus();
						return false;
					}
					if(mid == '')
					{
						//alert('not exist');
						$('.warn').html('User does not exists.');
						return false;
					}
					//alert(mid);
					//$('.warn').html('');
					//alert(gid);
					$.post
					(
						"<?php echo base_url(); ?>group/make_member",
						{group:gid,user:mid},
						function(data)
						{
							//alert(data);
							if(data == 'TRUE')
							{
								location.reload();
							}
							if(data == 'FALSE')
							{
								//alert('false');
								$('.warn').html(uname+' is already a group member.');
							}
							if(data == 'error')
							{
								$('.warn').html(uname+ 'no such member exists');
							}
						}
					);
				}
			);
		}
	);
</script>