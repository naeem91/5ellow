<div id="manage-admin">
	<div id="inner-manage-admin">
   		<div class="al">
        <div id="add-admin">
        	<label>Add admin</label>
        	<input type="text" id="new-admin" />
            <input type="submit" id="submit" class="submit" value="Add" />
            
            <p class="warn"></p>
        </div>
        <div class="admin-list">
        	<?php if($admins != FALSE): ?>
            <table border="1">
            <tr>
            	<th>Name</th>
                <th>User name</th>
                <th>Email</th>
            </tr>
        	<?php foreach($admins as $u): ?>
       			<tr id="ur<?php echo $u['admin_id']; ?>">
                	<td class="display"><a href="<?php echo base_url().$u['user_name']; ?>"><?php echo $u['display_name']; ?></a></td>
                    <td><?php echo $u['user_name']; ?></td>
                    <td><?php echo $u['user_email']; ?></td>
                    <td><a href="#" class="del" id="<?php echo $u['admin_id']; ?>" >Remove</a></td>
                </tr>        
            <?php endforeach; ?>
            </table>
        <?php endif; ?>
        </div>
        </div>
        <div id="warn" title="Confirm action?">
         	
         </div>
         
    </div>
</div>



<script type="text/javascript">
	$(document).ready
	(
		function()
		{
			var to = '';
			$('#new-admin').autocomplete
			(	
				{
					source:"<?php echo base_url(); ?>members/get_members",
					select: function( event, ui ) 
					{
						to = ui.item.id;
						//alert( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
					} 	
				}
			);
			
			$('#submit').click
			(
				function()
				{
					$('.warn').html('');
					var nadmin = $('#new-admin').val();
					if(nadmin == '')
					{
						$('#new-admin').focus();
						
						return false;
					}
					if(to == '')
					{
						$('.warn').html('user does not exists');
						
						return false;
					}
					
					$.post
					(
						"<?php echo base_url(); ?>manage/add_admin",
						{id:to},
						function(data)
						{
						  //alert(data);
						  if(data == '0')
						  {
							 $('.warn').html('user is already an admin');
						  }
						  else
						  {
							  location.reload();
						  }
						}	
					);
				}
			);
			
			$('.del').livequery
			(
				'click',
				function()
				{
					var id = this.id;
					var warn = "Are you sure you want to remove this user from admins?";
					$('#warn').html(warn).dialog({modal: true,
					width : '370px',height : 'auto', resizable:false, closeOnEscape:true,
					focus:true,buttons:
					{
						"Yes":function()
						{
							
							
							$.post
							(
								"<?php echo base_url(); ?>manage/del_admin",
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
		}
	);
</script>