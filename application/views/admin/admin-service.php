<div id="admin-service" class="admin-panel">
	<div id="inner-admin-service">
    	
        	
        
        <table border="1">
        	
        	<tr>
        		<th>Service</th>
        		<th>Status</th>
        	</tr>
            
       	
             <?php foreach($service as $ser): ?>
        		
                <tr>
            		<td><?php echo $ser['service_name']; ?></td>
					<td id="s<?php echo $ser['service_name']; ?>">
						<?php if($ser['service_status'] == 1): ?>
                        	Enabled
                        <?php else: ?>
                        	Disabled
                        <?php endif; ?>
                   	</td>
                    
                    <td>
                    	<?php if($ser['service_status'] == 1): ?>
                        	<input type="button" class="submit" id="<?php echo $ser['service_name']; ?>" value="Disable" />
                        <?php else: ?>
                        	<input type="button" class="submit" id="<?php echo $ser['service_name']; ?>" value="Enable" />
                        <?php endif; ?>
                    	</td>
               </tr>
                    
                    	
                   
            	
        	<?php endforeach; ?>
        
        </table>
   		<div id="warn" title="Confirm action?">
         	
         </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready
	(
		function()
		{
			
			$('input').livequery
			(
				'click',
				function()
				{
					var sname = this.id;
					var val = $(this).attr('value');
					
					var warn = "Are you sure you want to "+val+" this service?";
					$('#warn').html(warn).dialog({modal: true,
					width : '370px',height : 'auto', resizable:false, closeOnEscape:true,
					focus:true,buttons:
					{
						"Yes":function()
						{
							
							$.post
							(
								"<?php echo base_url(); ?>service/update_service",
								{service:sname,status:val},
								function()
								{
									//alert(data);
									if(val == 'Disable')
									{
										$('#s'+sname).text('Disabled');
										$('#'+sname).attr('value','Enable');
									}
									else
									{
										$('#s'+sname).text('Enabled');
										$('#'+sname).attr('value','Disable');
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
					
					
				}
			);
		}
	);
</script>