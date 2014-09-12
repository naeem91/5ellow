$(document).ready
	(
		function()
		{
			$('.comment-box').hide();
			$('.posts ul li.delete').hide();
			$('.posts ul li.delete-comment').hide();
			$('#post-box p.wait').hide();
			$('ul.alerts').hide();
			
			$('.notif a').livequery
			(
				'click',
				function()
				{
					$('ul.alerts').toggle('slow');
					
					$('.notify').html('');
					
					$.post
					(
						"http://localhost/WebDev/StudentTribe/notify/mark_read"
					);
					
					return false;
				}
			);
			//$('.posts ul').hover(over,out);
			$('li.view-comments').each
			(	
				function()
				{
					var id = this.id;
					$('#apnd'+id).hide();
				}
			);
			$('.view-comments a').livequery
			(
				'click',
				function()
				{
					var id = this.id;
					//alert(this.text);
					$('#apnd'+id).toggle('slow');
					
					return false;
				}				
			);
			
			var page = 0;
			
			$(window).scroll
			(
				function()
				{
        			if  ($(window).scrollTop() == $(document).height() - $(window).height())
					{
						++page;
						$.post
						(
							"http://localhost/WebDev/StudentTribe/stream/load_stream",
							{data:page},
							function(data)
							{					
								if(data != 'false')
								{
									
									$('#posts-loader').html('<img src="http://localhost/WebDev/StudentTribe/images/lightbox-ico-loading.gif" />');						
									var newPosts = $.parseJSON(data);
								var posts = newPosts.posts;
								if(newPosts.comments)
								{
									var comments = newPosts.comments;
								}
							
								for(var i=0; i<posts.length; i++)
								{
									var post = posts[i];
								
									var aPost = '<ul id="f'+post.post_id+'" class="'+post.user_name+'"><li class="delete" id="d'+post.post_id+'"><a href="#" id="'+post.post_id+'" title="delete post">delete</a></li><li class="photo"><a href=""><img src="http://localhost/WebDev/StudentTribe/uploads/thumbs/'+post.photo+'" width="50" height="50" /></a></li><li class="name"><a href="http://localhost/WebDev/StudentTribe/'+post.user_name+'">'+post.display_name+'</a></li><li class="post">'+post.post+'</li><li class="time">'+post.post_time+'</li><input type="hidden" id="post-id" value="'+post.post_id+'" /><li class="comments" id="apnd'+post.post_id+'">';	
									var newC = '';
									if(comments)
									{
										for(var j=0; j<comments.length; j++)
										{
											var comment = comments[j];
																		
											if(comment.post_id == post.post_id)
											{
												var aComment = '<ul id="cc'+comment.comment_id+'" class="'+comment.user_name+'"><li class="delete-comment"  id="dc'+comment.comment_id+'"><a href="#" id="'+comment.comment_id+'" title="delete comment">delete</a></li><li class="comment-photo"><a href="http://localhost/WebDev/StudentTribe/'+comment.user_name+'"><img src="http://localhost/WebDev/StudentTribe/uploads/thumbs/'+comment.photo+'" width="50" height="50" /></a></li><li class="comment-name"><a href="http://localhost/WebDev/StudentTribe/'+comment.user_name+'">'+comment.display_name+'</a></li><li class="comment-post">'+comment.comment+'</li><li class="comment-time">'+comment.comment_time+'</li><input type="hidden" id="comment-id" value="'+comment.comment_id+'" /></ul>';
										 		newC = newC + aComment;
											}
										}
									}
								var parts = '</li><li class="comment"><a href="" id="'+post.post_id+'">Comment</a></li><li class="comment-box" id="c'+post.post_id+'"><textarea class="comment-text" id="t'+post.post_id+'"  cols="40" rows="2"></textarea></li></ul>'; 								
								if(newC != '')
								{
									var newPart = aPost+newC+parts;
								}
								else
								{
									var newPart = aPost+parts;
								}
								
								
								$('.posts').append(newPart);
									
								//$('.posts').append(parts);
							}
							$('#posts-loader').html('');						

							$('.comment-box').hide();
							$('.posts ul li.delete').hide();
							$('.posts ul li.delete-comment').hide();		
						}
					}
				);	
					}
				}
			);
			
			
			$('.comments ul').livequery
			(
				'mouseover',
				function()
				{
					//alert(this.id);
					var thisUser = '<?php echo $signed_user_name; ?>';
					var id = parseInt(this.id.replace("cc", ""));
					
					var user = $('#cc'+id).attr('class');
				
					if(thisUser === user)
					{
						
						
						$('#dc'+id).show();
					}
					
				}
			);
			$('.comments ul').livequery
			(
				'mouseout',
				function()
				{
					var id = parseInt(this.id.replace("cc", ""));
					
					 if ($("#dc"+ id).is(':visible')) 
					 {
                    	$("#dc"+id).hide();
					 }
				}
			);
			
			$('.delete-comment a').livequery
			(
				'click',
				function()
				{
					var id = this.id;
					$.post
					(
						"http://localhost/WebDev/StudentTribe/post/del_comment",
						{data:id},
						function(data)
						{
							if(data != false)
							{
								$('#cc'+id).remove();
							}
						}
					);
					
					return false;
				}
			);
			
			$('.delete a').livequery
			(
				'click',
				function()
				{
					var id = this.id;
					$.post
					(
						"http://localhost/WebDev/StudentTribe/post/del_post",
						{data:id},
						function(data)
						{
							//$('#check').append('inside post'+latestComment);
							if(data != 'false')
							{
								$('#f'+id).remove();
							}
						}
					);
					
					return false;
				}
			);
			
			$('.posts ul').livequery
			(
				'mouseover',
				function(e)
				{
					var thisUser = '<?php echo $signed_user_name; ?>';
					
					var id = parseInt(this.id.replace("f", ""));
					
					var user = $('#f'+id).attr('class');
					if(thisUser === user)
					{
						$('#d'+id).show();
						//$('#check').text('can delete');
					}
					
				}
			);
			$('.posts ul').livequery
			(
				'mouseout',
				function(e)
				{
					var id = parseInt(this.id.replace("f", ""));
					
					 if ($("#d"+ id).is(':visible')) 
					 {
                    	$("#d"+id).hide();
					 }
					//$('#check').text('out');
				}
			);
			var latestComment = 0;
			
			$('input#comment-id').each
			(
				function(m)
				{
					if(this.value > latestComment)
						latestComment = this.value;
					//alert(m);
				}
			);
			
			$(".posts").everyTime
			(
				2000,
				function(i)
				{
					//$('#check').append('ons start'+latestComment);
					$.post
					(
						"http://localhost/WebDev/StudentTribe/stream/check_comment",
						{data:latestComment},
						function(data)
						{
							//$('#check').append('inside post'+latestComment);
							if(data != 'false')
							{
							
								//$('#check').append('before change'+latestComment);
								var newComment = $.parseJSON(data);	
								var commentId = newComment.comment_id;
								latestComment = commentId;
								//++latestComment;
								//$('#check').append('after change'+latestComment);
							
								
								var commentTime = newComment.comment_time;
								var commentText = newComment.comment;
								var postId = newComment.post_id;
								
								var userPhoto = newComment.photo;
								var userName = newComment.user_name;
								var displayName = newComment.display_name;
								
								var postUser = newComment.post_user;
								var commenter = newComment.commenter;
								var post = newComment.post;
								var postUserName = newComment.post_username;
								var orignalTime = newComment.orignal_time;
								//++latestComment;
								
								
								var comment = '<ul id="cc'+commentId+'" class="'+userName+'"><li class="delete-comment"  id="dc'+commentId+'"><a href="#" id="'+commentId+'" title="delete comment" >delete</a></li><li class="comment-photo"><a href="http://localhost/WebDev/StudentTribe/'+userName+'"><img src="http://localhost/WebDev/StudentTribe/uploads/thumbs/'+userPhoto+'" width="50" height="50" /></a></li><li                class="comment-name"><a href="http://localhost/WebDev/StudentTribe/'+userName+'">'+displayName+'</a></li><li class="comment-post">'+commentText+'</li><li class="comment-time">'+commentTime+'</ul>';
					//alert(comment);
								$('#apnd'+postId).append(comment);
								var commentBox = $("#t" + postId);
								commentBox.val('');
								$('#dc'+commentId).hide();
								//notify user
								var signed = '<?php echo $signed_user_name; ?>';
								
								//
								if(signed != userName && signed == postUserName)
								{
									var postPart = post.substr(0,50);
									
									$.post
									(
										"http://localhost/WebDev/StudentTribe/notify/notify_comment",
										{sender:commenter,post:postPart,time:orignalTime,receiver:postUser},
										function(data)
										{
											if(data === '1')
											{
												//alert(displayName +'commented on your post'+ postPart +' '+commentTime);
												
												$('.notify').html('new!');
												var msg = '<li>'+displayName+' commented on your post "'+postPart+'" '+commentTime+'</li>';
												
												$('ul.alerts li.msg').html('');
												
												$('ul.alerts li.msg').after(msg);
											}
										}
									);
								}
							}
						}
					);
				}
			);	
			
			var latestId = $('.posts ul:first').attr('id');
			latestId = parseInt(latestId.replace("f", ""));			
			
			$(".posts").everyTime
			(
				5000,
				function(i)
				{
					//var id = $('.posts ul:first').attr('id');
					//alert(latestId);
					//++latestId;
					$.post
					(
						"http://localhost/WebDev/StudentTribe/stream/check_update",
						{data:latestId},
						function(data)
						{
							
							if(data != 'false')
							{
								var newPost = $.parseJSON(data);	
								
								var postId = newPost.post_id;
								var postTime = newPost.post_time;
								var postText = newPost.post;
								
								var userPhoto = newPost.photo;
								var userName = newPost.user_name;
								var displayName = newPost.display_name;
								
								latestId = postId;
								var post = '<ul id="f'+postId+'" class="'+userName+'"><li class="delete" id="d'+postId+'"><a href="#" id="'+postId+'" title="delete post" >delete</a></li><li class="photo"><a href="http://localhost/WebDev/StudentTribe/'+userName+'"><img src="http://localhost/WebDev/StudentTribe/uploads/thumbs/'+userPhoto+'" width="50" height="50" /></a></li><li class="name"><a href="http://localhost/WebDev/StudentTribe/'+userName+'">'+displayName+'</a></li><li class="post">'+postText+'</li><li class="time">'+postTime+'</li><input type="hidden" id="post-id" value="'+postId+'" /><li class="comments" id="apnd'+postId+'"></li><li class="comment"><a href="" id="'+postId+'">Comment</a></li><li class="comment-box" id="c'+postId+'"><textarea class="comment-text" id="t'+postId+'" cols="40" rows="2"></textarea></li> </ul>';
								
								$('.posts ul:first').before(post);
								$('.post-box').val('');
								$('#post-box p.wait').hide('slow'); 
								$('.post-box').focus(); 
								
								$('#c'+postId).hide();
								$('#d'+postId).hide();
							}
						}
					);
				}
			);
			$('#post-submit').click
			(
				function()
				{
					
					var postBox = $('.post-box');
					var postData = postBox.val();
					
					if(postData == '')
					{
						return false;
					}
					
					$('#post-box p.wait').show();
					
					$.post
					(
						"http://localhost/WebDev/StudentTribe/post/do_post",
						{data:postData},
						function(data)
						{														
							if(data != '0')
							{
								
							}
						}
					);
						
					return false;
				}
			);
			$('li.comment a').livequery
			(
				'click',
				function()
				{
					var id = $(this).attr('id');
					
					//alert('#c'+id);
					//var id = parseInt(this.id);
					 if ($("#c"+ id).is(':visible')) 
					 {
                    	$("#c"+id).hide('slow');
					 }
					 else
					{
						$("#c" + id).show('fast');
					}
					return false;
				}
			);
			$('.comment-text').livequery
			(
				'keyup',
				function(event)
				{
					 var id = parseInt(this.id.replace("t", ""));
					 
  					var commentBox = $("#t" + id);				
					
					if(event.keyCode === 13)
					{	
						if(commentBox.val() != '')
						{
							doComment(commentBox.val(),id);
							commentBox.val('');
							
						}
						
					}
					
					var chars = commentBox.val();
				
					if(chars.length > 50)
					{
						
						commentBox.val(chars.substr(0,50));
					}
				}
			);
		}
	);
	function doComment(comment,where)
	{
	
		$.post
		(
			"http://localhost/WebDev/StudentTribe/post/do_comment",
			{data:comment,id:where},
			function(data)
			{	
				
				if(data != '0')
				{
												
				}
			}
		);
		
	}
