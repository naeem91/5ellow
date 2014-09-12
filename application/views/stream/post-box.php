<div id="post-box">
	<div id="inner-post-box">
    	<div class="profile-pic"><a href="<?php echo base_url().$signed_user_name;; ?>" ><img src="<?php echo base_url();?>uploads/thumbs/<?php echo $profile_pic; ?>" width="65" height="65" /></a></div>
        <div class="post-thing">
	   	<span class="post-here">Share your Knowledge...</span>
    	<form id="post-form" type="multipart/form-data" method="post" action="<?php echo base_url(); ?>test">
        	<textarea name="post-data" class="post-box" cols="70" rows="2"></textarea>
            <input type="submit" id="post-submit" class="submit" value="Post" />
            <input type="hidden" id="photo" value="<?php echo $profile_pic; ?>" />
            <input type="hidden" id="name" value="<?php echo $signed_user_name; ?>" />
            <input type="hidden" id="display" value="<?php echo $display_name; ?>" />
            <?php if($content == "group-stream"): ?>
            	  <input type="hidden" name="group-id" value="<?php echo $group_info['group_id']; ?>" />
            <?php endif; ?>
            
			<?php if($uploading_enable == TRUE): ?>
            <div class="upload-box">
              
              <a href="#" id="show_file_attach">Photo/File</a>
              <a href="#" id="show_video_attach">Video</a>
              <a href="#" id="show_link_attach">Link</a>
              
              <div class="file_attach">
                  <label>Upload (jpg,png,gif,docx,pdf)</label>
                  <input name="userfile" type="file" id="file_attach"  />
              </div>
              <div class="video_attach">
                  <label>Paste Video link (e.g, http://vimeo.com/51325336)</label>
                  <input name="video_link" type="text" id="video_attach"  />
              </div>
              <div class="link_attach">
              	<label>Paste link</label>
                  <input name="link_link" type="text" id="link_attach"  />
              </div>
            </div>
           <?php endif; ?>

            <p class="wait"><img src="<?php echo base_url(); ?>images/wait3.gif" width="28" /></p>
            <p class="warn"></p>
        </form>
        </div>
    </div>
</div>


<script type="text/javascript">
	$('document').ready
	(
		function()
		{
			var postBox = $('.post-box');
			var maxChars = 200;
			$('.post-box').keyup
			(
				function()
				{
					var chars = postBox.val();
					$('#warn').text(chars.length);
					
					if(chars.length > maxChars)
					{
						postBox.val(chars.substr(0,maxChars));
						$('.warn').text('You reached max limit of '+maxChars+' characters');
					}
					else
					{
						$('.warn').text('');
					}
				}
			);
			
		}
	);
</script>