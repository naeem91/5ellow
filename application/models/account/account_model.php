<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Model Name: Account_Model 
* Corresponds to: user table
*
* Methods:
* - create account
* - login check 
* - make user login
* - reset password
* - update active key
* - retreiving user account details
* 
* Last Updated: August 4,2012 
*/

	class Account_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			
			//$this->load->database();
			
			$this->load->model('profile/profile_model');
			
			//this salt is used in hashing passwords
			$this->_salt = "123456789987654321";
		}
/**
 * Create new user
 *
 * This function creates a new user in user table by receiving values from account model. 
 *
 * @param   array	   userdata(username,email,password,activation code)
 * @return  boolean    TRUE/FALSE
 */
		public function create($userData)
		{
			
			
			$data = array('user_email'=>"{$userData['email']}",'user_pass'=>"{$userData['password']}",'active'=>"{$userData['code']}");
			
			$data['user_pass'] = $this->_make_pass($data['user_pass']);
			
			if($this->db->insert('user', $data))
			{
				
				$profile_data['display'] = $userData['name'];
				$profile_data['id'] = $this->get_account_details('id',$userData['email'],'email');
				
				//create new profile for user and set data
				$this->profile_model->create($profile_data);

				//generate a user name and store it, by concatinating user id with a number
				$u_name = '106617'.$profile_data['id'];
				$data = array('user_name' => $u_name);

				$this->db->where('user_id', $profile_data['id']);
				$this->db->update('user', $data); 
				
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
/**
 * Check login credentials
 *
 * This function check user login credentials. 
 *
 * @param   string     username
 * @param	string 	   password
 * @return  boolean    TRUE/FALSE
 */

		public function login_check($email,$pass)
		{
			$pass = $this->_make_pass($pass);
			
			$query = $this->db->get_where('user',array('user_email'=>$email));
			$result = $query->row_array();
			if($query->num_rows() > 0)
			{
				if($result['user_pass'] == $pass)
				{
					return TRUE;
				}
			}		
			return FALSE;
		}
/**
 * login
 *
 * This function makes a user login by setting sessions. 
 *
 * @param   string     username
 * @return  boolean    TRUE/FALSE
 */

		public function login($email)
		{
			$uid = $this->get_account_details('id',$email,'email');
			$pid = $this->profile_model->get_profile_details('id',$uid);
			//set sessions to make login
			$data = array('userid' => $uid,'profileid'=>$pid,'logged_in' => TRUE);
			
			if($this->is_admin($uid) == TRUE)
			{
				$data['admin'] = TRUE;
				
				if($this->is_super_admin($uid) == TRUE)
				{
					$data['super_admin'] = TRUE;	
				}
			}
			
			$this->session->set_userdata($data);
		}
		
		public function is_admin($uid)
		{
			$query = $this->db->get_where('admin',array('user_id'=>$uid));
			
			if($query->num_rows() > 0)
			{
				return TRUE;
			}
			
			return FALSE;
		}
		public function is_super_admin($uid)
		{
			$query = $this->db->get_where('admin',array('user_id'=>$uid,'super_admin'=>'1'));
			
			if($query->num_rows() > 0)
			{
				return TRUE;
			}
			
			return FALSE;
		}
		public function is_banned($email)
		{
			$query = $this->db->get_where('user',array('user_email'=>$email,'banned'=>1));
			
			if($query->num_rows() > 0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
/**
 * is login
 *
 * This function checks if a user is logged-in or not by checking sessions. 
 *
 * @return  boolean    TRUE/FALSE
 */
		public function is_logged_in()
		{
			if($this->session->userdata('logged_in') == TRUE)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
/**
 * reset password
 *
 * This function updates user password. 
 *
 * @param   string     username
 * @param   string	   password
 * @return  boolean    TRUE/FALSE
 */
		public function reset_pass($key,$pass)
		{
			$pass = $this->_make_pass($pass);
			
			$this->db->where('user_id', $key);
			if($this->db->update('user',array('user_pass'=>$pass)))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}	
		}
/**
 * update activation code
 *
 * This function updates a user's activation code. 
 *
 * @param   string     username
 * @param   string	   activation code
 * @return  boolean    TRUE/FALSE
 */
		public function update_active($key,$code)
		{
			if($this->db->update('user',array('active'=>$code),"user_name = '$key'"))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
/**
 * make hashed passwords
 *
 * This function makes hashed passwords. 
 *
 * @param   string     passwords
 * @return  string     hashed password
 */
		private function _make_pass($p)
		{
			//apply sha1 with salt on password
			return sha1($this->_salt.sha1($p));
		}
/**
 * email exists or not
 *
 * This function cheks if an email address exists in database. 
 *
 * @param   string     email
 * @return  boolean    TRUE/FALSE
 */
		public function email_exists($e)
		{
			$query = $this->db->get_where('user',array('user_email'=>$this->_email));
			if($query->num_rows() > 0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;	
			}
		}
/**
 * get user account details
 *
 * This function provides a user's account details. It takes two optional parameters key and key type. key
 * is the value by which database is retreived. key type is type of the key e.g, key is of type 'email'. 
 *
 * @param   string     argument(detail to retreive e.g. get_account_details('email')
 * @param	string	   key (username or email)
 * @param	string	   key type (email)
 * @return  string     value of an account element e.g email address
 */
 		public function get_account_details($args,$key = FALSE,$key_type = FALSE)
		{
			$result = null;
			$primary = 'user_id';
			if($key == FALSE)
			{
				$key = $this->session->userdata('userid');
			}
			else
			{
				if($key_type == 'email')
					$primary = 'user_email';
				
				if($key_type == 'user')
					$primary = 'user_name';
			}
			$query = $this->db->get_where('user',array($primary=>$key));
			$r = $query->row_array();
			
			//if nothing found return NULL
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			switch($args)
			{
				case 'id':
					$result = $r['user_id'];
					break;
				case 'name':
					$result = $r['user_name'];
					break;
				case 'email':
					$result = $r['user_email'];	
					break;
				case 'password':
					$result = $r['user_pass'];	
					break;
				case 'active':
					$result = $r['active'];
					break;
				case 'all':
					$result = $r;
					break;
				default:
						break;		
			}	
			
			return $result;
		}
		
	public function change_username($uid,$new_name)
	{
		$data = array('user_name'=>$new_name);
		if($this->db->update('user',$data,"user_id = $uid") == TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function is_verified($uid = FALSE)
	{
		//if user id is not supplied, call function directly to use session data
		if($uid == FALSE)
		{
			$result = $this->get_account_details('active');
		}
		else
		{
			$result = $this->get_account_details('active',$uid,'id');
		}
		if($result == 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function update_login_status()
	{
		$this->db->where('user_id', $this->session->userdata('userid'));
		$this->db->update('profile',array('last_active_time'=>NOW()));
	}
	public function get_online_users()
	{
		$this->db->select('user_id');
		$this->db->where('last_active_time >', NOW()-60);
		$this->db->where('user_id !=', $this->session->userdata('userid'));
		$query = $this->db->get('profile');
		
		if($query->num_rows() == 0)
		{
			return FALSE;
		}
		
		$result = $query->result_array();
		$users = array();
		foreach($result as $r)
		{
			$display = $this->profile_model->get_profile_details('name',$r['user_id']);
			$name = $this->profile_model->get_profile_details('user',$r['user_id']);
			
			$users[] = array('name'=>$name,'display'=>$display);
			//$users[]['name'] = $r['user_name'];
			
		}
		
		return $users;
	}
	public function delete_user($uid)
	{
		//return $this->db->delete('user',array('user_id'=>$uid));
		if($this->db->delete('user',array('user_id'=>$uid)) == TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}
	public function ban_user($uid,$act)
	{
		if($act == 'ban')
		{
			$act = 1;
		}
		else
		{
			$act = 0;
		}
		$this->db->where('user_id',$uid);
		return $this->db->update('user',array('banned'=>$act));
	}
	
	public function check_service($serv)
	{
		if($serv == 'reg')
		{
			$this->db->select('service_status');
			$query = $this->db->get_where('service_status',array('service_name'=>'registration'));
			
			$result = $query->row_array();
			
			if($result['service_status'] == 1)
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
			$this->db->select('service_status');
			$query = $this->db->get_where('service_status',array('service_name'=>'uploading'));
			
			$result = $query->row_array();
			
			if($result['service_status'] == 1)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		
	}
}
	
/* End of file account_model.php */ 
/* Location: application/models/account/account_model.php */