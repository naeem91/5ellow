<div id="group-stream" class="stream">
	<div id="inner-group-stream">
    	<?php $this->load->view('templates/group-nav'); ?>
        
        <?php if($is_group_member == FALSE): ?>
        	<input type="button" class="submit" id="<?php echo $group_info['group_id']; ?>" value="Join Group" title="Join this group" />
        <?php endif; ?>
		<?php if($is_group_member == TRUE): ?>
    		<?php $this->load->view('stream/post-box'); ?>
        <?php endif; ?>
        
        <div class="posts">
        	<?php if($stream != FALSE): ?>
            	<?php $count = 0; ?>
            	<?php foreach($stream["posts"] as $post): ?>
                <?php $count++; ?>
                <div class="apost" id="wp<?php echo $post['post_id']; ?>">
                <ul id="f<?php echo $post['post_id']; ?>" class="<?php echo $post['user_name']; ?>">
					<?php $post_id = $post['post_id']; ?>
                    
                    <li class="delete" id="d<?php echo $post_id; ?>"><a href="#" id="<?php echo $post_id; ?>" title="delete post"><img src="<?php echo base_url(); ?>images/del-norm.png" width="15" height="15"  /></a></li>
                    <li class="photo"><a href="<?php echo base_url().$post['user_name']; ?>"><img src="<?php echo base_url().'uploads/thumbs/'.$post['photo']; ?>" width="65" height="65" /></a></li>
                        
					<li class="name">
                    	<a href="<?php echo base_url().$post['user_name']; ?>"><?php echo $post['display_name']; ?></a>
                    </li>
                    
                     <li class="post"><?php echo $post['post']; ?></li>
                     
                     <?php if($post['attach_link'] != '0'): ?>
                     	<li class="attachment">
                        <?php  
							switch($post['attach_type'])
							{
								case 'file':
									echo '<a title="download file" href="'.base_url().'download?file='.$post['attach_link'].'">'.$post['attach_link'].'</a>';
									break;
								case 'video':
									echo '<a class="stream-vids" href="'.$post['attach_link'].'">Video</a>';
									break;
								case 'photo':
									echo '<a class="stream-photos" id="photo'.$post_id.'" href="'.base_url().'uploads/large_photos/'.$post['attach_link'].'" ><img src="'.base_url().'uploads/stream_photos/'.$post['attach_link'].'"   /></a>';
									break;
								case 'link':
									echo '<div class="link-data" id="link'.$post_id.'"><a target="_new" id="'.$post_id.'" class="stream-links" href="'.$post['attach_link'].'">'.$post['attach_link'].'</a></div>';
									break;
								case 'deleted':
									echo '<span class="deleted-attach">This attachment is either deleted or not availabe</span>';
									break;
								default:
									break;	
							}
						?>
                     <?php endif; ?>
                      </li>
                      
                	 <div class="time-com">
                     	<?php if($post['can_like'] == TRUE): ?>
                    		<li class="like" id="like<?php echo $post_id; ?>"><a href="#" title="Like this post" class="like-post" id="<?php echo $post_id; ?>">Like</a></li> 
                        <?php endif; ?>  
                    	<li class="comment"><a href="" id="<?php echo $post_id; ?>">Comment</a></li>
                        <?php if($post['comment_count'] > 5): ?>
                        
                       <li class="view-comments" id="<?php echo $post_id; ?>"><a href="#" id="<?php echo $post_id; ?>"><?php echo $post['comment_count']; ?> comments</a></li> 
                       
                       <?php endif; ?>
                       <a href="#" class="who-likes" id="<?php echo $post_id; ?>"><li class="likes" id="likes<?php echo $post_id; ?>"><?php echo $post['like_count']; ?></li></a>
                    	<li class="time"><?php echo $post['post_time']; ?></li>
                        
                        <br class="clear" />
                    </div>  
                    
                    
                    <input type="hidden" id="post-id" value="<?php echo $post['post_id']; ?>" />
                   
					 <li class="comments" id="apnd<?php echo $post_id; ?>">
                     	<?php if(!empty($stream["comments"])): ?>
                		<?php foreach($stream["comments"] as $comment): ?>
                        	<?php $comment_id = $comment['comment_id']; ?>
                        	<?php if($comment['post_id'] == $post_id): ?>
                          
                            	<ul id="cc<?php echo $comment_id; ?>" class="<?php echo $comment['user_name']; ?>">
                                	<li class="delete-comment"  id="dc<?php echo $comment_id; ?>"><a href="#" id="<?php echo $comment_id; ?>" title="delete comment" /><img src="<?php echo base_url(); ?>images/del-norm.png" width="15" height="15"  /></a></li>
                                    
                                	<li class="comment-photo"><a href="<?php echo base_url().$comment['user_name']; ?>"><img src="<?php echo base_url().'uploads/thumbs/'.$comment['photo'];  ?>" width="50" height="50" /></a></li>
                                    
                                    <li class="comment-name"><a href="<?php echo base_url().$comment['user_name']; ?>"><?php echo $comment['display_name']; ?></a></li>
                            <li class="comment-post"> <?php echo $comment['comment']; ?></li>
                                    <li class="comment-time"> <?php echo $comment['comment_time']; ?></li>
                                    <input type="hidden" id="comment-id" value="<?php echo $comment['comment_id']; ?>" />
                                </ul>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endif; ?>
                       
                	</li> 
					
                	<li class="comment-box" id="c<?php echo $post_id; ?>">
                    	<a href="<?php echo base_url().$signed_user_name; ?>"><img src="<?php echo base_url().'uploads/thumbs/'.$signed_user_photo;  ?>" width="50" height="50" /></a>
                		<textarea class="comment-text" id="t<?php echo $post_id; ?>"  cols="40" rows="2"></textarea>
                        <br class="clear" />
                	</li> 
                </ul>
                </div>    
            	<?php endforeach; ?>        
       		<?php endif; ?>
        </div>
        <?php if($stream != FALSE): ?>
        	<?php if($count > 20): ?>
        		<a href="#" id="load-more">load more posts</a>
           <?php endif; ?>
        <?php endif; ?>
        <div id="posts-loader">
        	<p></p>
        </div>
    </div>
</div>


<script type="text/javascript">
	$(document).ready
	(
		function()
		{
			$('input[type="button"]').click
			(
				function()
				{
					var uid = '<?php echo $signed_user_id; ?>';
					var gid = this.id;
					
					//alert(user+group);
					$.post
					(
						"<?php echo base_url(); ?>group/make_member",
						{group:gid,user:uid},
						function(data)
						{
							//$('#check').append('inside post'+latestComment);
							location.reload();
							
						}
						
					);
					
					return false;
				}
			);
		}
	);
</script>