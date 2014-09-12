<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    	<meta charset="UTF-8">
        <meta name='robots' content='all' />
		<meta name='keyword' content='student social network' />
		<meta name='description' content='5ellow: 5ellow is an experimental social networking website.' />
		<title><?php echo $title; ?></title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/reset.css" type="text/css" />
        <?php
			if(!empty($css))
			{
				foreach($css as $cssfile)
				{
					echo "<link rel='stylesheet' href='";echo base_url()."css/$cssfile' type='text/css' />";
				}
			}
			if(!empty($scripts))
			{
				foreach($scripts as $script)
				{
					echo "<script type='text/javascript' src='";echo base_url()."js/$script'></script>";
				}
			}
		?>
        <link rel="shortcut icon" href="<?php echo base_url() ?>/images/favicon.ico" />
	</head>	
	<body>