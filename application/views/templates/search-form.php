<div id="search-form">
	<div id="inner-search-form">
    	<label for="search">Search</label>
    	<input type="text" name="search" id="search" value="" />
        <input type="button" name="" id="srch" value="" />
    </div>
</div>


<script type="text/javascript">

	$('#search').Watermark('search fellows and groups','#CCC');
	var rid = '';
	$('#search').autocomplete
	(
		{
			source:"<?php echo base_url(); ?>search/do_search",
			select: function( event, ui ) 
			{
				rid = ui.item.id;
				var type = ui.item.type; 
				
				if(type == 'user')
				{
					window.location.href = '<?php echo base_url(); ?>'+rid;
				}
				else
				{
					window.location.href = '<?php echo base_url(); ?>groups/'+rid;
					
				}
        	
				//alert( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
			} 	
		}
	);
	
	$('#search').keyup
	(
		function(event)
		{
			
		  if(event.keyCode === 13)
		  {	
		  	if(rid == '')
			{
				var q = $('#search').val();
			 	if($.trim(q) == '')
				{
					return;
				}
				window.location.href = '<?php echo base_url(); ?>search?q='+q;
			}
			  
		  }
		}
	);
	$('#srch').click
	(
		function()
		{
		  	if(rid == '')
			{
				var q = $('#search').val();
			 	if($.trim(q) == '' || $.trim(q) == 'search fellows and groups')
				{
					$('#search').focus();
					return;
				}
				window.location.href = '<?php echo base_url(); ?>search?q='+q;
			}
			  
		  
		}
	);
</script>