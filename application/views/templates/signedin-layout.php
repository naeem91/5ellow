<?php $this->load->view('templates/head'); ?>
<div class="signedin-layout" id="main_container">
	<?php $this->load->view('templates/signin-header'); ?>
    <?php $this->load->view('templates/nav'); ?>
    	
   
    <div id="content">
    	<div id="inner-content">
        	<div class="nav-user">
        	
        	<?php
            	switch($page)
				{
					case 'settings':
						$this->load->view('templates/settings-nav');
						break;
					case 'stream':
						switch($content)
						{
							case 'user-stream':
							case 'info':
							case 'fellows':
							case 'photos':
							case 'videos':
							case 'files':
								
								$this->load->view('templates/user-stream-nav');
								break;
							default:
								break;
						}
						break;
					case 'admin':
						$this->load->view('admin/admin-nav');
						break;
					default:
					break;
				}
			?>
            
        </div>
        	<?php
			switch($page)
			{
				case 'admin':
					switch($content)
					{
						case 'admin-stats':
							$this->load->view('admin/admin-stats');
							break;
						case 'admin-service':
							$this->load->view('admin/admin-service');
							break;
						case 'admin-user':
							$this->load->view('admin/admin-user');
							break;
						case 'manage-admin':
							$this->load->view('admin/manage-admin');
							break;
						default:
							break;
					}
					break;
				case 'settings':
        			switch($content)
					{
						case 'personal-settings':
							$this->load->view('settings/personal-settings');
						break;
						case 'password-settings':
							$this->load->view('settings/password-settings');
						break;
						case 'education-settings':
							$this->load->view('settings/education-settings');
						break;
						default:
						break;
					}
					break;
				case 'stream':
        			switch($content)
					{
						case 'public-stream':
							$this->load->view('stream/public-stream');
							break;
						case 'user-stream':
							$this->load->view('stream/user-stream');
							break;
						case 'group-stream':
							$this->load->view('stream/group-stream');
							break;
						case 'notifications':
							$this->load->view('stream/notifications');
							break;
						case 'messages':
							$this->load->view('stream/messages');
							break;
						case 'info':
							$this->load->view('profile/user_info');
							break;
						case 'fellows':
							$this->load->view('profile/fellowers');
							break;
						case 'photos':
							$this->load->view('profile/photos');
							break;
						case 'videos':
							$this->load->view('profile/videos');
							break;
						case 'files':
							$this->load->view('profile/files');
							break;
						case 'groups':
							$this->load->view('group/groups');
							break;
						case 'group-info':
							$this->load->view('group/group-info');
							break;
						case 'group-photos':
							$this->load->view('group/group-photos');
							break;
						case 'group-videos':
							$this->load->view('group/group-videos');
							break;
						case 'group-files':
							$this->load->view('group/group-files');
							break;
						case 'group-settings':
							$this->load->view('group/group-settings');
							break;
						case 'search':
							$this->load->view('search/search-results');
							break;
						default:
						break;
					}
					break;
				default:
				break;
			}
			?>
    	</div>
    </div>
    <div id="sidebar">
    	<div id="inner-sidebar">
    	<div id="sgroups">
    	<h1 class="tgroups">Top Study Groups</h1>
        <?php if($top_groups != FALSE): ?>
        	<ul>
        	<?php foreach($top_groups as $group): ?>
            	<li><a href="<?php echo base_url().'groups/'.$group['group_name']; ?>"><?php echo $group['group_display_name']; ?></a></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        </div>
        
        <div id="tfellows">
        <h1 class="tfellows">Top Fellows</h1>
        <?php if($top_users != FALSE): ?>
        	<div>
        	<?php foreach($top_users as $user): ?>
            	<a href="<?php echo base_url().$user['user_name']; ?>">
            	<ul>	
        			<li><img src="<?php echo base_url();?>uploads/thumbs/<?php echo $user['photo']; ?>" width="50" height="50" /></li>
        			<li><?php echo $user['display_name']; ?></li>
            	</ul>
                </a>
            <?php endforeach; ?>
            <br class="clear" />
            </div>
        <?php endif; ?>
        </div>
        </div>
    </div>
    
    <div id="del-warn" title="Confirm delete?">
         	
    </div>
    
    <div id="like-det" title="Fellows who like this post">
    
    </div>
    
    	<div id="who-online">
			<ul class="chat-users">
            	
    		</ul>
			<a href="#" class="chat-who">Chat <span class="user-num"></span> </a>
        	<br class="clear" />
		</div>
   
    
    <br class="clear" />
