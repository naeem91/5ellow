<div id="photos" class="">
	<div id="inner-photos">
    	<?php if($show_controls == TRUE): ?>
    	<a href="#" id="add">Upload new photo</a>
    	<div id="add-new">
        	<form id="photo-form" method="post" action="">
        		<input type="hidden" name="post-data" value="added a new photo" />
            	<input type="file" name="userfile" id="file"  />
            	<input type="submit" value="Upload" id="upload" class="submit" />
            </form>
            <img class="wait" src="<?php echo base_url(); ?>images/wait3.gif" />
        </div>
        <p class="warn"></p>

        <?php endif; ?>
    	<div class="photos">
        
        	<ul id="gallery">
            <?php if($photos != FALSE): ?>
    		<?php foreach($photos as $photo): ?>
        		<li class="img" id="img<?php echo $photo['photo_id']; ?>">
                	<a title="<?php echo $display_name; ?>'s photos" class="img-gallery" href="<?php echo base_url()."uploads/large_photos/".$photo['photo_name'] ?>"><img src="<?php echo base_url()."uploads/gallery_thumbs/".$photo['photo_name'] ?>" width="175" height="200"    /></a>
                    <?php if($show_controls == TRUE): ?>
                   		<a class="del-photo" id="del<?php echo $photo['photo_id']; ?>" title="delete photo" href="<?php echo $photo['photo_name']; ?>"><img src="<?php echo base_url(); ?>images/del-hov.png" width="15" height="15"  /></a></a>	
                    <?php endif; ?>
            	</li>
        	<?php endforeach; ?>
            <?php endif; ?>
            <br class="clear" />
        
        	</ul>
            
            <div id="warn" title="Confirm delete?">
         	
         	</div>
         
        <br class="clear" />
        </div>
    </div>
</div>


<script type="text/javascript">
	$(document).ready
	(
		function()
		{	
			$('#add-new').hide();		
			$('.del-photo').hide();
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
					$('.warn').html('');
					if(p == '')
					{
						return false;
					}
					
					$('.wait').show();
					
					var options = 
					{	 
        				success: function(responseText)
						{
							//alert(responseText);
							//alert(p);
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
								var pname = data.name;
								
								var newImg = '<li class="img" id="img'+id+'"><a title="'+name+' photos" class="img-gallery" href="<?php echo base_url(); ?>uploads/photos/'+pname+'"><img src="<?php echo base_url(); ?>uploads/large_photos/'+pname+'" width="175" height="200"/></a><a class="del-photo" id="del'+id+'" href="'+pname+'" title="delete photo"><img src="<?php echo base_url(); ?>images/del-hov.png" width="15" height="15"  /></a></a></li>';
								
								if($('#gallery li').length === 0)
								{
									$('#gallery').append(newImg);
								}
								else
								{
									$('#gallery li:first').before(newImg);
								}
								$('#del'+id).hide();
								$('.img-gallery').lightBox();
								$('#file').val('')
							}
							
						},  // post-submit callback 
 						
						url: "<?php echo base_url(); ?>photos/upload_photo",
    			 	}; 
					$('#photo-form').ajaxSubmit(options);
					
					return false;
				}
			);
			
			$('li.img').livequery
			(
				'hover',
				function()
				{
					var id = parseInt(this.id.replace("img", ""));
					$('#del'+id).toggle();
				}
			);
			
			$('.del-photo').livequery
			(
				'click',
				function()
				{
					var id = parseInt(this.id.replace("del", ""));
					
					var warn = "Are you sure you want to delete this photo?";
					$('#warn').html(warn).dialog({modal: true,
					width : '370px',height : 'auto', resizable:false, closeOnEscape:true,
					focus:true,buttons:
					{
						"Yes":function()
						{
							$.post
							(
								"<?php echo base_url(); ?>photos/del_photo",
								{photo:id},
								function(data)
								{
									//alert(data);
									if(data == '1')
									{
										$('#img'+id).remove();
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
			$('.img-gallery').lightBox();
		}
	);
</script>