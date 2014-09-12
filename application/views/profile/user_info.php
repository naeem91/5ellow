<div id="user-info" class="info">
	<div id="inner_user_info">
    	<?php if(isset($is_fellow)): ?>
    		<?php if($is_fellow == FALSE): ?>
            	<?php echo $this->session->flashdata('status'); ?>
    			<?php $this->load->view('templates/be-fellow-button'); ?>
            <?php else: ?>
            	<p class="following" title="You are following <?php echo $display_name; ?>">Fellow</p>
        	<?php endif; ?> 
        <?php endif; ?>
    	
        
        <div id="info-section">
        	<div id="user-photo">
        		<a href="<?php echo base_url().'uploads/info_photos/'.$profile_pic ; ?>"><img src="<?php echo base_url(); ?>uploads/info_photos/<?php echo $profile_pic ?>" width="200" height="288"/></a>
        	</div>
        	<div id="info">
            	<h2><?php echo $display_name; ?></h2>
                <p><?php echo $basic_details['gender']; ?></p>
                <?php if($basic_details['dob'] != ''): ?>
                	<p>Born on: <?php echo $basic_details['dob']; ?></p>
                <?php endif; ?>
                <div id="about-me">
                	<?php if(!empty($basic_details['about_me'])): ?>
                   		<h3>About me</h3>
                    <?php endif; ?>
                	<p class="about-me">
                    	<?php echo $basic_details['about_me']; ?>
                    </p>
                </div>
                <div id="edu-info">
                	<?php if(!empty($education[0]['institute_name'])||!empty($education[1]['institute_name'])||!empty($education[2]['institute_name'])): ?>
                   		<h3>Education</h3>
                    <?php endif; ?>
                    <?php if($education != FALSE): ?>
                	<ul>
                    	<?php foreach($education as $record): ?>
                            	<div>
                    				<li class="inst">
										<?php echo $record['institute_name']; ?>                                    
                                    </li>
                                	<li class="attended">
                                    	
										 <?php echo $record['completion_year']; ?>                       
                                    </li>
                                    <li class="for">
                                    	
										 <?php echo $record['attended_for']; ?>                       
                                    </li>
                                </div>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        	
            <br class="clear" />
    	</div>
    </div>
</div>


<script type="text/javascript">
$(function() {
	// Use this example, or...
	
	$('#user-photo a').lightBox(); 
	// This, or...
	
});
</script>