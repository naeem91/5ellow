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

	class Photo_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			
			
		}
		
		public function create($photo_data)
		{
			$data = $photo_data;
			
			if($this->db->insert('photo',$data))
			{
				//return photo id
				$photoid = $this->db->insert_id();
				return $photoid;
			}
			else
			{
				return FALSE;
			}
		}
		public function delete_photo($photo_id)
		{
			return $this->db->delete('photo',array('photo_id'=>$photo_id));
		}
		public function get_all_photos($uid)
		{
			$this->load->model('profile/profile_model');
			
			$p_photo = $this->profile_model->get_profile_details('photo',$uid);
			
			$this->db->order_by('photo_id','desc'); 
			$this->db->where('user_id', $uid);
			$this->db->where('photo_name !=', $p_photo);
			$query = $this->db->get('photo');
			//$query = $this->db->get_where('photo',array('user_id'=>$uid));
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			$result = $query->result_array();
			
			return $result;
		}
		public function get_photo_details($args,$id)
		{	
					
			$query = $this->db->get_where('photo',array('photo_id'=>$id));
			
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$result = $query->row_array();
			
			switch($args)
			{
				case 'name':
					return $result['photo_name'];
					break;
				case 'id':
					return $result['photo_id'];
					break;
				case 'uploader':
					return $result['user_id'];
					break;
				default:
					return $result;
				break;
			}
			
		}
	}