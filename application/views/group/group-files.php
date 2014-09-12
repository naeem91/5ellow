<div id="group-files" class="">
	<div id="inner-group-files">
    	  <?php $this->load->view('templates/group-nav'); ?>
    	 <?php if($group_info['files'] != FALSE): ?>
        	<ul class="files">
    		<?php foreach($group_info['files'] as $file): ?>
        		<li class="file" id="file<?php echo $file['file_id']; ?>">
                	<a title="Click to download" class="stream-files" href="<?php echo base_url()."download?file=".$file['file_name']; ?>"><?php echo $file['file_name']; ?></a>	   
                     <?php if($is_group_admin == TRUE || $is_admin == TRUE): ?>
                   		<a class="del-file" title="Delete file" id="del<?php echo $file['file_id']; ?>" href="#"><img src="<?php echo base_url();?>images/del-norm.png"  /></a>	
                   <?php endif; ?>
               </li>
        	<?php endforeach; ?>
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
			$('.del-file').hide();
			
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