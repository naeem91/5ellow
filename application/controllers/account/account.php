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

class Account extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		//load required library and models
		$this->load->library('form_validation');
		//custome class, contains email functions
		$this->load->library('myemail');
		$this->load->model('account/account_model');
		$this->load->model('profile/profile_model');
					
		
		//set title,scripts & css for page
		$this->data['title'] = "5ellow";
		$this->data['css'] = array('default.css','jquery-ui.css');
		$this->data['scripts'] = array('jquery.js','jquery.validate.js','validation.js');	
	}
	
/**	
 * register new user
 *
 * this function registers a new user
 * validate user input,create user via account model
 * send verification email
 * make user sign in
 * redirect to community home
 *
 */
	public function register()
	{
		//if logged-in redirect to community
		if($this->account_model->is_logged_in() == TRUE)
		{
			redirect(base_url().'community');
		}
		
		$this->data['title'] .= "- Sign Up";
		$this->data['signup_enable'] = $this->account_model->check_service('reg');
		
		$this->_p = $this->input->post('pass');
		//validate sign-up form input, if errors show register page with sign-up form & validation errors
		if($this->_validation() == FALSE)
		{
			$this->load->view('account/register',$this->data);
		}
		else
		{
			//set user data for storing in database & sending in email
			$udata['name'] = $this->input->post('name');
			$udata['email'] = $this->input->post('email');
			$udata['password'] = $this->_p;
			//generate a random verification code
			$udata['code'] = sha1(uniqid(rand(),true));	

			//create new user account
			if($this->account_model->create($udata) == TRUE)
			{
				//send verification email
				$udata['user'] = $this->account_model->get_account_details('name',$udata['email'],'email');
				$this->myemail->send_verification_email($udata);
				
				//set user as logged in
				$this->account_model->login($udata['email']);
				
				//a flash data flag indicating a new user
				$this->session->set_flashdata('welcome_msg', '<p class="msg">Welcome to 5ellow</p>');
				
				//redirect to unverified account page
				redirect(base_url().'unverifiedAccount');
			}
			//if account is not created due to database error
			else
			{
				$this->load->view('account/register',$this->data);
			}
		}
	}
/**	
 * sign up form validation
 *
 * this function validates sign up form input
 * it is used by register function
 * validate user input
 * check if user name & email are unique
 *
 */

	private function _validation()
	{
		//check user input by applying validation rules
		$this->form_validation->set_rules('name', 'Name','trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.user_email]');
		$this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[6]|sha1');
		$this->form_validation->set_message('required', 'Please provide a %s');
		
		if ($this->form_validation->run() == FALSE)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

/**	
 * js email uniqueness check
 *
 * this function checks if email is unique, it is used by validation script via ajax
 * check if email id already exists or not
 *
 */

	public function js_email_check()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.user_email]');
		
		if ($this->form_validation->run() == FALSE)
		{
			echo "false";
		}
		else
		{
			echo "true";
		}
	}
/**	
 * make user login
 * 
 * this function logins a user
 * validate user input
 * logins a user
 * redirect to community home
 *
 */

	public function login()
	{
		$this->data['title'] .= "- Login";
		//echo $_COOKIE['userid'];
		//if logged-in redirect to community
		if($this->account_model->is_logged_in() == TRUE)
		{
			redirect(base_url().'community');
		}
		$this->_email = $this->input->post('useremail');
		$this->_password = $this->input->post('userpass');
		
		$this->form_validation->set_rules('useremail', 'Email','trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('userpass', 'Password', 'trim|required|min_length[6]|sha1|callback_login_check');
		$this->form_validation->set_message('login_check','Username or password incorrect');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('account/login',$this->data);
		}
		else if($this->account_model->is_banned($this->_email) == TRUE)
		{
			$this->data['title'] .= "- Blocked Account";
			$this->data['content'] = "blocked";

		
			$this->load->view('templates/non-signedin-layout',$this->data);
			
		}
		else
		{
			//make logged-in & redirect
			$this->account_model->login($this->_email);
			if(isset($_POST['keep-signin']))
			{
				$umail = $this->_email;
				
				//echo $uid;
				setcookie('umail',$umail,time()+172800,'/');
			}
			
			
			//echo $this->input->post('keep-signin');
			if($this->account_model->is_verified() == FALSE)
			{
				//redirect to unverified account page				
				redirect(base_url());
			}
			else
			{
				//redirect to community home
				redirect(base_url().'community');				
			}
			
		}
	}
/**	
 * login check
 *	
 * this function check if user name & password correct via account model
 * it used by login function
 *
 */

	public function login_check()
	{
		return $this->account_model->login_check($this->_email,$this->_password);	
	}
/**	
 * logout
 *	
 * destroy session and redirect to welcome page
 *
 */

	public function logout()
	{
		//if user logged-in
		if($this->account_model->is_logged_in() == TRUE)
		{
			
			
			$this->session->destroy();
			
			
		}
		
		setcookie('umail','',time()-1*24*60*60,'/');
		redirect(base_url());
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
		//if not verified
		if($this->account_model->is_verified() == FALSE)
		{
			//redirect to unverified account page				
			redirect(base_url().'unverifiedAccount');
		}
		
		$this->data['title'] .= "-Reset Password";
		
		$this->_oldpass = $this->input->post('old-pw');
		$this->_newpass = $this->input->post('new-pw');
		
		$this->form_validation->set_rules('old-pw', 'Old Password', 'trim|required|min_length[6]|sha1');
		$this->form_validation->set_rules('new-pw', 'New Password', 'trim|required|min_length[6]|matches[repeat-new-pw]|sha1');
		$this->form_validation->set_rules('repeat-new-pw', 'Repeat New Password', 'trim|required|min_length[6]|sha1|callback_check_pass');
		$this->form_validation->set_message('check_pass', 'Your old password is incorrect');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('templates/signedin-layout');
		}
		else
		{
			$new_pass = $this->_newpass;
			$u_name = $this->session->userdata('username');
	
			if($this->account_model->reset_pass($u_name,$new_pass) == TRUE)
			{
				$this->session->set_flashdata('result',"Password Changed succesfully");
			}
			else
			{
				$this->session->set_flashdata('result',"Password could not be changed");
			}
		}
	}
