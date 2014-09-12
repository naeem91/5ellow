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

	class Personal_Profile_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function create($profile_id)
		{
			//create school,college,uni record for new user
			$this->db->insert('education_profile',array('profile_id'=>"{$profile_id}",'institute_type'=>"school"));
			$this->db->insert('education_profile',array('profile_id'=>"{$profile_id}",'institute_type'=>"college"));
			$this->db->insert('education_profile',array('profile_id'=>"{$profile_id}",'institute_type'=>"uni"));								
		}
		public function get_details($args,$profile_id = FALSE)
		{
			if($profile_id == FALSE)
			{
				//if profile_id not supplied, get if from session data
				$profile_id = $this->session->userdata('profileid');
			}
						
			switch($args)
			{
				case 'education':
					return $this->get_education_details($profile_id);
					break;
				case 'interests':
					return $this->get_interests($profile_id);
					break;
				case 'jobs':
					return $this->get_job_details($profile_id);
					break;
				default:
					return NULL;
				break;
			}
		}
		private function get_education_details($profile_id)
		{
			$this->db->order_by("completion_year", "asc"); 
			$query = $this->db->get_where('education_profile',array('profile_id'=>"{$profile_id}"));
			if ($query->num_rows() <= 0)
			{
				return FALSE;
			}
			$result = $query->result_array();
			return $result;
		}
		
		public function insert_education($edu_data)
		{
			$data = $edu_data;
			$this->db->insert('education_profile',$data);
			$edu_id = $this->db->insert_id();
			
			return $edu_id;
		}
		public function remove_education($id)
		{
			return $this->db->delete('education_profile', array('edu_id' => $id)); 
		}
		public function update_education($edu_data,$id)
		{
			if($this->db->update('education_profile',$edu_data,"edu_id = $id"))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		public function delete_edu_profile($pid)
		{
			return $this->db->delete('education_profile',array('profile_id'=>$pid));
		}
	}