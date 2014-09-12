<div id="groups">	
	<div id="inner-groups">
    	<a href="#" id="create-group">Create new Group</a>
    	
    	<div class="groups">
        	<?php if($groups != FALSE):  ?>
            	<h1>My Groups</h1>
            	<ul>
                
            	<?php foreach($groups as $group): ?>
                	<li><a href="<?php echo base_url().'groups/'.$group['group_name']; ?>"><?php echo $group['group_display_name']; ?></a></li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
	</div>
    
    <div id="group-form" title="Create New Group">
    	<form id="new-group-form" method="post" action="<?php echo base_url().'group/create_group' ?>">
        	<div>
            	<label for="group name">Group Name</label>
        		<input type="text" name="display" id="display"/>
           </div>
           <div>
           		<label for="url">Group address</label>
                <input type="text" name="name" id="name" />
           </div>
           <div>
           		<label>Group Cover photo</label>
                <input type="file" name="userfile" />
           </div>
           <div>
           		<label>Description</label>
                <textarea cols="40" rows="2" name="desc" id="desc"></textarea>
           </div>
           <p class="warn"></p>
        </form>
    </div>
</div>


<script type="text/javascript">
	$(document).ready
	(
		function()
		{
			
		  $('#new-group-form').validate
		  (
		  	  
			  {
				  rules: 
				{
					display:
					{
						required:true,
						minlength:3,
						maxlength:50
					},
					name:
					{
						required:true,
						minlength:3,
						maxlength:20,
						remote:
						{
							url:"<?php echo base_url(); ?>group/group_name",
							type:"post"
						}
					},
					desc:
					{
						
						
						maxlength:200
					}
				},
				messages:
				{
					display:
					{
						required: "Please enter group display name", 
						minlength: jQuery.format("Enter at least {0} characters")
					},
					name:
					{
						required: "Please enter group name", 
						minlength: jQuery.format("Enter at least {0} characters"),
						remote:jQuery.format("{0} is already in use")
					}
				},
				  submitHandler: function(form)
				  {
					 jQuery(form).ajaxSubmit
					 (
					 	{
            				success: function(data) 
							{ 
								//alert(data);
								$('.warn').html('');
								
								var res = $.parseJSON(data);
								if(res.is_error == true)
								{
									var error = res.error;
									
									$('.warn').html(error);
								}
								else
								{
									var name = $('#name').val();
									
									window.location.href = '<?php echo base_url(); ?>groups/'+name;
									$("#group-form").dialog( "close" );
								}
							}
         				}
					);
				  }
			  }
		  );
					
	
			$('#create-group').click
			(
				function()
				{
					
					$('#group-form').dialog('open');
				}
			);
			
			$('#group-form').dialog
			(
				{
					autoOpen:false,
					modal: true,
					width : '500px',height : 'auto', resizable:false, closeOnEscape:true,
					focus:true,
					buttons:
					{
						"Create":function()
						{
							$("#new-group-form").submit();
						},
						"Cancel":function()
						{
							
							$('form :input').val("");
							$('label.error').html('');
							$('.warn').html('');
							$( this ).dialog( "close" );
						}
					}
				}
			);
		}
	);
</script>