/**	
 * check password
 *	
 *	this function checks if old password is correct, it is used by change_password
 */

	public function check_pass()
	{
		$u = $this->session->userdata('username');
		
		return $this->account_model->login_check($u,$this->_oldpass);
	}
/**	
 * resend verify email
 *
 * this function resend verification email
 * generate & save new verification code in user account and send email
 *
 */

	public function resend_verify_email()
	{
		//if user is not logged-in or is already verified, redirect it to home
		if($this->account_model->is_logged_in() == FALSE || $this->account_model->is_verified() == TRUE)
		{
			redirect(base_url());
		}
		$udata['code'] = sha1(uniqid(rand(),true));
		$udata['user'] = $this->account_model->get_account_details('name');
		$udata['email'] = $this->account_model->get_account_details('email');
	
		//update the activation code in user record
		if($this->account_model->update_active($udata['user'],$udata['code']))
		{
			//send email
			$this->myemail->send_verification_email($udata);
			
			//set flash data for success message
			$this->session->set_flashdata('status','<p class="success">Verification Email resent succesfully!</p>');		
		}
		else
		{
			//set flashdata for failure message
			$this->session->set_flashdata('status','<p class="fail">Email resending failed.</p>');			
		}
		
		//redirect to unverified-user page
		redirect(base_url().'unverifiedAccount');		
	}
/**	
 * account verification
 *
 * this function verifies an account by receiving verification link
 * validate verification link
 * set user status as verified
 *
 */

	public function verification()
	{
		$this->data['title'] .= "-Verification";
		$this->data['content'] = "verification";
		
		$u = $this->input->get('user');
		$c = $this->input->get('code');
				
		//verify url supplying code & see that supplying code matches with the code saved in user account
		if(empty($u) || empty($c) || (strlen($u) <5 || strlen($u)>12) || (strlen($c) != 40) || ($this->account_model->get_account_details('active',$u,'user') != $c))
		{
			//check if user account is already verified
			if($this->account_model->get_account_details('active',$u,'user') == 1)
			{
				$this->data['verifyMsg'] = '<p class="already">Your account is already verified.</p>';
			}
			else
			{
				$this->data['verifyMsg'] ='<p class="wrong">Wrong verification credentials.Your account is not verified.</p>';
				
			}
		}
		else
		{
			//activate the user account
			if($this->account_model->update_active($u,TRUE) == TRUE)
			{
				$this->data['verifyMsg'] = '<p class="success">Your account has been verified succesfully! You may now '.anchor('login', 'Login', 'title="Login"').'</p>';
				
			

			}
			else
			{
				$this->data['verifyMsg'] = "Account could not be verified right now.";
			}
		}
		
		$this->load->view('templates/non-signedin-layout',$this->data);
	}
/**	
 * reset forgot password
 *
 * this function generates a temporary password & send to user email
 * check if given email exists
 * generate temporary password
 * update user account with new temporary password
 * send email containging new password
 *
*/
	public function forget_password()
	{
		$this->data['title'] .= "- Forgot Password";
		$this->data['content'] = "forgot-password";		
		
		$this->_email = $this->input->post('email-id');
		$this->form_validation->set_rules('email-id','Email Address','required|valid_email|callback_if_email_exists');
		$this->form_validation->set_message('if_email_exists', 'Email does not exist');
		
		if($this->form_validation->run() == FALSE)
		{
		}
		else
		{
			$user = $this->account_model->get_account_details('id',$this->_email,'email');
			
			//generate a temporary password
			$tempPass = substr ( sha1(uniqid(rand(),true)), 3, 10);
			
			//update user account & send email
			if($this->account_model->reset_pass($user,$tempPass) == TRUE)
			{
				//send email
				$to = $this->_email;
				$subject = "New Password";				
				$msg = "This is your temporary password. ".$tempPass."\n You may change the password after signing in";
				
				$this->myemail->send_email($to,$subject,$msg);
				
				$this->session->set_flashdata('status','<p class="success">A new password is sent to your email address.</p>');
			}
			else
			{
				$this->session->set_flashdata('status','Password could not be reset right now');
			}		
		}
			
		$this->load->view('templates/non-signedin-layout',$this->data);
	}
/**	
 * email exists 
 *
 * this function checks if given an email exists in system
 *
*/
	public function if_email_exists()
	{
		return $this->account_model->email_exists($this->_email);
	}
	
	public function unverified_user()
	{
		//if user is not logged-in or is already verified, redirect it to home
		if($this->account_model->is_logged_in() == FALSE || $this->account_model->is_verified() == TRUE)
		{
			redirect(base_url());
		}
		
		$this->data['title'] .= "- Unverified Account";
		$this->data['content'] = "unverified";
		$this->data['unverified'] = TRUE;
		
		$this->data['user'] = $this->profile_model->get_profile_details('name');
		
		$this->load->view('templates/non-signedin-layout',$this->data);
	}
	public function blocked_user()
	{
		
		
	}
	
	
}
/* End of file account.php */ 
/* Location: application/controllers/account/account.php */