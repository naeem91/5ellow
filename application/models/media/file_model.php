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

	class File_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		
		public function create($file_data)
		{
			$data = $file_data;
			
			if($this->db->insert('file',$data))
			{
				//return photo id
				$fileid = $this->db->insert_id();
				return $fileid;
			}
			else
			{
				return FALSE;
			}
		}
		public function delete_file($file_id)
		{
			return $this->db->delete('file',array('file_id'=>$file_id));
		}
		public function get_all_files($uid)
		{
			$this->db->order_by("file_id", "desc");
			$query = $this->db->get_where('file',array('user_id'=>$uid));
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			$result = $query->result_array();
			
			return $result;
		}
		public function get_file_details($args,$id)
		{			
			$query = $this->db->get_where('file',array('file_id'=>$id));
			
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$result = $query->row_array();
			
			switch($args)
			{
				case 'name':
					return $result['file_name'];
					break;
				case 'id':
					return $result['file_id'];
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