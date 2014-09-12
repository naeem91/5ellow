<div id="personal-settings">
	<div id="inner-personal-settings">
    	
        <?php echo $this->session->flashdata('status'); ?>
        
    	<form id="personal-settings" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        	<fieldset>
            	<legend></legend>
                <div>
            		<label for="user name">User name</label>
                	<input type="text" name="user_name" value="<?php echo $user_name; ?>" id="user_name"  />
                    <?php echo form_error('user_name','<li class="error" id="uerror">', '</li>'); ?>
                </div>
                <div>
                	<label for="display name">Display name</label>
                	<input type="text" name="dis_name" value="<?php echo $display_name; ?>" id="dis_name" />
                    
                </div>
                <div>
                	<label for="photo upload">Profile Picture</label>
					<input type="file" id="userfile" name="userfile" size="20"  />
                    <?php echo form_error('userfile','<li class="error" id="perror">', '</li>'); ?>
                </div>
                <div>
                	<label for="gender">Gender</label>
                	<select  name="gender" value="<?php echo $basic_details['gender']; ?>" >
                    <?php 
						if($basic_details['gender'] == "male")
						{
							$male = TRUE;
						}
						else if($basic_details['gender'] == "female")
						{
							$female = TRUE;
						}
						else
						{
							$select = TRUE;
						}
					?>
                    
                	<option value="male" <?php if($basic_details['gender'] == "male") echo 'selected="selected"'?> >Male</option>
                    <option value="female" <?php if($basic_details['gender'] == "female")echo 'selected="selected"'?>>Female</option>
                    <option value="" <?php if($basic_details['gender'] == "") echo 'selected="selected"'?>></option>
                	</select>
                </div>
                <div>
                	<label for="dob">Date of birth</label>
                	<input  id="datepicker" readonly="readonly" name="dob" value="<?php echo $basic_details['dob']; ?>" />
                </div>   
                <div class="about">
                	<label for="about">About Me</label>
                    <textarea cols="45" rows="3" id="about" name="about"><?php echo $basic_details['about_me']; ?></textarea>
                    <span class="exceed"></span>
                </div>                
            </fieldset>
           
            <input class="submit" type="submit" name="submit" value="Save" />
        </form>
        <div>
        	<?php if($iserror == TRUE): ?>
            	<div id="">
        
            		<ul class="errors">
            		<?php foreach($errors as $err): ?>
                		<li><?php echo $err; ?></li>	
                	<?php endforeach; ?>
                	</ul>
               </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
	$(document).ready(function() 
	{
		
		$('form').validate
		(
			{
				rules: 
				{
					user_name:
					{
						required:true,
						minlength:3,
						maxlength:20
					},
					dis_name: 
					{
						required: true,
						minlength:3,
						maxlength:20
					},
					
					about: 
					{
						minlength:3,
						maxlength:200
					}
				},
				messages:
				{
					user_name:
					{
						required: "Please enter user name", 
						minlength: jQuery.format("Enter at least {0} characters")
					},
					dis_name:
					{
						required: "Please enter displays name", 
						minlength: jQuery.format("Enter at least {0} characters")
					},
					about:
					{
						
						minlength: jQuery.format("Enter at least {0} characters")
					}
				}
			}
		);
		var pickerOpts = 
		{
			changeMonth: true,
			changeYear: true,
			maxDate:"-20y",
			dateFormat:"yy-mm-dd"
		};
		$( "#datepicker" ).datepicker(pickerOpts);
		
		var maxChars = 200;
		var msgBox = $('#about');
		
		$('#about').keyup
			(
				function()
				{
					var chars = msgBox.val();
					
					if(chars.length > maxChars)
					{
						msgBox.val(chars.substr(0,maxChars));
						$('.exceed').text('You reached max limit of '+maxChars+' characters');
					}
					else
					{
						$('.exceed').text('');
					}
				}
			);
		
	});
</script>