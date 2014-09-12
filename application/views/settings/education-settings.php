<div id="education-settings">
	<div id="inner-education-settings">
    
    	<table border="1" id="ints">
       	<?php if($education_details == TRUE): ?>
              
         	
         	<tr>
            	<th>Institue</th>
                <th>Attended For</th>
                <th>Completion Year</th>
            </tr>
         	
            	
         		 <?php foreach($education_details as $record): ?>
          			<tr id="inst-rec<?php echo $record['edu_id']; ?>">
                  		<td id="rname<?php echo $record['edu_id']; ?>" class="inst-title"><?php echo $record['institute_name']; ?> </td>
                       	<td id="rfor<?php echo $record['edu_id']; ?>"><?php echo $record['attended_for']; ?> </td>
                  		<td id="ryear<?php echo $record['edu_id']; ?>"><?php echo $record['completion_year']; ?> </td>
                        <td><a href="#"  class="edit-rec" id="<?php echo $record['edu_id']; ?>">Edit</a></td>
                        <td><a href="#"  class="del-rec" id="<?php echo $record['edu_id']; ?>">Delete</a></td>
                        
                        <div id="edit<?php echo $record['edu_id']; ?>" class="edit-inst" title="Edit Institute">
                        	<div>
                  				<label>Institute Name</label>
                  				<input type="text" id="edname<?php echo $record['edu_id']; ?>" value="<?php echo $record['institute_name']; ?>" />
              				</div>
              				<div>
                  				<label>Attended for</label>
                  				<input type="text" id="edfor<?php echo $record['edu_id']; ?>" value="<?php echo $record['attended_for']; ?>"/>
              				</div> 
              				<div>
                  				<label>Completion Year</label>
                                <select id="edyear<?php echo $record['edu_id']; ?>">
                  				<?php
									for($i=1970; $i<=2025; $i++)
									{
										if($i == $record['completion_year'])
										{
											echo '<option selected="selected">'.$i.'</option>';
										}
										else
										{
											echo '<option>'.$i.'</option>';
										}
									}
								?>
                                </select>
              				</div> 
              				<ul class="err"></ul>
                        </div>
                        

              		</tr>      
          		<?php endforeach; ?>
         	
           
         <?php endif; ?>
         </table>
         
         <?php if($education_details == TRUE): ?>
         	<a href="#" id="add-institute" title="Add institute">Add another</a>
         <?php else: ?>
         	<a href="#" id="add-institute" title="Add institute">Add Education</a>
         <?php endif; ?>
         <div id="add-insta" class="add-inst" title="add institute">
              <div>
                  <label>Institute Name</label>
                  <input type="text" id="new-inst-name" />
              </div>
              <div>
                  <label>Attended for</label>
                  <input type="text" id="new-inst-for" />
              </div> 
              <div>
                  <label>Completion Year</label>
                  <select id="new-inst-year">
                  	<?php
						for($i=1970; $i<=2025; $i++)
						{
							if($i == 2012)
							{
								echo '<option selected="selected">'.$i.'</option>';
							}
							else
							{
								echo '<option>'.$i.'</option>';
							}
						}
					?>
                  </select>
              </div> 
              <ul class="err"></ul>
         </div>
         <div id="warn" title="Confirm delete?">
         	
         </div>
    </div>
</div>



