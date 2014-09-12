<div id="files" class="">
	<div id="inner-files">
    	<?php if($show_controls == TRUE): ?>
    	<a href="#" id="add">Upload new file</a>
    		<div id="add-new">
        		<form id="file-form" method="post" action="">
        			<input type="hidden" name="post-data" value="added a new file" />
            		<input type="file" name="userfile" id="file" />
            		<input type="submit" value="Upload" id="upload" class="submit" />
            	</form>
            	<img class="wait" src="<?php echo base_url(); ?>images/wait3.gif" />
            	
        </div>
    	<?php endif; ?>
        <p class="warn"></p>
    	<div class="files">
        <?php if(isset($files)): ?>
        	
            <?php if($files != FALSE): ?>
            <ul>
    		<?php foreach($files as $file): ?>
        		<li class="file" id="file<?php echo $file['file_id']; ?>">
                	<a class="stream-files" title="Click to download" href="<?php echo base_url()."download?file=".$file['file_name']; ?>"><?php echo $file['file_name']; ?></a>	
                   <?php if($show_controls == TRUE): ?>
                   	<a class="del-file" id="del<?php echo $file['file_id']; ?>" href="#" title="delete file"><img src="<?php echo base_url(); ?>images/del-norm.png" width="15" height="15"  /></a></a>	
                   <?php endif; ?>
            	</li>
        	<?php endforeach; ?>
            </ul>
            <?php endif; ?>
            
            
            <div id="warn" title="Confirm delete?">
         	
         	</div>
            
        <?php endif; ?>
        
        </div>
    </div>
</div>


<script type="text/javascript">
	$(document).ready
	(
		function()
		{	
			$('#add-new').hide();		
			$('.del-file').hide();
			$('img.wait').hide();
			
			$('#add').click
			(
				function()
				{
					$('#add-new').toggle('slow');
				}
			);
			
			$('#upload').click
			(
				function()
				{
					var p = $.trim($('#file').val());
					
					if(p == '')
					{
						return false;
					}
					
					$('.wait').show();
					
					var options = 
					{	 
        				success: function(responseText)
						{
							$('.warn').html('');
							$('.wait').hide();
							
							var data = $.parseJSON(responseText);
							
							//alert(data.is_error);
							if(data.is_error == true)
							{
								var error = data.error;
								//alert(error);
								$('.warn').html(error);
							}
							else
							{
								var id = data.id;
								var name = '<?php echo $display_name; ?>';
								var fname = data.name;
								
								var newFile = '<li class="file" id="file'+id+'"><a class="stream-files" href="<?php echo base_url(); ?>download?file='+fname+'">'+fname+'</a><a class="del-file" id="del'+id+'" href="#" title="delete file"><img src="<?php echo base_url(); ?>images/del-norm.png" width="15" height="15"  /></a></a></li>';
								
								if($('.files ul li').length === 0)
								{
									$('.files ul').append(newFile);
								}
								else
								{
									$('.files li:first').before(newFile);
								}
								
								$('#del'+id).hide();
								//$('.img-gallery').lightBox();
								$('#file').val('')
							}
						},  // post-submit callback 
 						
						url: "<?php echo base_url(); ?>files/upload_file",
    			 	}; 
					$('#file-form').ajaxSubmit(options);
					
					return false;
				}
			);
			
			$('li.file').livequery
			(
				'hover',
				function()
				{
					var id = parseInt(this.id.replace("file", ""));
					$('#del'+id).toggle();
				}
			);
			
			$('.del-file').livequery
			(
				'click',
				function()
				{
					var id = parseInt(this.id.replace("del", ""));
					
					var warn = "Are you sure you want to delete this file?";
					$('#warn').html(warn).dialog({modal: true,
					width : '370px',height : 'auto', resizable:false, closeOnEscape:true,
					focus:true,buttons:
					{
						"Yes":function()
						{
							$.post
							(
								"<?php echo base_url(); ?>files/del_file",
								{file:id},
								function(data)
								{
									//alert(data);
									if(data == '1')
									{
										$('#file'+id).remove();
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
			
			//$('#gallery').galleryView();
			//$('.img-gallery').lightBox();
		}
	);
</script>