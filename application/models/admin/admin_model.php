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

	class Admin_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			
		}
		public function service_settings($s,$st)
		{
			$this->db->where('service_name',$s);
			$this->db->update('service_status',array('service_status'=>$st));
		}
		public function del_admin($aid)
		{
			return $this->db->delete('admin',array('admin_id'=>$aid));
		}
		public function get_stats()
		{
			$stats = array();
			
			$users = $this->db->count_all('user');
			$posts =  $this->db->count_all('post');
			$groups = $this->db->count_all('group');
			$photos = $this->db->count_all('photo');
			$files = $this->db->count_all('file');
			$videos = $this->db->count_all('video');
			
			$stats = array('users'=>$users,'posts'=>$posts,'groups'=>$groups,'photos'=>$photos,'files'=>$files,'videos'=>$videos);
			
			return $stats;
		}
		public function get_status()
		{
			$query = $this->db->get('service_status');
			
			$result = $query->result_array();
			
			return $result;
		}
		public function get_users()
		{
			$this->db->select('user_id');
			$query = $this->db->get('admin');
			$admins = $query->result_array();
			
			$list = array();
			
			foreach($admins as $a)
			{
				$list[] = $a['user_id'];
			}
			
			
			//$this->db->where('user_id !=',$this->session->userdata('userid'));
			$this->db->where_not_in('user_id',$list);
			$query = $this->db->get('user');
		
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$result = $query->result_array();
			
			$this->load->model('profile/profile_model');
			$this->load->library('datelib');
			
			for($i=0; $i<count($result); $i++)
			{
				$result[$i]['display_name'] = $this->profile_model->get_profile_details('name',$result[$i]['user_id']);

				
				//$last_active = $this->profile_model->get_profile_details('last_active',$result[$i]['user_id']);
				
				//$result[$i]['last_active_time'] = $this->datelib->get_timespan($last_active);				
				$result[$i]['date_registered'] = $this->datelib->get_timespan($result[$i]['date_registered']);
			}
			
			return $result;
		}
		public function get_admins()
		{
			$this->db->where('user_id !=',$this->session->userdata('userid'));
			$query = $this->db->get('admin');
			
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$result = $query->result_array();
			
			$this->load->model('profile/profile_model');
			$this->load->model('account/account_model');
			$this->load->library('datelib');
			
			for($i=0; $i<count($result); $i++)
			{
				$result[$i]['display_name'] = $this->profile_model->get_profile_details('name',$result[$i]['user_id']);
				$result[$i]['user_name'] = $this->profile_model->get_profile_details('user',$result[$i]['user_id']);
				$result[$i]['user_email'] = $this->account_model->get_account_details('email',$result[$i]['user_id']);

				
				//$last_active = $this->profile_model->get_profile_details('last_active',$result[$i]['user_id']);
				
				//$result[$i]['last_active_time'] = $this->datelib->get_timespan($last_active);				
				$result[$i]['date_registered'] = $this->datelib->get_timespan($result[$i]['date_created']);
			}
			
			return $result;
			
		}
		public function add_admin($id)
		{
			$query = $this->db->get_where('admin',array('user_id'=>$id));
			
			if($query->num_rows() > 0)
			{
				return FALSE;
			}
			
			return $this->db->insert('admin',array('user_id'=>$id,'super_admin'=>0));
		}
	}