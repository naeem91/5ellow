<div id="messages">
	<div id="inner-messages">
    	<div class="send-pm">
        	
    		<form method="post" action="">
            	<div class="to">
                	<label for="receiver">Receiver</label>
            		<input type="text" id="receiver" />
                </div>
                <div>
                	<label for="msg">Message</label>
                    <textarea id="pm-msg" rows="3" cols="40"></textarea>
                    <p class="exceed"></p>
                </div>
                
                <p class="wait"><img src="<?php echo base_url(); ?>images/wait3.gif" /></p>
                <input type="submit" class="submit" value="Send" />
            </form>
        </div>
        <div class="all-pm">
        	<?php if($messages != FALSE): ?>
            	<?php for($i=0; $i<count($messages["msgs"]); $i++): ?>
                	<?php $sender = $messages["senders"][$i]; ?>
                    <?php $rec = $messages["receivers"][$i]; ?>
                    <?php $msg = $messages["msgs"][$i]; ?>
                     <?php $replys = $messages["replies"][$i]; ?>
                	<ul id="mmsg<?php echo $msg['msg_id']; ?>" class="main-msg" read="<?php echo $msg['msg_read']; ?>" >
                    	<input type="hidden" class="sender" id="snd<?php echo $msg['msg_id']; ?>" value="<?php echo $msg['msg_sender']; ?>" />
                    	<input type="hidden" class="rec" id="rec<?php echo $msg['msg_id']; ?>" value="<?php echo $msg['msg_receiver']; ?>" />
                        
                        
                        <div class="srec">
                    		
                              <a href="<?php echo base_url().$sender["user_name"]; ?>">
                                  <li class="img"><img src="<?php echo base_url().'uploads/thumbs/'.$sender['photo']; ?>" width="65" height="65" /></li>
                                  <li class="display"> <?php echo $sender['display_name']; ?></li>
                              </a>
                        	
    						 <a href="<?php echo base_url().$rec["user_name"]; ?>">
                                  <li class="rec"> <?php echo $rec['display_name']; ?></li>
                              </a>	
                              <li class="msg"><?php echo $msg['msg_text']; ?></li>                    
   	                     </div>
                         
                         
                        <br class="clear" />
                        
                        
                        <div class="ct">
                        	<li class="reply"><a href="#" id="<?php echo $msg['msg_id']; ?>">Reply</a></li>
                        	<span class="mtime"><?php echo $msg['msg_time']; ?></span>
                            
                            <br class="clear" />
                        </div>
                        
                        
                        <div class="replys" id="mr<?php echo $msg['msg_id']; ?>">
                        	<?php if($replys != FALSE): ?>
                            	<?php foreach($replys as $reply): ?>
                        			<ul class="reply" id="arep<?php echo $reply['msg_id']; ?>" read="<?php echo $reply['msg_read']; ?>" recvr="<?php echo $reply['msg_receiver']; ?>">
                                    	<?php if($reply['msg_sender'] == $msg['msg_sender']): ?>
                                        <div class="send">
                                        <a href="<?php echo base_url().$sender["user_name"]; ?>">
                                        	<li><img src="<?php echo base_url().'uploads/thumbs/'.$sender['photo']; ?>" width="50" height="50" /></li>
                        					<li class="display"> <?php echo $sender['display_name']; ?></li>
                                         </a>
                                         </div>  	
                                        <?php else: ?>
                                        <div class="send">
                                        	<a href="<?php echo base_url().$rec["user_name"]; ?>"> 
                                        	<li><img src="<?php echo base_url().'uploads/thumbs/'.$rec['photo']; ?>" width="50" height="50" /></li>
                        					<li class="display"><?php echo $rec['display_name']; ?></li>			
                                            </a>
                                            </div>
                                        <?php endif; ?>
                                        <br class="clear" />
                                        <div>
                            				<li class="msg"><?php echo $reply['msg_text']; ?></li>
                                        </div>
                                        <span class="rtime"><?php echo $reply['msg_time']; ?></span>
                                        <br class="clear" />
                            		</ul>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="opts">
                        	
                            <li class="reply-box" id="rep<?php echo $msg['msg_id']; ?>">
                            	<div class="profile-pic"><a href="<?php echo base_url().$signed_user_name;; ?>" ><img src="<?php echo base_url();?>uploads/thumbs/<?php echo $profile_pic; ?>" width="50" height="50" /></a></div>
                            	<textarea class="reply-text" id="r<?php echo $msg['msg_id']; ?>" rows="2" cols="50"></textarea>
                            </li>
                        </div>
                        <br class="clear" />

                    </ul>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
    </div>
