<div id="admin-user" class="admin-panel">
	<div id="inner-admin-user">
    	
        <table border="1">
        	<tr>
            	<th>Display name</th>
                <th>User name</th>
                <th>Email</th>
                <th>Status</th>
                
            </tr>
        <?php if($users != FALSE): ?>
        	<?php foreach($users as $u): ?>
       			<tr id="ur<?php echo $u['user_id']; ?>">
                	<td class="display"><a href="<?php echo base_url().$u['user_name']; ?>"><?php echo $u['display_name']; ?></a></td>
                    <td><?php echo $u['user_name']; ?></td>
                    <td><?php echo $u['user_email']; ?></td>
                    <td id="st<?php echo $u['user_id']; ?>">
                    <?php if($u['banned'] == 1): ?>
                    	Blocked
                    <?php else: ?>
                    	<?php if($u['active'] == 1): ?>
                        	Active
                        	<?php else: ?>
                            Unverified
                        <?php endif;?>
                    <?php endif; ?>
                    </td>
                   
                    <td>
                    <?php if($u['active'] == 1): ?>
                    	<?php if($u['banned'] == 1): ?>
                    		<a href="#" class="unban" id="unban<?php echo $u['user_id']; ?>" >Activate</a>
                    	<?php else: ?>
                    		<a href="#" class="ban" id="ban<?php echo $u['user_id']; ?>" >Block</a>
                    	<?php endif; ?>
                    <?php endif; ?>
                    </td>
                    <td>
                    	<a href="#" class="del" id="<?php echo $u['user_id']; ?>" >Delete</a>
                    </td>
                </tr>        
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        
         <div id="warn" title="Confirm action?">
         	
         </div>
        
    </div>
</div>




<script type="text/javascript">
	$(document).ready
	(
		function()
		{
			
			$('.ban').livequery
			(
				'click',
				function()
				{
					var id = parseInt(this.id.replace("ban", ""));
					
					var warn = "Are you sure you want to Block this user?";
					$('#warn').html(warn).dialog({modal: true,
					width : '370px',height : 'auto', resizable:false, closeOnEscape:true,
					focus:true,buttons:
					{
						"Yes":function()
						{
							
							$.post
							(
								"<?php echo base_url(); ?>user/ban_user",
								{id:id},
								function(data)
								{
									//alert(data);
									if(data != '0')
									{
										$('#st'+id).text('Blocked');
										
										$('#ban'+id).text('Activate');
										
										$('#ban'+id).attr('class','unban');
										
										$('#ban'+id).attr('id','unban'+id);
										//$('#st'+id).text('Banned');
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
			
			$('.del').livequery
			(
				'click',
				function()
				{
					var id = this.id;
					var warn = "Are you sure you want to delete this user?";
					$('#warn').html(warn).dialog({modal: true,
					width : '370px',height : 'auto', resizable:false, closeOnEscape:true,
					focus:true,buttons:
					{
						"Yes":function()
						{
							//alert(id);
							$.post
							(
								"<?php echo base_url(); ?>user/del_user",
								{id:id},
								function(data)
								{
									//alert(data);
									if(data != '0')
									{
										$('#ur'+id).remove();
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
			$('.unban').livequery
			(
				'click',
				function()
				{
					var id = parseInt(this.id.replace("unban", ""));
					
					var warn = "Are you sure you want to acivate this user?";
					$('#warn').html(warn).dialog({modal: true,
					width : '370px',height : 'auto', resizable:false, closeOnEscape:true,
					focus:true,buttons:
					{
						"Yes":function()
						{
							
							$.post
							(
								"<?php echo base_url(); ?>user/unban_user",
								{id:id},
								function(data)
								{
									//alert(data);
									if(data != '0')
									{
										$('#st'+id).text('Active');
										
										$('#unban'+id).text('Block');
										
										$('#unban'+id).attr('class','ban');
										
										$('#unban'+id).attr('id','ban'+id);
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
			
		}
	);
</script>