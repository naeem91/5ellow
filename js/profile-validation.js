$(document).ready
(
	function handleProjects()
	{
		$('#prj').validate
		(
			{
				submitHandler: function(form)
				{
					var options = 
					{	 
        			//target:'#output1',   // target element(s) to be updated with server response 
        			//beforeSubmit:  showRequest,  // pre-submit callback 
        				success: function(responseText)
						{
							window.location.reload();
							//alert(responseText);
							/*var obj = $.parseJSON(responseText);
							//alert(obj.shot);
							var img = "<img src=\"http://localhost/WebDev/StudentTribe/uploads/thumbs/"+obj.shot+"\" />";
							var title = obj.title;
							var edit = '<input type="button" id="'+obj.id+'" class="edit" value=\"Edit\" />';
							var del = '<input type="button" id="'+obj.id +'" class="delete" value="Delete" " />';
							//var id = "<input type=\"hidden\" value="+obj.id+" \" />";
							$('#newly').append
							(
								"<div>"+img+"<br />"+title+edit+del+"</div>"
							);
							$('#new-project').dialog('close');*/
						},  // post-submit callback 
 						
						url: 'http://localhost/WebDev/StudentTribe/test',
        			// other available options: 
        			//url:       url         // override for form's 'action' attribute 
        			//type:      type        // 'get' or 'post', override for form's 'method' attribute 
        			//dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
        			//clearForm: true        // clear all form fields after successful submit 
        			//resetForm: true        // reset the form after successful submit 
        				// $.ajax options can be used here too, for example: 
        				//timeout:   3000 
    			 	}; 
    				// bind form using 'ajaxForm' 
    				$('#prj').ajaxSubmit(options); 
				}
			}
		);
					/*$('#prj').ajaxForm
					(
						function() 
						{ 
                			alert("Thank you for your comment!"); 
            			}
					); */
				//}
			//}*/
		
		$('#add').click
		(
			function()
			{
				$('#new-project').dialog('open');
			}
		);	
		
		$('#new-project').dialog
		(
			{
				autoOpen: false,
				height: 500,
				width:500,
				modal: true,
				resizable: false,
				buttons: 
				{
					Save: function()
					{
						$("#prj").submit(
						);
					},
					Cancel:function()
					{
						$(this).dialog('close');			
					}
				}
			}
		);
		$('.edit').click
		(
			function()
			{
				var proj = '#'+this.id;
				//alert(proj);
				$('#90').dialog('open');
				//$('#notify').load('http://localhost/WebDev/StudentTribe/test/delete');
			}
		);
		$('.edit-project').dialog
		(
			{
				autoOpen: false,
				height: 200,
				width:200,
				modal: true,
				resizable: false,
				buttons: 
				{
					Edit: function()
					{
						//var id = $('
						//alert(this.id);
					},
					Cancel:function()
					{
						$(this).dialog('close');			
					}
				}
			}
		);
		$('.delete').click
		(
			function()
			{
				$('#delete-confirm').dialog('open');
				//$('#notify').load('http://localhost/WebDev/StudentTribe/test/delete');
			}
		);
		$('#delete-confirm').dialog
		(
			{
				autoOpen: false,
				height: 200,
				width:200,
				modal: true,
				resizable: false,
				buttons: 
				{
					Delete: function()
					{
						//var id = $('
						//alert(this.id);
					},
					Cancel:function()
					{
						$(this).dialog('close');			
					}
				}
			}
		);
	}	
	
);	
	
		

