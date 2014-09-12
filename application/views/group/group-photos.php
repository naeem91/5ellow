<div id="group-photos">
	<div id="inner-group-photos">
    
    	<?php $this->load->view('templates/group-nav'); ?>

    	<?php if($group_info['photos'] != FALSE): ?>
        	<ul id="gallery">
    		<?php foreach($group_info['photos'] as $photo): ?>
        		<li class="img" id="img<?php echo $photo['photo_id']; ?>">
                	<a title="<?php echo $group_info['group_display_name']; ?>'s photos" class="img-gallery" href="<?php echo base_url()."uploads/large_photos/".$photo['photo_name'] ?>"><img src="<?php echo base_url()."uploads/gallery_thumbs/".$photo['photo_name'] ?>" width="175" height="200"   /></a>
                    <?php if($is_group_admin == TRUE || $is_admin == TRUE): ?>
                   		<a class="del-photo" title="Delete photo" id="del<?php echo $photo['photo_id']; ?>" href="<?php echo $photo['photo_name']; ?>"><img src="<?php echo base_url();?>images/del-hov.png"  /></a>	
                    <?php endif; ?>
            	</li>
        	<?php endforeach; ?>
            <br class="clear" />
        <?php endif; ?>
        	</ul>
            
            <div id="warn" title="Confirm delete?">
         	
         	</div>
         
    </div>
</div>


<script type="text/javascript">
	$(document).ready
	(
		function()
		{	
			$('.del-photo').hide();
			
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