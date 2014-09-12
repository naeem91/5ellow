<?php $this->load->view('templates/head'); ?>
	<div class="non-signedin-layout">
		<?php	$this->load->view('templates/header'); ?>
		<div id="content">
    		<div id="inner-content">
        	<?php
        		switch($content)
					{
						case 'unverified':
							$this->load->view('account/unverified-user');
							break;
						case 'forgot-password':
							$this->load->view('account/forget-password');
							break;
						case 'verification':
							$this->load->view('account/verification');
							break;
						case 'blocked':
							$this->load->view('account/banned-user');
							break;
						default:
							break;
					}
			?>
    		</div>
    	</div>
	</div>
<?php $this->load->view('templates/footer');?>
