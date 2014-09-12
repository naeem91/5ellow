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

	class Video_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		
		public function create($video_data)
		{
			$data = $video_data;
			
			if($this->db->insert('video',$data))
			{
				//return video id
				$videoid = $this->db->insert_id();
				return $videoid;
			}
			else
			{
				return FALSE;
			}
		}
		
		public function delete_video($video_id)
		{
			return $this->db->delete('video',array('video_id'=>$video_id));
		}
		public function get_all_videos($uid)
		{
			$this->db->order_by("video_id", "desc");
			$query = $this->db->get_where('video',array('user_id'=>$uid));
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			$result = $query->result_array();
			
			return $result;
		}
		public function get_video_details($args,$id)
		{			
			$query = $this->db->get_where('video',array('video_id'=>$id));
			
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$result = $query->row_array();
			
			switch($args)
			{
				case 'name':
					return $result['video_link'];
					break;
				case 'id':
					return $result['video_id'];
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