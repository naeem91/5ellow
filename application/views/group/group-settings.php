<div id="group-settings">
	<div id="inner-group-settings">
    	<?php $this->load->view('templates/group-nav'); ?>
    	<form action="<?php echo base_url(); ?>group/update_settings" method="post" id="update-group-form" enctype="multipart/form-data">
        	<div>
            	<label>Group name</label>
            	<input name="display" id="display" value="<?php echo $group_info['group_display_name']; ?>"  />
            </div>
            <div>
            	<label>Cover Photo</label>
            	<input name="userfile" type="file" id="cover" />
                <p class="warn"></p>
            </div>
            <div class="desc">
            	<label>Description</label>
                <textarea name="desc" id="desc" rows="3" cols="40"><?php echo $group_info['group_description']; ?></textarea>
            </div>
            <input type="hidden" name="group-id" value="<?php echo $group_info['group_id']; ?>" />
            <input type="submit" id="update-group" class="submit" value="Save" />
             <p class="success"></p>	
        </form>
       
    </div>
</div>



<script type="text/javascript">
	$(document).ready
	(
		function()
		{
			
		  $('#update-group-form').validate
		  (
		  	  
			  {
				  rules: 
				{
					display:
					{
						required:true,
						minlength:3,
						maxlength:20
					},
					desc:
					{
						required:true,
						minlength:3,
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
					desc:
					{
						required: "Please enter group description", 
						minlength: jQuery.format("Enter at least {0} characters")
						
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
								$('.success').html('');
								
								var res = $.parseJSON(data);
								if(res.is_error == true)
								{
									var error = res.error;
									
									$('.warn').html(error);
								}
								else
								{
									//location.reload();
									var display = $('#display').val();
									var desc = $('#desc').val();
									
									$('#display').val(display);
									$('#group-nav ul li.gname').text(display);
									$('#desc').val(desc);
									
									if(res.pname != false)
									{
										var file = res.pname;
										$('#group-nav img').attr('src','<?php echo base_url()."uploads/group_covers/"; ?>'+file);
									}
									
									$('.success').html('<span class="success">Settings saved.</span>');
								}
							}
         				}
					);
				  }
			  }
		  );
					
	
			$('#update-group').click
			(
				function()
				{
					
					$('#update-group-form').submit();
					
					return false;
				}
			);
			
		}
	);
</script>