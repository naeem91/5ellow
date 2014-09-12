<?php $this->load->view('templates/head'); ?>

	
<a class="stream-links" href="http://www.yahoo.com">Link</a>
<div id="linkbox">
</div>
    </body>        
</html>

<script type="text/javascript">
	$(document).ready
	(
		function()
		{
			//$('#url').Watermark('http://');
			$('a.stream-links').each
			(
				function()
				{
					var url = $(this).attr('href');
					//var id = this.id;
					//var id = this.id;
					$.post
					(
						"<?php echo base_url(); ?>fetch?url="+url, 
						{
						}, 
						function(response)
						{
							
							alert(response);
							//$('#link'+id).html($(response).fadeIn('slow'));
						}
					);
				}
			);
		}
	);
	
	/*$(document).ready
	(
		function()
		{
			$('.chat-users').hide();
			
			/*$(').click
			(
				function()
				{
					if($('.chat-users').is(':visible')) 
					{
						$('.chat-users').hide();
					}
				}
			);
			
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
						"http://localhost/WebDev/StudentTribe/photo_upload",
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
						"http://localhost/WebDev/StudentTribe/check",
						function(data)
						{
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
									o += '<li><a href="javascript:void(0)" onClick="javascript:chatWith(\''+user+'\')">'+display+'</a></li>';
									
								}
								var userCount = users.length;
								
								$('.user-num').html(userCount);
								
								$('.chat-users').html(o);
							}
						}
						
					); 
				}
			);
		
			/*setInterval("update()", 10000);
			function update() 
			{ 
				$.post
				(
					"photo_upload",
					function(data)
					{
						alert(data);
					}
				); // Sends request to update.php 
			}  
		}
	);*/
</script>