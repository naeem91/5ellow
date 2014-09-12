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

	class Group_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function create_group($data)
		{
			$query = $this->db->insert('group',$data);
			
			$id = $this->db->insert_id();
			
			return $id;
		}
		public function update_group($gid,$data)
		{
			$this->db->where('group_id', $gid);
			return $this->db->update('group',$data);
		}
		public function get_top_groups()
		{
			$this->db->select('group_id');
			$query = $this->db->get('group');
		
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
		
			$groups = $query->result_array();
		
			$tops = array();
			foreach($groups as $group)
			{
				$this->db->select('post_id');
				$query = $this->db->get_where('post',array('posted_in'=>$group['group_id']));
			
				$tops[$group['group_id']] = $query->num_rows();
			}	
			arsort($tops);
			//var_dump($tops);
			$top_groups = array();
			
			$i=1;
			foreach($tops as $key=>$value)
			{
				if($i > 5)
				{
					break;
				}
			
				$top_groups[] = $this->get_group_info('all',$key);
			
				$i++;
			}
			
			return $top_groups;
		}
		public function get_group_members($gid)
		{
			$this->db->select('user_id');
			$query = $this->db->get_where('group_members',array('group_id'=>$gid));
			
			$member_ids = $query->result_array();
			
			$this->load->model('profile/profile_model');
			
			$members = array();
			
			foreach($member_ids as $mid)
			{
				$members[] = $this->profile_model->get_basic_detail($mid['user_id']);
				//$members[] = $mid['user_id'];
			}
			
			return $members;
			
		}
		public function delete_member($gid,$uid)
		{
			return $this->db->delete('group_members',array('group_id'=>$gid,'user_id'=>$uid));
		}
		public function delete_from_all_groups($uid)
		{
			return $this->db->delete('group_members',array('user_id'=>$uid));

		}
		public function get_group_photos($gid)
		{
			$query = $this->db->get_where('photo',array('uploaded_in'=>$gid));
			
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$photos = $query->result_array();
			
			return $photos;
		}
		public function get_group_files($gid)
		{
			$query = $this->db->get_where('file',array('uploaded_in'=>$gid));
			
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$files = $query->result_array();
			
			return $files;
		}
		public function get_group_videos($gid)
		{
			$query = $this->db->get_where('video',array('uploaded_in'=>$gid));
			
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$videos = $query->result_array();
			
			return $videos;
		}
		public function get_group_info($arg,$key,$key_type = FALSE)
		{
			$result = null;
			$primary = 'group_id';
			
			if($key_type != FALSE)
			{
				if($key_type == 'name')
				{
					$primary = 'group_name';
				}
			}
			
			$query = $this->db->get_where('group',array($primary=>$key));
						
			//if nothing found return NULL
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$r = $query->row_array();
			$this->load->model('media/photo_model');
			$r['group_cover'] = $this->photo_model->get_photo_details('name',$r['group_cover']);
			
			switch($arg)
			{
				case 'all':
					$result = $r;
					break;
				case 'id':
					$result = $r['group_id'];
					break;
				case 'name':
					$result = $r['group_name'];
					break;
				case 'display':
					$result = $r['group_display_name'];
					break;
				default:
						break;		
			}	
			
			return $result;
		}
		public function is_member($gid,$uid)
		{
			$query = $this->db->get_where('group_members',array('group_id'=>$gid,'user_id'=>$uid));
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			return TRUE;
		}
		public function is_admin($gid,$uid)
		{
			$query = $this->db->get_where('group',array('group_id'=>$gid,'group_creator'=>$uid));
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			return TRUE;
		}
		public function make_member($group,$id)
		{
			
			return $this->db->insert('group_members',array('group_id'=>$group,'user_id'=>$id));
		}
		public function custom_search($q)
		{
			$this->db->like('group_display_name', $q); 
			$query = $this->db->get('group');
			
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$result = $query->result_array();
			
			return $result;
		}
		public function group_search()
		{
			//$this->db->select('group_display_name,group_name');
			$query = $this->db->get('group');
			
			$result = $query->result_array();
			
			
			$groups = array();
			
			foreach($result as $r)
			{
				//$display_name = $this->get_profile_details('name',$r['user_id']);
				//echo $r['user_id'];
				$display = $r['group_display_name'];
			
				$groups[$display] = $r['group_name'];
				$groups['type'] = 'group';
				
			}
			
			
			return $groups;
		}
		public function get_all_groups()
		{
			$uid = $this->session->userdata('userid');
			$query = $this->db->get_where('group_members',array('user_id'=>$uid));
			
			$groups = array();
			if($query->num_rows < 1)
			{
				return FALSE;
			}
			
			$result = $query->result_array();
			
			foreach($result as $r)
			{
				$this->db->select('group_id,group_name,group_display_name');
				$query = $this->db->get_where('group',array('group_id'=>$r['group_id']));	
				
				$groups[] = $query->row_array();
			}
			
			return $groups;
			
		}
	}