</div>
<?php $this->load->view('templates/footer'); ?>


<script type="text/javascript">

	$(document).ready
	(
		function()
		{
			//$('.comment-box').hide();
			$('.posts ul li.delete').hide();
			$('.posts ul li.delete-comment').hide();
			$('#post-box p.wait').hide();
			$('ul.alerts').hide();
			
			
			$('.chat-users').hide();
			
			
			var content = '<?php echo $content; ?>';
			var page = '<?php echo $page; ?>';
			
			switch(page)
			{
				case 'settings':
					$('#header-buttons li.settings').css
					(
						{'background-color':'#F60','color':'#F60'}
					);
					break;
				case 'admin':
					$('#header-buttons li.admin').css
					(
						{'background-color':'#F60','color':'#FFF'}
					);
					break;
				default:
					break;
			}
			switch(content)
			{
				case 'info':
					$('#user-stream-nav .info').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'fellows':
					$('#user-stream-nav .felow').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'photos':
					$('#user-stream-nav .poto').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'videos':
					$('#user-stream-nav .vido').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'files':
					$('#user-stream-nav .fils').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'public-stream':
					$('#nav .home').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'notifications':
					$('#nav .notif').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'messages':
					$('#nav .msgs').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'groups':
					$('#nav .groups').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				
				case 'admin':
					$('#nav .groups').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'user-stream':
					
					var userid = '<?php echo $this_user_id; ?>'; 
					var user = '<?php echo $signed_user_id; ?>';
					if(userid == user)
					{
						$('#nav .info').css
						(
							{'background-color':'#eb7b15','color':'#FFF'}
						);
					}
					break;
				case 'group-stream':
					$('#group-nav ul li.gname').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'group-info':
					$('#group-nav ul li.ginfo').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'group-photos':
					$('#group-nav ul li.gpotos').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;	
				case 'group-videos':
					$('#group-nav ul li.gvids').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'group-files':
					$('#group-nav ul li.gfils').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'group-settings':
					$('#group-nav ul li.gseting').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'admin-stats':
							$('#admin-nav li.stats').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
							break;
						case 'admin-service':
							$('#admin-nav li.srvcs').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
							break;
						case 'admin-user':
							$('#admin-nav li.users').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
							break;
						case 'manage-admin':
							$('#admin-nav li.admins').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
							break;
				case 'personal-settings':
					$('#settings-nav ul li.profile').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);
					break;
				case 'password-settings':
					$('#settings-nav ul li.pass').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);		
					break;
				case 'education-settings':
					$('#settings-nav ul li.edu').css
					(
						{'background-color':'#eb7b15','color':'#FFF'}
					);		
					break;
				default:
					break;
			}
			//$('#content').tinyscrollbar();
			/*$(').click
			(
				function()
				{
					if($('.chat-users').is(':visible')) 
					{
						$('.chat-users').hide();
					}
				}
			);*/
			
			$('.like-post').livequery
			(
				'click',
				function()
				{
					var uid = '<?php echo $signed_user_id; ?>';
					var postid = this.id;
					var clikes = $('#likes'+postid).text();
					//alert(postid+uid);
					$.post
					(
						"<?php echo base_url(); ?>post/like_post",
						{uid:uid,post:postid},
						function(data)
						{
							if(data != '0')
							{
								var nlikes;
								if(clikes == '')
								{
									nlikes = 1;
								}
								else
								{
									nlikes = ++clikes;
								}
								
								$('#likes'+postid).text(nlikes)
								
								$('#like'+postid).hide();
							}
						}
					);
					
				}
			);
			
			$('.who-likes').livequery
			(
				'click',
				function()
				{
					var postid = this.id;
					
					
					
					
					$('#like-det').dialog
					(
						{
							modal: true,
							width : '370px',
							height : 'auto',
							title:'Fellows who like this post', 
							resizable:false, 
							closeOnEscape:true,
							focus:true,
							open: function(event, ui) 
							{
								var users = '';
     							$.post
								(
									"<?php echo base_url(); ?>post/get_likers",
									{post:postid},
									function(data)
									{
										//alert(data);
										var data = $.parseJSON(data);
										
										if(data.length < 1)
										{
											return false;
										}
										
										for(var i=0; i<data.length; i++)
										{
											var user= '<a href="<?php echo base_url(); ?>'+data[i].user_name+'"><li><img src="<?php echo base_url(); ?>uploads/thumbs/'+data[i].photo+'" width="65" height="65" /><li>'+data[i].display_name+'</li></a>';
											
											users += '<ul>'+user+'</ul>';
										}
										
										users = '<div class="who-likes">'+users+'<br class="clear" /></div>';
										$('#like-det').html(users);
									}
								); 
							
     						},
							buttons:
							{
								"OK":function()
								{										
									$( this ).dialog( "close" );
								}
							}
						}
					);
					
				}
			);
			
			
			$('.comment-text').Watermark('Write comment','#CCC');
			
			$('a.chat-who').click
		  	(
			  function()
			  {
				  //alert('clicked');
				  $('.chat-users').toggle();
			  }
		  );
			$(document).everyTime
			(
				4000,
				function(i)
				{
					$.post
					(
						"<?php echo base_url(); ?>user/update_status",
						function(data)
						{
							//alert(data);
						}
					); 
				}
			);
			
			$(document).everyTime
			(
				5000,
				function(i)
				{
					$.post
					(
						"<?php echo base_url(); ?>user/online_users",
						function(data)
						{
							//alert(data);
							if(data != 'false')
							{
								//alert(data);
								var users = $.parseJSON(data);
								//alert(users);
								var o='';
							
								for(var i=0; i<users.length; i++)
								{
									var user = users[i]['name'];
									var display = users[i]['display'];
									o += '<a href="javascript:void(0)" title="Chat with '+display+'" onClick="javascript:chatWith(\''+user+'\')"><li>'+display+'</li></a>';
									
								}
								var userCount = users.length;
								
								$('.user-num').html(userCount);
								
								$('.chat-users').html(o);
							}
						}
						
					); 
				}
			);
			
			
			$('a.stream-links').each
			(
				function()
				{
					var url = $(this).attr('href');
					var id = this.id;
					//var id = this.id;
					$.post
					(
						"<?php echo base_url(); ?>fetch?url="+url, 
						{
						}, 
						function(data)
						{
							if(data != '0')
							{
								var res = $.parseJSON(data);
							
								var ldata = '<a target="_new" href="'+url+'"><img src="'+res.img+'" width="100" height="100" /></a><a target="_new" href="'+url+'"><label class="link">'+res.title+'</label></a><br /><label class="url">'+res.url+'</label><br /><label class="desc">'+res.desc+'</label><br class="clear" />';
							
								$('#link'+id).html(ldata).fadeIn('slow');
							}
						}
					);
				}
			);
			$('a.stream-photos').each
			(
				function()
				{
					var id = parseInt(this.id.replace("photo", ""));
					//var id = this.id;
					$('#photo'+id).lightBox();
				}
			);
			
			$("a.stream-vids").jqvideobox({'width' : 400, 'height': 300, 'getimage': true, 'navigation': false});
			
			//$('#photo_attach').hide();
			$('.file_attach').hide();
			$('.video_attach').hide();
			$('.link_attach').hide();
			
			$('#show_file_attach').click
			(
				function()
				{
					$('.file_attach').toggle('slideDown');
					
					$("#video_attach").val('');
                    $(".video_attach").hide();
					$("#link_attach").val('');
					$(".link_attach").hide();
					 
				}
			);
			$('#show_video_attach').click
			(
				function()
				{
					$('.video_attach').toggle('slideDown');
					
					$("#file_attach").val('');
                    $(".file_attach").hide();
					$("#link_attach").val('');
					$(".link_attach").hide();
				}
			);
			$('#show_link_attach').click
			(
				function()
				{
					$('.link_attach').toggle('slideDown');
					
					$("#file_attach").val('');
                    $(".file_attach").hide();
					$("#video_attach").val('');
                    $(".video_attach").hide(); 
					
				}
			);
			
			var latestMsg = '<?php echo $latest_msg; ?>';
			
			$(document).everyTime
			(
				4000,
				function(i)
				{
					//$('#check').append('ons start'+latestComment);
					$.post
					(
						"<?php echo base_url(); ?>message/check_message",
						{data:latestMsg},
						function(data)
						{
							//$('#check').append('inside post'+latestComment);
							
							if(data != 'false')
							{
								var newMsg = $.parseJSON(data);
								var curUser = '<?php echo $this->session->userdata('userid'); ?>';
								
								var recUser = newMsg.rec_id;
									
								if(recUser === curUser)
								{
									$('.new-msg').html('<img src="<?php echo base_url(); ?>images/notifs.png" />');										
								}										
							}
						}
					);
				}
			);
			
			
			$('.notif').livequery
			(
				'click',
				function()
				{
					$('ul.alerts').toggle('slow');
					
					$('.notify').html('');
					
					$.post
					(
						"<?php echo base_url(); ?>notify/mark_read"
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
					
					$('#c'+id).hide();
				}
			);
			$('.view-comments a').livequery
			(
				'click',
				function()
				{
					var id = this.id;
					//alert(this.text);
					$('#apnd'+id).show();
					 
                   	$("#c"+id).show();
					 
					return false;
				}				
			);
			
			
			var page = 0;
			
			$('#load-more').click
			(
				function()
				{
					++page;
					var content = '<?php echo $content; ?>';
					var user = false;
					var group = false;
					
					if(content == 'user-stream')
					{
						user = '<?php echo $this_user_id; ?>';
						
						//alert(user);
					}
					
					if(content == 'group-stream')
					{
						group = '<?php echo $this_group_id; ?>';
												//alert(group);
					}
					
					loadMore(page,user,group);
				}
			);
			
			
			
			function loadMore(p,uid,gid)
			{
				
						
						$.post
						(
							"<?php echo base_url(); ?>stream/load_stream",
							{data:page,user:uid,group:gid},
							function(data)
							{	
								if(data == 'false')
								{
									$('#load-more').hide();
									$('#posts-loader').html('No more posts');
								}
								if(data != 'false')
								{
									
									$('#posts-loader').html('<img src="<?php echo base_url(); ?>images/lightbox-ico-loading.gif" />');						
									var newPosts = $.parseJSON(data);
								var posts = newPosts.posts;
								if(newPosts.comments)
								{
									var comments = newPosts.comments;
								}
							
								for(var i=0; i<posts.length; i++)
								{
									var newPost = posts[i];
								
									var page = '<?php echo $content; ?>';
									var cuser = '<?php echo $this_user_id ?>';
								
																	
								var postId = newPost.post_id;
								var postTime = newPost.post_time;
								var postText = newPost.post;								
								var poster = newPost.poster;
								
								var userPhoto = newPost.photo;
								var userName = newPost.user_name;
								var displayName = newPost.display_name;
								var canlike = newPost.can_like;
								var like_count = newPost.like_count;
								var attachLink = newPost.attach_link;
								var attachType = newPost.attach_type;
								var attach = 0;
								
								var commentCount = newPost.comment_count;
								
								var postedin = newPost.posted_in;
								groupDisplay = newPost.group_display;
								groupName = newPost.group_name;
								var group = 0;
								
								if(postedin != '0')
								{
									group = '<a class="in" href="<?php echo base_url(); ?>groups/'+groupName+'">'+groupDisplay+'</a>';
								}
								
								if(page == 'group-stream')
								{
									
									group = '';
								}
								
								
								
								
								
								//alert(attachLink);
								if(attachLink != '0')
								{
									
									switch(attachType)
									{
										case 'photo':
											attach = '<a class="stream-photos" id="photo'+postId+'" href="<?php echo base_url(); ?>uploads/large_photos/'+attachLink+'"><img src="<?php echo base_url(); ?>uploads/stream_photos/'+attachLink+'"  /></a>';
											break;
										case 'file':
											attach = '<a title="download file" href="<?php echo base_url(); ?>download?file='+attachLink+'">'+attachLink+'</a>';
											break;
										case 'video':
											attach = '<a class="stream-vids" href="'+attachLink+'">Video</a>';
											break;
										case 'deleted':
											attach = '<span class="deleted-attach">This attachment is either deleted or not availabe</span>';
											break;
										default:
											break;
									}
								}
													
								var post = '<div class="apost" id="wp'+postId+'"><ul id="f'+postId+'" class="'+userName+'"><li class="delete" id="d'+postId+'"><a href="#" id="'+postId+'" title="delete post" ><img src="<?php echo base_url(); ?>images/del-norm.png" width="15" height="15"  /></a></li><li class="photo"><a href="<?php echo base_url(); ?>'+userName+'"><img src="<?php echo base_url(); ?>uploads/thumbs/'+userPhoto+'" width="65" height="65" /></a></li><li class="name"><a href="<?php echo base_url(); ?>'+userName+'">'+displayName+'</a>';
								
								if(group != 0)
								{
									post += group+'</li><li class="post">'+postText+'</li>';
								}
								else
								{
									post += '</li><li class="post">'+postText+'</li>';
								}
								
								if(attach !=0)
								{
									post += '<li class="attachment">'+attach+'</li>';
								}
								
								post += '<div class="time-com">';
								
								if(canlike == true)
								{
									post += '<li class="like" id="like'+postId+'"><a href="#" title="Like this post" class="like-post" id="'+postId+'">Like</a></li>';
								}
								
								post += '<li class="comment"><a href="#" id="'+postId+'">Comment</a></li>';
								
								if(commentCount > 5)
								{
									post += '<li class="view-comments" id="'+postId+'"><a href="#" id="'+postId+'">'+commentCount+' comments</a></li>';
								}
								
								
								post += '<a href="#" class="who-likes" id="'+postId+'"><li class="likes" id="likes'+postId+'">'+like_count+'</li></a><li class="time">'+postTime+'</li><input type="hidden" id="post-id" value="'+postId+'" /><br class="clear" /></div><li class="comments" id="apnd'+postId+'">';		
								
									
									var newC = '';
									if(comments)
									{
										for(var j=0; j<comments.length; j++)
										{
											var comment = comments[j];
																		
											if(comment.post_id == postId)
											{
												var aComment = '<ul id="cc'+comment.comment_id+'" class="'+comment.user_name+'"><li class="delete-comment"  id="dc'+comment.comment_id+'"><a href="#" id="'+comment.comment_id+'" title="delete comment"><img src="<?php echo base_url(); ?>images/del-norm.png" width="15" height="15"  /></a></li><li class="comment-photo"><a href="<?php echo base_url(); ?>'+comment.user_name+'"><img src="<?php echo base_url(); ?>uploads/thumbs/'+comment.photo+'" width="50" height="50" /></a></li><li class="comment-name"><a href="<?php echo base_url(); ?>'+comment.user_name+'">'+comment.display_name+'</a></li><li class="comment-post">'+comment.comment+'</li><li class="comment-time">'+comment.comment_time+'</li><input type="hidden" id="comment-id" value="'+comment.comment_id+'" /></ul>';
										 		newC = newC + aComment;
											}
										}
									}
								var parts = '</li><li class="comment-box" id="c'+postId+'"><a href="<?php echo base_url().$signed_user_name; ?>"><img src="<?php echo base_url().'uploads/thumbs/'.$signed_user_photo;  ?>" width="50" height="50" /></a><textarea class="comment-text" id="t'+postId+'"  cols="40" rows="2"></textarea><br class="clear" /></li></ul></div>'; 								
								if(newC != '')
								{
									var newPart = post+newC+parts;
								}
								else
								{
									var newPart = post+parts;
								}
								
								
								$('.posts').append(newPart);
									
								//$('.posts').append(parts);
							}
							$('#posts-loader').html('');						

							//$('.comment-box').hide();
							$('.posts ul li.delete').hide();
							$('.posts ul li.delete-comment').hide();
							
							$('a.stream-photos').each
							(
								function()
								{
									var id = parseInt(this.id.replace("photo", ""));
									//var id = this.id;
									$('#photo'+id).lightBox();
								}
							);
			
							$("a.stream-vids").jqvideobox({'width' : 400, 'height': 300, 'getimage': true, 'navigation': false});
					
						}
					}
				);	
	
			}
						
			$('.comments ul').livequery
			(
				'mouseover',
				function()
				{
					//alert(this.id);
					var thisUser = '<?php echo $signed_user_name; ?>';
					var id = parseInt(this.id.replace("cc", ""));
					
					var user = $('#cc'+id).attr('class');
				
					var userid = '<?php echo $this_user_id; ?>';
					var content = '<?php echo $content; ?>';
					
					var admin = '<?php echo $is_admin; ?>';
					if(admin == '1')
					{
						$('#dc'+id).show();
					}
					
					if(content == 'group-stream')
					{
						var gadmin = '<?php echo $group_info['group_creator']; ?>';
						
						if(userid == gadmin)
						{
							$('#dc'+id).show();
						}
					}
					
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
					var id = parseInt(this.id.replace("d", ""));
					
					var warn = "Are you sure you want to delete this comment?";
					$('#del-warn').html(warn).dialog({modal: true,
					width : '370px',height : 'auto', resizable:false, closeOnEscape:true,
					focus:true,buttons:
					{
						"Yes":function()
						{
							$.post
							(
								"<?php echo base_url(); ?>post/del_comment",
								{data:id},
								function(data)
								{
									if(data != false)
									{
										$('#cc'+id).remove();
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
			
			$('.delete a').livequery
			(
				'click',
				function()
				{
					var id = this.id;
					
					var warn = "Are you sure you want to delete this post?";
					$('#del-warn').html(warn).dialog({modal: true,
					width : '370px',height : 'auto', resizable:false, closeOnEscape:true,
					focus:true,buttons:
					{
						"Yes":function()
						{
							$.post
							(
								"<?php echo base_url(); ?>post/del_post",
								{data:id},
								function(data)
								{
									//$('#check').append('inside post'+latestComment);
									if(data != 'false')
									{
										$('#wp'+id).remove();
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
			
			$('.posts ul').livequery
			(
				'mouseover',
				function(e)
				{
					
					var thisUser = '<?php echo $signed_user_name; ?>';
					var id = parseInt(this.id.replace("f", ""));
					var userid = '<?php echo $this_user_id; ?>';
					var content = '<?php echo $content; ?>';
					
					
					var admin = '<?php echo $is_admin; ?>';
					if(admin == '1')
					{
						$('#d'+id).show();
					}
					
					if(content == 'group-stream')
					{
						var gadmin = '<?php echo $group_info['group_creator']; ?>';
						
						if(userid == gadmin)
						{
							$('#d'+id).show();
						}
					}
					
					
					
					var user = $('#f'+id).attr('class');
					if(thisUser === user)
					{
						$('#d'+id).show();
						//$('#check').text('can delete');
					}
					
				}
			);
			$('.delete a').livequery
			(
				'mouseover',
				function()
				{
					var id = this.id;
					$('#d'+id+' img').attr('src','<?php echo base_url(); ?>images/del-hov.png');
				}
			);
			$('.delete a').livequery
			(
				'mouseout',
				function()
				{
					var id = this.id;
					$('#d'+id+' img').attr('src','<?php echo base_url(); ?>images/del-norm.png');
				}
			);
			$('.delete-comment a').livequery
			(
				'mouseover',
				function()
				{
					var id = this.id;
					$('#dc'+id+' img').attr('src','<?php echo base_url(); ?>images/del-hov.png');
				}
			);
			$('.delete-comment a').livequery
			(
				'mouseout',
				function()
				{
					var id = this.id;
					$('#dc'+id+' img').attr('src','<?php echo base_url(); ?>images/del-norm.png');
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
			var latestComment = '<?php echo $latest_comment; ?>';
			
			/*$('input#comment-id').each
			(
				function(m)
				{
					if(this.value > latestComment)
						latestComment = this.value;
					//alert(m);
				}
			);*/
			
			$(document).everyTime
			(
				2000,
				function(i)
				{
					//$('#check').append('ons start'+latestComment);
					$.post
					(
						"<?php echo base_url(); ?>stream/check_comment",
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
								
								
								var comment = '<ul id="cc'+commentId+'" class="'+userName+'"><li class="delete-comment"  id="dc'+commentId+'"><a href="#" id="'+commentId+'" title="delete comment" ><img src="<?php echo base_url(); ?>images/del-norm.png" width="15" height="15"  /></a></li><li class="comment-photo"><a href="<?php echo base_url(); ?>'+userName+'"><img src="<?php echo base_url(); ?>uploads/thumbs/'+userPhoto+'" width="50" height="50" /></a></li><li class="comment-name"><a href="<?php echo base_url(); ?>'+userName+'">'+displayName+'</a></li><li class="comment-post">'+commentText+'</li><li class="comment-time">'+commentTime+'</ul>';
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
									//var comment = commentText.substr(0,50);
									
									$.post
									(
										"<?php echo base_url(); ?>notify/notify_comment",
										{sender:commenter,post:postId,time:orignalTime,receiver:postUser},
										function(data)
										{
											
											if(data === '1')
											{
												//alert(displayName +'commented on your post'+ postPart +' '+commentTime);
												
												$('.notify').html('<img src="<?php echo base_url(); ?>images/notifs.png" />');
												var msg = '<li><span class="display"><a href="<?php echo base_url(); ?>'+userName+'">'+displayName+'</a></span> commented on your <a class="post-link" href="#f'+postId+'">post</a>" <span class="ctime">'+commentTime+'</span></li>';
												
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
			
			var latestId = '<?php echo $latest_post; ?>';

			// $('.posts ul:first').attr('id');
			//latestId = parseInt(latestId.replace("f", ""));			
			
			$(".posts").everyTime
			(
				4000,
				function(i)
				{
					//var id = $('.posts ul:first').attr('id');
					//alert(latestId);
					//++latestId;
					$.post
					(
						"<?php echo base_url(); ?>stream/check_update",
						{data:latestId},
						function(data)
						{
							
							if(data != 'false')
							{
								var page = '<?php echo $content; ?>';
								var cuser = '<?php echo $this_user_id ?>';
								
								
								
								var newPost = $.parseJSON(data);	
								
								var postId = newPost.post_id;
								var postTime = newPost.post_time;
								var postText = newPost.post;								
								var poster = newPost.poster;
								
								
								var userPhoto = newPost.photo;
								var userName = newPost.user_name;
								var displayName = newPost.display_name;
								
								var attachLink = newPost.attach_link;
								var attachType = newPost.attach_type;
								var attach = 0;
								
								var postedin = newPost.posted_in;
								groupDisplay = newPost.group_display;
								groupName = newPost.group_name;
								var group = 0;
								
								if(postedin != '0')
								{
									group = '<a class="in" href="<?php echo base_url(); ?>groups/'+groupName+'">'+groupDisplay+'</a>';
								}
								
								if(page == 'group-stream')
								{
									var gid = '<?php echo $this_group_id; ?>';
									
									if(postedin == '0' || gid != postedin)
									{
										return;										
									}
									group = '';
								}
								
								if(page == 'user-stream')
								{
									if(poster != cuser)
									{
										return;
									}
								}
								
								
								
								//alert(attachLink);
								if(attachLink != '0')
								{
									
									switch(attachType)
									{
										case 'photo':
											attach = '<a class="stream-photos" id="photo'+postId+'" href="<?php echo base_url(); ?>uploads/large_photos/'+attachLink+'"><img src="<?php echo base_url(); ?>uploads/stream_photos/'+attachLink+'"  /></a>';
											break;
										case 'file':
											attach = '<a class="stream-files" href="<?php echo base_url(); ?>download?file='+attachLink+'">'+attachLink+'</a>';
											break;
										case 'video':
											attach = '<a class="stream-vids" href="'+attachLink+'">Video</a>';
											break;
										case 'link':
											attach = '<div class="link-data" id="link'+postId+'"><a target="_new" id="'+postId+'" class="stream-links" href="'+attachLink+'">'+attachLink+'</a></div>';
											break;
										default:
											break;
									}
								}
								
								latestId = postId;
								var post = '<div class="apost" id="wp'+postId+'"><ul id="f'+postId+'" class="'+userName+'"><li class="delete" id="d'+postId+'"><a href="#" id="'+postId+'" title="delete post" ><img src="<?php echo base_url(); ?>images/del-norm.png" width="15" height="15"  /></a></li><li class="photo"><a href="<?php echo base_url(); ?>'+userName+'"><img src="<?php echo base_url(); ?>uploads/thumbs/'+userPhoto+'" width="65" height="65" /></a></li><li class="name"><a href="<?php echo base_url(); ?>'+userName+'">'+displayName+'</a>';
								
								if(group != 0)
								{
									post += group+'</li><li class="post">'+postText+'</li>';
								}
								else
								{
									post += '<li class="post">'+postText+'</li>';
								}
								
								if(attach !=0)
								{
									post += '<li class="attachment">'+attach+'</li>';
								}
								
								post += '<div class="time-com"><li class="like" id="like'+postId+'"><a title="Like this post" href="#" class="like-post" id="'+postId+'">Like</a></li> <li class="comment"><a href="" id="'+postId+'">Comment</a></li><a href="#" class="who-likes" id="'+postId+'"><li class="likes" id="likes'+postId+'"></li></a><li class="time">'+postTime+'</li><br class="clear" /></div><input type="hidden" id="post-id" value="'+postId+'" /><li class="comments" id="apnd'+postId+'"></li><li class="comment-box" id="c'+postId+'"><a href="<?php echo base_url().$user_name; ?>"><img src="<?php echo base_url().'uploads/thumbs/'.$profile_pic;  ?>" width="50" height="50" /></a><textarea class="comment-text" id="t'+postId+'" cols="40" rows="2"></textarea><br class="clear" /></li></ul></div>';
								
								//alert(post);
								if($('.posts ul').length === 0)
								{
									$('.posts').append(post);
								}
								else
								{
									$('.posts ul:first').before(post);
								}
								
								$('.post-box').val('');
								$('#post-box p.wait').hide('slow'); 
								$('.post-box').focus(); 
								$('#file_attach').val('');
								$('#video_attach').val('');
								$('.video_attach').hide();
								$('.file_attach').hide();
								$('.link_attach').hide();
								
								if(attachLink != '0')
								{
									if(attachType == 'link')
									{
										var url = attachLink;
										var id = postId;
										//var id = this.id;
										$.post
										(
											"<?php echo base_url(); ?>fetch?url="+url, 
											{
											}, 
											function(data)
											{
												if(data != '0')
												{
													var res = $.parseJSON(data);
												
													var ldata = '<a target="_new" href="'+url+'"><img src="'+res.img+'" width="100" height="100" /></a><a target="_new" href="'+url+'"><label class="link">'+res.title+'</label></a><br /><label class="url">'+res.url+'</label><br /><label class="desc">'+res.desc+'</label><br class="clear" />';
												
													$('#link'+id).html(ldata);
												}
											}
										);
									}
								}
								
								$('#photo'+postId).lightBox();
								$("a.stream-vids").jqvideobox({'width' : 400, 'height': 300, 'getimage': true, 'navigation': false});
								
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
					var postData = $.trim(postBox.val());
					$('.warn').text('');
					
					if(postData == '')
					{
						postBox.focus();
						return false;
					}
					
					$('#post-box p.wait').show();
					
					var options = 
					{	 
        				success: function(responseText)
						{
							//alert(responseText);
							var data = $.parseJSON(responseText);
							
							if(data.is_error == true)
							{
								var error = data.error;
								$('#post-box p.wait').hide('slow');
								$('.warn').html(error);
							}
						},  // post-submit callback 
 						
						url: "<?php echo base_url(); ?>post/do_post",
    			 	}; 
					$('#post-form').ajaxSubmit(options);
					/*$.post
					(
						"http://localhost/WebDev/StudentTribe/post/do_post",
						{data:postData},
						function(data)
						{														
							if(data != '0')
							{
								
							}
						}
					);*/
						
					return false;
				}
			);
			$('li.comment a').livequery
			(
				'click',
				function()
				{
					//var id = $(this).attr('id');
					var id = this.id;
					
					//$("#apnd"+id).show();
					$('#t'+id).focus();
					
					if ($("#apnd"+ id).is(':visible')) 
					 {
                    	//$("#dc"+id).hide();
					 }
					 else
					{
						$("#apnd"+id).show();
						$('#c'+id).show();
						$('#t'+id).focus();
					}
					//alert('#c'+id);
					/*//var id = parseInt(this.id);
					 if ($("#c"+ id).is(':visible')) 
					 {
                    	$("#c"+id).hide('slow');
					 }
					 else
					{
						$("#c" + id).show('fast');
						
					}*/
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
						//alert($.trim(commentBox.val()));
						
						if($.trim(commentBox.val()) == '')
						{
							commentBox.val('');
							$("#t" + id).focus();
						}
						else
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
			"<?php echo base_url(); ?>post/do_comment",
			{data:comment,id:where},
			function(data)
			{	
				
				if(data != '0')
				{
												
					//var comment = $('#comment-text').val();
					//alert();
					/*var photo = $('#photo').val();
					var user = $('#name').val();
					var display = $('#display').val();
					
var c = '<ul class="comments"><li class="comment-photo"><a href="http://localhost/WebDev/StudentTribe/'+user+'">				                    <img src="http://localhost/WebDev/StudentTribe/uploads/thumbs/'+photo+'" width="50" height="50" /></a></li><li                    class="comment-name"><a href="http://localhost/WebDev/StudentTribe/'+user+'">'+display+'</a></li><li                    class="comment-post">'+comment+'</li><li class="comment-time">'+data+'</ul>';
					//alert(comment);
					$('#apnd'+where).append(c);*/
				}
			}
		);
		
	}
</script>



