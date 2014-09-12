<div id="videos" class="">
	<div id="inner-videos">
    	<?php if($show_controls == TRUE): ?>
    	<a href="#" id="add">Upload new Video</a>
    	<div id="add-new">
        	<form id="video-form" method="post" action="">
        		<input type="hidden" name="post-data" value="added a new video" />
            	<input type="text" name="video_link" id="file" />
            	<input type="submit" value="Upload" id="upload" class="submit" />
            </form>
            <img class="wait" src="<?php echo base_url(); ?>images/wait3.gif" />
            <p class="warn"></p>
        </div>
        <?php endif; ?>
    	<div class="videos">
        <?php if(isset($videos)): ?>
        	<ul>
            <?php if($videos != FALSE): ?>
    		<?php foreach($videos as $video): ?>
        		<li class="vid" id="vid<?php echo $video['video_id']; ?>">	
        			<a  class="stream-vids" href="<?php echo $video['video_link']; ?>">Video</a>
                    <?php if($show_controls == TRUE): ?>
                    	<a class="del-video" id="del<?php echo $video['video_id']; ?>" title="delete video" href="#"><img src="<?php echo base_url(); ?>images/del-hov.png" width="15" height="15"  /></a>	
                    <?php endif; ?>
            	</li>
               
        	<?php endforeach; ?>
            <?php endif; ?>
             <br class="clear" />
            </ul>
        <?php endif; ?>
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
			$('.del-video').hide();
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
								
								var newVideo = '<li class="vid" id="vid'+id+'"><a  class="stream-vids" href="'+p+'">Video</a><a class="del-video" id="del'+id+'" href="#">delete</a></li>';
								
								if($('.videos ul li').length === 0)
								{
									$('.videos ul').append(newFile);
								}
								else
								{
									$('.videos li:first').before(newVideo);
								}
								
								$("a.stream-vids").jqvideobox({'width' : 400, 'height': 300, 'getimage': true, 'navigation': false});

								$('#del'+id).hide();
								//$('.img-gallery').lightBox();
								$('#file').val('')
							}
						},  // post-submit callback 
 						
						url: "<?php echo base_url(); ?>videos/upload_video",
    			 	}; 
					$('#video-form').ajaxSubmit(options);
					
					return false;
				}
			);
			
			$('li.vid').livequery
			(
				'hover',
				function()
				{
					var id = parseInt(this.id.replace("vid", ""));
					$('#del'+id).toggle();
				}
			);
			
			$('.del-video').livequery
			(
				'click',
				function()
				{
					var id = parseInt(this.id.replace("del", ""));
					
					var warn = "Are you sure you want to delete this video?";
					$('#warn').html(warn).dialog({modal: true,
					width : '370px',height : 'auto', resizable:false, closeOnEscape:true,
					focus:true,buttons:
					{
						"Yes":function()
						{
							$.post
							(
								"<?php echo base_url(); ?>videos/del_video",
								{video:id},
								function(data)
								{
									//alert(data);
									if(data == '1')
									{
										$('#vid'+id).remove();
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