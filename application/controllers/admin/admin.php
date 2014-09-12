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

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin/admin_model');
		$this->load->model('account/account_model');
		$this->load->model('account/profile_model');
		$this->load->model('post/post_model');
		$this->load->model('group/group_model');
		$this->load->model('message/message_model');
	}
	
	public function update_service()
	{
		$srvc = $this->input->post('service');
		$state = $this->input->post('status');
		
		if($state == 'Disable')
		{
			$state = 0;
		}
		else
		{
			$state = 1;
		}
		
		$this->admin_model->service_settings($srvc,$state);
		
		
	}
	public function delete_admin()
	{
		$aid =  $this->input->post('id');
		if($this->admin_model->del_admin($aid) == TRUE)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
		
	}
	public function delete_user()
	{
		$uid =  $this->input->post('id');
		//echo $uid;
		//echo $this->account_model->delete_user($uid);
		if($this->account_model->delete_user($uid) == TRUE)
		{
			$this->profile_model->delete_profile($uid);
			$this->post_model->delete_user_posts($uid);
			$this->post_model->delete_user_comments($uid);
			$this->group_model->delete_from_all_groups($uid);
			$this->message_model->delete_user_msgs($uid);
			
			echo 1;
		}
		else
		{
			echo 0;
		}
		
	}
	public function ban_user()
	{
		$uid =  $this->input->post('id');

		if($this->account_model->ban_user($uid,'ban') == TRUE)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	public function unban_user()
	{
		$uid =  $this->input->post('id');
		
		if($this->account_model->ban_user($uid,'unban') == TRUE)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	public function add_admin()
	{
		$uid =  $this->input->post('id');
		if($this->admin_model->add_admin($uid) == TRUE)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
}