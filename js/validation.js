$(document).ready
(
	
	function activateValidation()
	{
		
		
	
		/*$('#sign-in').validate
		(
			{
				rules:
				{
					useremail:
					{
						required:true,
						email:true
					},
					userpass:
					{
						minlength: 6,
						required: true
					}
				},
				messages:
				{
					useremail:
					{
						required: "Please enter email", 
						minlength: jQuery.format("Enter at least {0} characters")
					},
					userpass:
					{
						required:"Provide a password",
						rangelength: jQuery.format("Enter at least {0} characters")
					}
				},
				 /* errorContainer: "#errors",
                  errorLabelContainer: "#errors",
                  errorElement: "li" */
				/* errorPlacement: function(error, element) 
				 { 
            		if ( element.is(":radio") ) 
                		error.appendTo( element.parent().next().next() ); 
            		else if ( element.is(":checkbox") ) 
                		error.appendTo ( element.next() ); 
            		else 
                		error.appendTo( element.parent().next() ); 
					
    					//error.appendTo('.error');

        		}*/
	/*		}
			
		);*/
		
		$('#sign-up').validate
		(
			{
				rules: 
				{
					name:
					{
						required:true,
						minlength:3,
						maxlength:20
					},
					email: 
					{
						required: true,
						email: true,
						remote:
						{
							url:"http://csuog.com/5ellow/register/jsEmailCheck",
							type:"post"
						}
					},
					
					pass: 
					{
						minlength: 6,
						required: true
					}
				},
				messages:
				{
					name:
					{
						required: "Please enter your name", 
						minlength: jQuery.format("Enter at least {0} characters"),
					},
					email:
					{
						required: "Please enter a valid email address", 
						remote:jQuery.format("{0} is already in use")
					},
					pass:
					{
						required:"Provide a password",
						rangelength: jQuery.format("Enter at least {0} characters")
					}
				},
				
				success: function(label) 
				{
					label.text('').addClass('valid');
				}
			}
		);
	}
	
	
);
	

