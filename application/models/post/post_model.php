<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Post_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('profile/profile_model');
		}
		public function new_post($post_data,$uid= FALSE)
		{
			if($this->db->insert('post',$post_data))
			{
				$id = $this->db->insert_id();
				return $id;
			}
			else
			{
				return FALSE;
			}
		}
		
		public function get_post($args='all',$post_id)
		{
			$query = $this->db->get_where('post',array('post_id'=>$post_id)); 
			$result = $query->row_array();
			
			switch($args)
			{
				case 'all':
					return $result;
					break;
				case 'time':
					return $result['post_time'];
					break;
				case 'post':
					return $result['post_text'];
					break;
				case 'poster':
					return $result['poster'];
					break;
				default:
					break;
			}
		}
		public function delete_post($id)
		{
			if($this->db->delete('post',array('post_id'=>$id)))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		public function delete_user_posts($uid)
		{
			return $this->db->delete('post',array('poster'=>$uid));
		}
		public function delete_comment($id)
		{
			if($this->db->delete('comment',array('comment_id'=>$id)))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		public function delete_user_comments($uid)
		{
			return $this->db->delete('comment',array('commenter'=>$uid));
		}
		public function new_comment($comment_data,$uid= FALSE)
		{
			if($this->db->insert('comment',$comment_data))
			{
				$id = $this->db->insert_id();
				return $id;
			}
			else
			{
				return FALSE;
			}
		}
		public function get_post_comments($post_id)
		{
			$this->db->order_by("comment_time", "asc");
			$query = $this->db->get_where('comment',array('post_id'=>$post_id));
			
			//if no comments on post, return FALSE
			if($query->num_rows() <= 0)
			{
				return FALSE;	
			}
			
			$result = $query->result_array();
			
			return $result;
		}
		public function get_comment($args='all',$comment_id)
		{
			$query = $this->db->get_where('comment',array('comment_id'=>$comment_id)); 
			$result = $query->row_array();
			
			switch($args)
			{
				case 'all':
					return $result;
					break;
				case 'time':
					return $result['comment_time'];
					break;
				default:
					break;
			}
		}
		public function get_latest_post()
		{
			$this->db->select_max('post_id');
			$query = $this->db->get('post');
			
			$result = $query->row_array();
			
			return $result['post_id'];
		}
		public function get_latest_comment()
		{
			$this->db->select_max('comment_id');
			$query = $this->db->get('comment');
			
			$result = $query->row_array();
			
			return $result['comment_id'];
		}
		public function uploading_status()
		{
			$query = $this->db->get_where('service_status',array('service_name'=>'uploading'));
			
			$result = $query->row_array();
			
			if($result['service_status'] == TRUE)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		public function get_post_likes($post_id)
		{
			$query = $this->db->get_where('like',array('post_id'=>$post_id));
			
			$num_likes = $query->num_rows();
			
			if($num_likes < 1)
			{
				return FALSE;
			}
			
			return $num_likes;
		}
		public function can_like($post_id)
		{
			$uid = $this->session->userdata('userid');
			
			$query = $this->db->get_where('like',array('post_id'=>$post_id,'liker'=>$uid));
			
			if($query->num_rows() > 0)
			{
				return FALSE;
			}
			
			return TRUE;
		}
		public function new_like($data)
		{
			return $this->db->insert('like',$data);
		}
		public function get_likers_details($post)
		{
			$this->db->select('liker');
			$query = $this->db->get_where('like',array('post_id'=>$post));
			
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$result = $query->result_array();
			
			$likers = array();
			
			foreach($result as $r)
			{
				$likers[] = $this->profile_model->get_basic_detail($r['liker']);
			}
			
			return $likers;
		}
	}