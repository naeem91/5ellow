<div id="group-videos">
	<div id="inner-group-videos">
   		<?php $this->load->view('templates/group-nav'); ?>
        <?php if($group_info['videos'] != FALSE): ?>
        	<ul class="videos">
            <?php if($group_info['videos'] != FALSE):  ?>
    		<?php foreach($group_info['videos'] as $video): ?>
        		<li class="vid" id="vid<?php echo $video['video_id']; ?>">	
        			<a  class="stream-vids" href="<?php echo $video['video_link']; ?>">Video</a>
                    <?php if($is_group_admin == TRUE || $is_admin == TRUE): ?>
                    	<a class="del-video" title="delete video" id="del<?php echo $video['video_id']; ?>" href="#"><img src="<?php echo base_url();?>images/del-hov.png"  /></a>	
                    <?php endif; ?>
            	</li>
        	<?php endforeach; ?>
            <br class="clear" />
            <?php endif; ?>
            </ul>
            
            <div id="warn" title="Confirm delete?">
         	
         	</div>
            
        <?php endif; ?>     
    </div>
</div>




<script type="text/javascript">
	$(document).ready
	(
		function()
		{	
		
			$('.del-video').hide();
			$("a.stream-vids").jqvideobox({'width' : 400, 'height': 300, 'getimage': true, 'navigation': false});
			
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
					
					var warn = "Are you sure you want to delete this file?";
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