<script>
$(document).ready
	(
		function() 
		{
			var pickerOpts = 
			{
				changeMonth: true,
				changeYear: true,
				dateFormat:"yy",
				showButtonPanel: true
			};
			
			/*$(".picker").each
			(
				function()
				{
					
					var id = parseInt(this.id.replace("edyear", ""));
					//alert('#year'+id);
					//alert($('#year'+id).val());
					for(var i=1970; i<=2025; i++)
					{
						if(i == 2012)
						{
							$('#edyear'+id).append('<option selected="selected">'+i+'</option>');
						}
						else
						{$('#edyear'+id).append('<option>'+i+'</option>');}
					}
				}
			);*/
			//$( ".datepicker" ).datepicker(pickerOpts);
			//$( "#new-inst-year" ).datepicker(pickerOpts);
			
			//$('.add-inst').hide();
			$('.edit-inst').hide();
			$('a#add-institute').click
			(
				function()
				{
					$('.add-inst').dialog('open');

				}
			);
			$('.del-rec').livequery
			(
				'click',
				function()
				{
					var id = this.id;
					//alert('del this edu rec'+id);
					var warn = "Are you sure you want to delete?";
					$('#warn').html(warn).dialog({modal: true,
					width : '370px',height : 'auto', resizable:false, closeOnEscape:true,
					focus:true,buttons:
					{
						"Yes":function()
						{
							$.post
							(
								"<?php echo base_url(); ?>account/delete_education",
								{id:id},
								function(data)
								{
									//alert(data);
									if(data != '0')
									{
										$('#inst-rec'+id).remove();
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
			$('.edit-rec').livequery
			(
				'click',
				function()
				{
					
					var id = this.id;
					var d = $('#edit'+id).html();
					/*alert(d);*/
					$('#edit'+id).html(d).dialog({modal: true,
					show: 'slide', hide: 'slide', width : 
					'370px',height : 'auto', resizable:false, closeOnEscape:true,
					focus:true,buttons:
					{
						"Save":function()
						{
							var id = parseInt(this.id.replace("edit", ""));
							//alert(this.id);
							var instName = $.trim($('#edname'+id).val());
							var instFor = $.trim($('#edfor'+id).val());
							var instYear = $.trim($('#edyear'+id).val());
							
							var error = "";
							
							//alert(instFor.length);
							
							if(instName == '')
							{
								error += "<li>Institute name is required</li>";
								
							}
							if(instName.length > 40)
							{
								error += "<li>Institute name should not be more than 40 characters</li>";
							}
							if(instFor.length > 30)
							{
								error += "<li>Attended for should not be more than 30 characters </li>";
							}
							if(error != "")
							{
								$('.err').html(error);
							}
							else
							{
								
								$.post
								(
									"<?php echo base_url(); ?>account/update_education",
									{id:id,name:instName,instfor:instFor,year:instYear},
									function(data)
									{
										//alert($("#edfor"+id).val());
										
										if(data == '1')
										{
											$('#rname'+id).text(instName);
											$('#rfor'+id).text(instFor);
											$('#ryear'+id).text(instYear);
											
											$('#edname'+id).attr('value',instName);
											$('#edfor'+id).attr('value',instFor);
											$('#edyear'+id).attr('value',instYear);
											
											$('#edyear'+id).html('');
											
											for(var i=1970; i<=2025; i++)
											{
												if(i == instYear)
												{
													$('#edyear'+id).append('<option selected="selected">'+i+'</option>');
												}
												else
												{
													$('#edyear'+id).append('<option>'+i+'</option>');
												}
											}
										}
									}								
								);
								
								$('.err').html('');
								$( this ).dialog( "close" );
							}
						},
						"Cancel":function()
						{
							$('.err').html('');
							$( this ).dialog( "close" );
						}
					}});
					//$('#edit'+id).dialog('open');
				}
			);
			
			/*$( ".edit-inst" ).dialog
			(
				{		
					autoOpen: false,
					height: 300,
					width: 350,
					modal: true,
					buttons:
					{
						"Save":function()
						{
							var id = parseInt(this.id.replace("edit", ""));
							//alert(this.id);
							var instName = $.trim($('#edname'+id).val());
							if(instName == '')
							{
								$('.err').text('name is required');
							}
							else
							{
								$('.err').text('');
							}
						},
						"Cancel":function()
						{
							$( this ).dialog( "close" );
						}
					}
				}
			);
			*/
			$( ".add-inst" ).dialog
			(
				{		
					autoOpen: false,
					height: 300,
					width: 350,
					modal: true,
					buttons: 
					{
						"Add institute": function() 
						{
							var instName = $.trim($('#new-inst-name').val());
							var instFor = $.trim($('#new-inst-for').val());
							var instYear = $.trim($('#new-inst-year').val());
							
							var error = "";
							
							if(instName == '')
							{
								error += "<li>Institute name is required</li>";
								
							}
							if(instName.length > 40)
							{
								error += "<li>Institute name should not be more than 40 characters</li>";
							}
							if(instFor.length > 30)
							{
								error += "<li>Attended for should not be more than 30 characters </li>";
							}
							if(error != "")
							{
								$('.err').html(error);
							}
							else
							{
								//save institute
								$.post
								(
									"<?php echo base_url(); ?>account/save_education",
									{name:instName,instfor:instFor,year:instYear},
									function(data)
									{
										//alert(data);
										if(data != '0')
										{
										  var instId = data;	
										  
										  var newInst = '<tr id="inst-rec'+instId+'"><td  id="rname'+instId+'" class="inst-title">'+instName+'</td><td id="rfor'+instId+'">'+instFor+'</td><td id="ryear'+instId+'">'+instYear+'</td><td><a href="#" class="edit-rec" id="'+instId+'">Edit</a></td><td><a href="#" class="del-rec" id="'+instId+'">Delete</a></td><td><div id="edit'+instId+'" class="edit-inst" title="Edit Institute"><div><label>Institute Name</label><input type="text" id="edname'+instId+'" value="'+instName+'" /></div><div><label>Attended for</label><input type="text" id="edfor'+instId+'" value="'+instFor+'"/></div><div><label>Completion Year</label><select id="edyear'+instId+'"  class="picker"></select></div> <span class="err"></span></div></td></tr>';
										  //alert($.trim(instName));
										  //alert(instName);
											
										
										  $('#ints').append(newInst);
										  
										  for(var i=1970; i<=2025; i++)
											{
												if(i == instYear)
												{
													$('#edyear'+instId).append('<option selected="selected">'+i+'</option>');
												}
												else
												{$('#edyear'+instId).append('<option>'+i+'</option>');}
											}
										  $('#edit'+instId).hide();
										  
										}
									}
								);
								
								$('.err').html('');
								$('#add-insta input').val('');
									
								$(this).dialog( "close" );
							}
						},
						Cancel: function() 
						{
							$('.err').html('');
							$('#add-insta input').val('');
							$( this ).dialog( "close" );
						}
					}
			
				}
			);
		}
	);
</script>