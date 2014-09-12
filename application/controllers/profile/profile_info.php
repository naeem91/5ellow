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

class Profile_Info extends CI_Controller
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
		$this->load->model('profile/projects_cv_model');
		$this->load->model('media/photo_model');
		
		//save logged-in user id and profile id for using in script
		$this->userid = $this->session->userdata('userid');
		$this->profileid = $this->session->userdata('profileid');
		
		$this->data = array();
		
		$this->data['title'] = "Info";
		$this->data['css'] = array('default.css','jquery-ui.css');
		$this->data['scripts'] = array('jquery.js','jquery.validate.js','jquery.form.js','profile-validation.js','jquery-ui.js');	
		$this->data['page'] = "stream";
		
		//fetch details that are common to settings pages
		$this->data['basic_details'] = $this->profile_model->get_profile_details();
		$this->data['display_name'] = $this->data['basic_details']['display_name'];
		//get profile picture
		$this->data['profile_pic'] =  $this->data['basic_details']['photo'];
		$this->data['user_name'] = $this->account_model->get_account_details('name');
	}
	public function user_info()
	{
		$this->data['content'] = "info";
		
		$this->load->view('templates/signedin-layout',$this->data);
	}
}