</div>



<script type="text/javascript">
	$(document).ready
	(
		
		function()
		{
			
			$(window).on
			(
				'beforeunload', 
				function() 
				{
    				$.post
					(
						"<?php echo base_url(); ?>message/mark_read"
					);
				}
			);
			
			
			/*$('.reply-box').hide();*/
			$('.new-msg').html('');
			
			$('ul.main-msg').each
			(
				function()
				{
					var id = parseInt(this.id.replace("mmsg", ""));
					
					var read = $('#mmsg'+id).attr('read');
					var user = $('#rec'+id).attr('value');
					var cUser = '<?php echo $this->session->userdata("userid"); ?>';
					//alert(cUser);
					if(read == '0' && user == cUser)
					{
						$('#mmsg'+id).css
						(
							'border','1px solid #F60'
						);
					}
				}
			);
			$('ul.reply').each
			(
				function()
				{
					var id = parseInt(this.id.replace("arep", ""));
					
					var cUser = '<?php echo $this->session->userdata("userid"); ?>';
					
					var read = $('#arep'+id).attr('read');
					var user = $('#arep'+id).attr('recvr');
					
					
					if(read == '0' && user == cUser)
					{
						$('#arep'+id).css
						(
							'background-color','#dddddd'
						);
					}
				}
			);
			
			$('.reply a').livequery
			(
				'click',
				function()
				{
					//alert('clicked');
					var id = this.id;
					//alert(id);
					$('#r'+id).focus();
					
					return false;
				}
			);
			$('.reply-text').livequery
			(
				'keyup',
				function(event)
				{
					var id = parseInt(this.id.replace("r", ""));
					 
  					var replyBox = $("#r" + id);	
					
					if(event.keyCode === 13)
					{	
						if($.trim(replyBox.val()) == '')
						{
							replyBox.val('');
							$("#r" + id).focus();
						}
						else
						{
							//doComment(commentBox.val(),id);
							//commentBox.val('');
							var sender = '<?php echo $this->session->userdata('userid'); ?>';
							var recver;
							var replyTo = id;
							
							var send = $('#snd'+id).val();
							var rec = $('#rec'+id).val();
							
							//alert(send);
							if(send != sender)
							{
								recver = send;
							}
							else
							{
								recver = rec;
							}
							
							doReply(sender,recver,replyBox.val(),replyTo);
							
							replyBox.val('');
						}
						
					}
					
					var chars = replyBox.val();
				
					if(chars.length > 50)
					{
						
						replyBox.val(chars.substr(0,50));
					}
				}
			);
			function doReply(sender,recver,msg,reply)
			{
				$.post
				(
					"<?php echo base_url(); ?>message/new_reply",
					{sender:sender,to:recver,msg:msg,reply:reply},
					function(data)
					{	
				
						if(data != '0')
						{
						}
					}
				);
			}
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
							
								//alert(data);
								var newMsg = $.parseJSON(data);	
								//alert(newMsg.msg_text);
								latestMsg = newMsg.msg_id; 
								
								if(newMsg.reply == '0')
								{
									var msg = '<ul id="mmsg'+newMsg.msg_id+'" class="main-msg" read="'+newMsg.msg_read+'"><input type="hidden" id="snd'+newMsg.msg_id+'" value="'+newMsg.sender_id+'" /><input type="hidden" id="rec'+newMsg.msg_id+'" value="'+newMsg.rec_id+'" /><div class="srec"><a href="<?php echo base_url();?>'+newMsg.sender_user+'"><li class="img"><img src="<?php echo base_url().'uploads/thumbs/'; ?>'+newMsg.sender_photo+'" width="65" height="65" /></li><li class="display">'+newMsg.sender_display+'</li></a><a href="<?php echo base_url(); ?>'+newMsg.rec_user+'"><li class="rec">'+newMsg.rec_display+'</li></a><li class="msg">'+newMsg.msg_text+'</li>  </div><br class="clear" /><div class="ct"><li class="reply"><a href="#" id="'+newMsg.msg_id+'">Reply</a></li><span class="mtime">'+newMsg.msg_time+'</span><br class="clear" /></div><div class="replys" id="mr'+newMsg.msg_id+'"></div><div class="opts"><li class="reply-box" id="rep'+newMsg.msg_id+'"><div class="profile-pic"><a href="<?php echo base_url().$signed_user_name;; ?>" ><img src="<?php echo base_url();?>uploads/thumbs/<?php echo $profile_pic; ?>" width="50" height="50" /></a></div><textarea class="reply-text" id="r'+newMsg.msg_id+'" rows="2" cols="50"></textarea></li></div><br class="clear" /></ul>';
								
									if($('.all-pm ul').length === 0)
									{
										$('.all-pm').append(msg);
									}
									else
									{
										$('.all-pm ul:first').before(msg);	
									}
									
									
									$('.send-pm p.wait').hide();
									//$('#rep'+newMsg.msg_id).hide();	
									$('#pm-msg').val('');
									$('#receiver').val('');
									$('#receiver').focus();	
									
									var curUser = '<?php echo $this->session->userdata('userid'); ?>';
									var recUser = newMsg.rec_id;
									//alert(recUser);
									if(recUser === curUser)
									{
										$('.new-msg').html('new!');
										
										$('#mmsg'+newMsg.msg_id).css
										(
											'background-color','#dddddd'
										);
									}					
								}
								else
								{
									var msg = '<ul id="arep'+newMsg.msg_id+'" class="reply" read="'+newMsg.msg_read+'" recver="'+newMsg.rec_id+'"><div class="send"><a href="<?php echo base_url(); ?>'+newMsg.sender_user+'"><li><img src="<?php echo base_url(); ?>uploads/thumbs/'+newMsg.sender_photo+'" width="50" height="50" /></li><li class="display">'+newMsg.sender_display+'</a></li></a></div><br class="clear" /><div><li class="msg">'+newMsg.msg_text+'</li></div><span class="rtime">'+newMsg.msg_time+'</span><br class="clear" /></ul>';
									
									$('#mr'+newMsg.reply).append(msg);
									
									var curUser = '<?php echo $this->session->userdata('userid'); ?>';
									var recUser = newMsg.rec_id;
									//alert(recUser);
									if(recUser === curUser)
									{
										$('.new-msg').html('new!');
										
										$('#arep'+newMsg.msg_id).css
										(
											'background-color','#dddddd'
										);
									}		
								}
								
								
								
							}
						}
					);
				}
			);

			$('.send-pm p.wait').hide();
			
			var maxChars = 200;
			var msgBox = $('#pm-msg');
			$('#pm-msg').keyup
			(
				function()
				{
					var chars = msgBox.val();
					
					if(chars.length > maxChars)
					{
						msgBox.val(chars.substr(0,maxChars));
						$('.exceed').text('You reached max limit of '+maxChars+' characters');
					}
					else
					{
						$('.exceed').text('');
					}
				}
			);
			
			var to = '';
			$('#receiver').autocomplete
			(	
				{
					source:"<?php echo base_url(); ?>members/get_members",
					select: function( event, ui ) 
					{
						to = ui.item.id;
						//alert( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
					} 	
				}
			);
			
			$('input.submit').click
			(
				function()
				{
					$('.exceed').text('');
					var msg = $('#pm-msg').val();
					var recver = $('#receiver').val();
					
					if(msg == '' || to == '')
					{
						if(recver != '' && to == '')
						{
							$('.exceed').text('Receiver not found.');
						}
						if(recver == '')
						{
							$('#receiver').focus();
						}
						if(msg == '')
						{
							$('#pm-msg').focus();
						}
						
						return false;
					}
					
					$('.send-pm p.wait').show();
									
					$.post
					(
						"<?php echo base_url(); ?>message/new_message",
						{to:to,msg:msg},
						function(data)
						{
							//alert(data);
						}
					);
					/*alert(to);
					alert(msg);*/
					
					
					return false;
				}
			);
		}
	);
</script>