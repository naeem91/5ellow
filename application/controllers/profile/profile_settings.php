<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Controller Name: Account 
* Controls: User account operations
*
* Methods:
* - index
* - register 
* - login
* - logout
* - update password
* - update activation
* - reset forgot password
* - resend verification email
* 
* Last Updated: August 4,2012 
*/

class Profile_Settings extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('uploading');
		$this->load->library('photo');
		
		$this->load->model('account/account_model');
		$this->load->model('profile/profile_model');
		$this->load->model('profile/personal_profile_model');
		$this->load->model('media/photo_model');
		$this->load->model('post/post_model');
		$this->load->model('notification/notification_model');
		$this->load->model('message/message_model');
		$this->load->model('group/group_model');
		//if not logged-in redirect to home
		if($this->account_model->is_logged_in() == FALSE)
		{
			redirect(base_url());
		}
		//if not verified
		if($this->account_model->is_verified() == FALSE)
		{
			//redirect to unverified account page				
			redirect(base_url().'unverifiedAccount');
		}
		//save logged-in user id and profile id for using in script
		$this->userid = $this->session->userdata('userid');
		$this->profileid = $this->session->userdata('profileid');
		
		$this->data = array();
		
		$this->data['title'] = "Settings";
		$this->data['css'] = array('default.css','jquery-ui.css','chat.css','screen.css');
		$this->data['scripts'] = array('jquery.js','jquery.validate.js','jquery.livequery.js','jquery.timers.js','jquery.form.js','jquery-ui.js','jqvideobox.js','chat.js');	
		$this->data['page'] = "settings";
		
		//fetch details that are common to settings pages
		$this->data['basic_details'] = $this->profile_model->get_profile_details();
		$this->data['display_name'] = $this->data['basic_details']['display_name'];
		//get profile picture
		$this->data['profile_pic'] =  $this->data['basic_details']['photo'];
		$this->data['signed_user_name'] = $this->account_model->get_account_details('name');
		$this->data['signed_user_photo'] = $this->profile_model->get_profile_details('photo');
		$this->data['signed_user_display'] = $this->profile_model->get_profile_details('name');
		$this->data['user_name'] = $this->data['signed_user_name'];
		$this->data['is_user_stream'] = FALSE;
		//set user name, and id of this signedin user
		$this->data['signed_user_name'] = $this->account_model->get_account_details('name');
		$this->data['signed_user_id'] = $this->userid;
		$this->data['this_user_id'] = $this->userid;
		$this->data['group_info'] = 0;
		$this->data['this_group_id'] = 0;
	
		$this->data['super_admin'] = FALSE;
		$this->data['is_admin'] = FALSE;
		if($this->session->userdata('admin') == TRUE)
	        {     	
				$this->data['is_admin'] = TRUE;
				
				if($this->session->userdata('super_admin') == TRUE)
				{
					$this->data['super_admin'] = TRUE;
				}
			}
		$this->data['notifications'] =	$this->notification_model->get_notifications();
			
		$this->data['latest_post'] = $this->post_model->get_latest_post();
		$this->data['latest_comment'] = $this->post_model->get_latest_comment();
		$this->data['latest_msg'] = $this->message_model->get_latest_msg();
		$this->data['msgs'] = $this->message_model->is_unread_msgs();
		
		$this->data['top_groups'] = $this->group_model->get_top_groups();
		$this->data['top_users'] = $this->profile_model->get_top_members();
	}
	public function index()
	{
		
		
		//var_dump($this->data['basic_details']);
		$this->data['title'] = "Personal Settings";
		$this->data['content'] = "personal-settings";
		
		//get user name
		$this->data['user_name'] = $this->account_model->get_account_details('name');
		
		$this->data['iserror'] = FALSE;

		if($this->_validation() == FALSE )
		{
			//echo validation_errors();
		}
		else
		{
			//profile id of the user
			$pid = $this->session->userdata('profileid');

			//for saving errors 
			$error = array();
			
			//save username
			$uid = $this->session->userdata('userid');
			$new_name = $this->input->post('user_name');
			
			if($this->account_model->change_username($uid,$new_name) == FALSE)
			{
				$error[] = 'user name not changed';
				$this->data['iserror'] = TRUE;
			}
			
			//save profile photo
			if(isset($_FILES['userfile']) && $_FILES['userfile']['name'] != '')
			{
				$new_photo =  $this->input->post('userfile');
				$pic_name = $_FILES['userfile']['name'];
				//get photo name to save it 
				//$photo_name = $this->profile_model->new_photo_name();
							
				//upload photo
				$isUploaded = $this->uploading->photo_upload($new_photo,$pic_name);
				if($isUploaded == 'uploaded')
				{
					//if photo upload succesfull, save its record in database
					$photo_data['user_id'] = $this->session->userdata('userid');
					$photo_data['photo_name'] = $pic_name;
					$photo_id = $this->photo_model->create($photo_data);
				
					//set new photo as profile photo
					$new_data['photo'] = $photo_id;
				}
				else 
				{
					$photo_errors = $isUploaded;
					$this->data['iserror'] = TRUE;
				}
			}		
			//save basic detials
			$new_data['display_name'] = $this->input->post('dis_name');
			$new_data['gender'] = $this->input->post('gender');
			$new_data['dob'] = $this->input->post('dob');
			$new_data['about_me'] = $this->input->post('about');
			
			if($this->data['iserror'] == FALSE)
			{
				if($this->profile_model->update_profile($new_data) == FALSE )
				{
					$error[] = 'Error in saving basic details';
					$this->data['iserror'] = TRUE;
				}
			}
			
			//if errors, get them all in one variable
			if($this->data['iserror'] == TRUE)
			{
				if(!empty($photo_errors))
				{
					foreach($photo_errors as $er)
					{
						$error[] = $er;
					}
				}
				$this->data['errors'] = $error;

			}
			else
			{
				//set flashdata for success message
				$this->session->set_flashdata('status', '<p class="status">Settings updated successfully!</p>');
				redirect(base_url().'account/personal-settings');
			}
		}
		
		
		$this->load->view('templates/signedin-layout',$this->data);
	}
	
	private function _validation()
	{
		//check user input by applying validation rules
		
		//if user changes user name, make user its unique
		if($this->input->post('user_name') != $this->account_model->get_account_details('name'))
		{
			$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|xss_clean|alpha_dash|is_unique[user.user_name]');
		}
		$this->form_validation->set_rules('dis_name', 'Display Name', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_rules('userfile', 'Profile Photo', 'trim|callback_is_image');
		$this->form_validation->set_message('is_image', 'Only jpg,png and gif are allowed for profile photo');
		$this->form_validation->set_message('is_unique','This name already exists. Choose another');
		
		if ($this->form_validation->run() == FALSE)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	public function is_image()
	{
		if(!empty($_FILES['userfile']) && !empty($_FILES['userfile']['name']))
		{
			if ($_FILES['userfile']['type'] == "image/png" || $_FILES['userfile']['type'] == "image/jpeg" || $_FILES['userfile']['type'] ==              "image/gif")
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}	
		}
		else
		{
			return TRUE;
		}
	}
	
/**	
 * change account password
 *	
 *	this function changes password
 *	input and check old password
 *	set new password
 */

	public function change_password()
	{
		//not logged-in
		if($this->account_model->is_logged_in() == FALSE)
		{
			redirect(base_url());
		}
		$this->data['title'] = "Password Settings";		
		$this->data['content'] = "password-settings";
		
		$this->_oldpass = $this->input->post('old-pw');
		$this->_newpass = $this->input->post('new-pw');
		
		$this->form_validation->set_rules('old-pw', 'Old Password', 'trim|required|min_length[6]|sha1');
		$this->form_validation->set_rules('new-pw', 'New Password', 'trim|required|min_length[6]|sha1|callback_check_pass');
		$this->form_validation->set_message('check_pass', 'Your old password is incorrect');

		if ($this->form_validation->run() == FALSE)
		{
		}
		else
		{
			$new_pass = $this->_newpass;
			$u_id = $this->session->userdata('userid');
	
			if($this->account_model->reset_pass($u_id,$new_pass) == TRUE)
			{
				$this->data['notice'] = "Password changed succesfully";
			}
			else
			{
				$this->data['notice'] = "Password was not changed";				
			}
		}
		$this->load->view('templates/signedin-layout',$this->data);

	}
	/**	
 * check password
 *	
 *	this function checks if old password is correct, it is used by change_password
 */

	public function check_pass()
	{
		$u = $this->account_model->get_account_details('email');
		
		return $this->account_model->login_check($u,$this->_oldpass);
	}
	
	public function education_settings()
	{
		//not logged-in
		if($this->account_model->is_logged_in() == FALSE)
		{
			redirect(base_url());
		}
		$this->data['title'] = "Education Settings";		
		$this->data['content'] = "education-settings";
		$this->data['education_details'] = $this->personal_profile_model->get_details('education');
		
		$this->load->view('templates/signedin-layout',$this->data);
	}
	public function add_new_inst()
	{
		$profile_id = $this->profileid;
		$inst_name = $this->input->post('name');
		$inst_for = $this->input->post('instfor');
		$year = $this->input->post('year');
		
		$data = array('profile_id'=>$profile_id,'institute_name'=>$inst_name,'attended_for'=>$inst_for,'completion_year'=>$year);
		
		$result = $this->personal_profile_model->insert_education($data);
		if($result == FALSE)
		{
			echo FALSE;
		}
		else
		{
			echo $result;
		}
	}
	public function update_inst()
	{
		$id = $this->input->post('id');
		$inst_name = $this->input->post('name');
		$inst_for = $this->input->post('instfor');
		$year = $this->input->post('year');
		
		$data = array('institute_name'=>$inst_name,'attended_for'=>$inst_for,'completion_year'=>$year);
		
		$result = $this->personal_profile_model->update_education($data,$id);
		if($result == FALSE)
		{
			echo FALSE;
		}
		else
		{
			echo TRUE;
		}
	}
	public function del_inst()
	{
		$id = $this->input->post('id');
		if($this->personal_profile_model->remove_education($id))
		{
			echo TRUE;
		}
		else
		{
			echo FALSE;
		}
	}
	
	public function make_fellow()
	{
		$to_follow = $this->input->post('toFollow');
		$fellower = $this->input->post('fellower');
		$name = $this->input->post('name');
		
		if($this->profile_model->make_fellow($to_follow,$fellower) == TRUE)
		{
			$this->session->set_flashdata('status','Success');
			echo '<p class="following">Fellow</p>';
		}
		else
		{
			$this->session->set_flashdata('status','Fail');
			echo "Try again later.";
		}
	}
	
}