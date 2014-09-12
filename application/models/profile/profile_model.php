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

	class Profile_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->load->model('profile/personal_profile_model');
			$this->load->model('media/photo_model');
			//$this->load->model('account/account_model');			
		}
		
		public function create($profile_data)
		{
			//create a new profile photo for user
			$photo_data = array('user_id'=>$profile_data['id'],'photo_name'=>'default.jpg');
			$photo_id = $this->photo_model->create($photo_data);
			
			$data = array('user_id'=>"{$profile_data['id']}",'display_name'=>"{$profile_data['display']}",'photo'=>"{$photo_id}");
			if($this->db->insert('profile',$data))
			{
				//id of newly created profile
				$profile_id = $this->db->insert_id();
				//create education profile for user
				//$this->personal_profile_model->create($profile_id);
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		public function get_basic_detail($uid = FALSE)
		{
			if($uid == FALSE)
			{
				$uid = $this->session->userdata('userid');
			}
			
			$detail = $this->get_profile_details('all',$uid);
			
			$detail = array('user_id'=>$uid,'user_name'=>$detail['user_name'],'display_name'=>$detail['display_name'],'photo'=>$detail['photo']);
			
			return $detail;
		}
		public function update_profile($data)
		{
			$id = $this->session->userdata('userid');
			
			if($this->db->update('profile', $data, "user_id = $id"))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
			//$this->db->where('id', $id);
			//$this->db->update('profile', $data); 
		}
		public function new_photo_name()
		{
			$this->db->select_max('photo_id');
			$query = $this->db->get('photo');
			$r = $query->row();
			
			$id = $r->photo_id;
			return ++$id;
		}
		public function get_profile_details($args = 'all',$uid = FALSE)
		{			
			$query = $this->db->get_where('profile',array('user_id'=>$this->session->userdata('userid')));
			
			//get user name using account model
			$this->load->model('account/account_model');			
			$user_name = $this->account_model->get_account_details('name',$this->session->userdata('userid'),'user_id');
			
			if($uid != FALSE)
			{
				$query = $this->db->get_where('profile',array('user_id'=>$uid));
				$user_name = $this->account_model->get_account_details('name',$uid,'user_id');
			}
			
			$result = $query->row_array();
			
			//replace photo id with photo name
			$result['photo'] = $this->photo_model->get_photo_details('name',$result['photo']);
			$result['user_name'] = $user_name;
			
			switch($args)
			{
				case 'all':
					return $result;
					break;
				case 'id':
					return $result['profile_id'];
					break;
				case 'name':
					return $result['display_name'];
					break;
				case 'dob':
					return $result['dob'];
					break;
				case 'photo':
					return $result['photo'];
					break;
				case 'user':
					return $result['user_name'];
					break;
				case 'last_active':
					return $result['last_active_time'];
					break;
				default:
					return $result;
				break;
			}
			
		}
		public function get_fellowers($id)
		{
			$this->db->select('fellower_id');
			$query = $this->db->get_where('fellows',array('user_id'=>$id));
			if ($query->num_rows() > 0)
			{			
				$result = $query->result_array();
				return $result;
			}
			else
			{
				return FALSE;
			}
		}
		public function get_follows($id)
		{
			$this->db->select('user_id');
			$query = $this->db->get_where('fellows',array('fellower_id'=>$id));
			if ($query->num_rows() > 0)
			{			
				$result = $query->result_array();
				return $result;
			}
			else
			{
				return FALSE;
			}
		}
		public function make_fellow($to_follow,$fellower)
		{
			$data = array('user_id'=>$to_follow,'fellower_id'=>$fellower);
			if($this->db->insert('fellows',$data))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		public function is_following($to_follow,$fellower)
		{
			$this->db->where('user_id', $to_follow);
			$this->db->where('fellower_id', $fellower);
			
			$query = $this->db->get('fellows');
			
			if ($query->num_rows() > 0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		public function delete_user_fellows($uid)
		{
			$this->db->where('user_id =', $uid);
			$this->db->or_where('fellower_id =', $uid); 
			return $this->db->delete('fellows');
		}
		public function search_members($q)
		{
			$this->db->like('display_name', $q); 
			$query = $this->db->get('profile');
			
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$result = $query->result_array();
			
			$members = array();
			foreach($result as $r)
			{
				$members[] = $this->get_basic_detail($r['user_id']);
			}
			
			return $members;
		}
		public function get_all_members($search = FALSE)
		{
			$uid = $this->session->userdata('userid');
			
			$this->db->select('user_id,user_name');
			$this->db->where('user_id !=', $uid);
			$query = $this->db->get('user');
			
			
			$result = $query->result_array();
			
			$members = array();
			
			foreach($result as $r)
			{
				$display_name = $this->get_profile_details('name',$r['user_id']);
				//echo $r['user_id'];
				$members[$display_name] = $r['user_id'];
				
				if($search != FALSE)
				{					
					$members[$display_name] = $r['user_name'];				
				}
			}
			
			
			return $members;
		}
		public function delete_profile($uid)
		{
			$pid = $this->get_profile_details('id',$uid);
			
			$this->db->delete('profile',array('user_id'=>$uid));
			$this->delete_user_fellows($uid);
			$this->personal_profile_model->delete_edu_profile($pid);
		}
		public function get_top_members()
		{
			$this->db->select('user_id');
			$query = $this->db->get('user');
		
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
		
			$users = $query->result_array();
		
			$tops = array();
			foreach($users as $user)
			{
				$this->db->select('post_id');
				$query = $this->db->get_where('post',array('poster'=>$user['user_id']));
			
				$tops[$user['user_id']] = $query->num_rows();
			}
			arsort($tops);
		//var_dump($tops);
			$top_users = array();
		
			$i=1;
			foreach($tops as $key=>$value)
			{
				if($i > 5)
				{
					break;
				}
			
				$top_users[] = $this->get_basic_detail($key);
			
				$i++;
			}
		
			return $top_users;
		}
	}