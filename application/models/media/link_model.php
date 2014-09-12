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

	class Link_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function create_link($link_data)
		{
			$data = $link_data;
			
			if($this->db->insert('link',$data))
			{
				//return video id
				$linkid = $this->db->insert_id();
				return $linkid;
			}
			else
			{
				return FALSE;
			}
		}
		public function get_link($id)
		{			
			$query = $this->db->get_where('link',array('link_id'=>$id));
			
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$result = $query->row_array();
			
			return $result['link_link'];
		}	
	}