<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Stream_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('porfile/profile_model');
			$this->load->model('post/post_model');
			$this->load->library('datelib');
		}

		
		public function get_public_stream($p = FALSE, $user = FALSE, $group = FALSE)
		{
			//if start not set
			//fetch 20 recent posts	
			$x = 20;
			if($p == FALSE)
			{
				
				$y = 0;
			}
			else
			{
			
				$y = $p * 20;
			}
			
			$this->db->order_by("post_time", "desc");
			$query = $this->db->get('post',$x,$y);	
			 
			if($user != FALSE)
			{
				$this->db->order_by("post_time", "desc");
				$query = $this->db->get_where('post',array('poster'=>$user),$x,$y);
			}
						
			if($group != FALSE)
			{
				$this->db->order_by("post_time", "desc");
				$query = $this->db->get_where('post',array('posted_in'=>$group),$x,$y);
			}
			//if no stream return FALSE
			if($query->num_rows() <= 0)
			{
				return FALSE;
			}
			
			$posts = $query->result_array();
			$final_posts = array();
						
			$poster_details = array();
			$comments = array();
			
			$commenter_details = array();
			
			$clean_posts = array();
			
			foreach($posts as $post)
			{
				//fetch profile details of each poster
				$poster_details[] = $this->profile_model->get_profile_details('all',$post['poster']);
				
				//get comments on each post
				$comment_on_post = $this->post_model->get_post_comments($post['post_id']);
				$post['comment_count'] = count($comment_on_post);
				if($comment_on_post != FALSE)
				{
					$comments[] = $comment_on_post; 
				}
				
				//save only necessay post details
				$post['post_time'] = $this->datelib->get_timespan($post['post_time']);
				
				
				if($post['attachment_id'] != '0')
				{
					switch($post['attachment_type'])
					{
						case 'photo':
							$this->load->model('media/photo_model');
							 $p = $this->photo_model->get_photo_details('name',$post['attachment_id']);
							 if($p == FALSE)
							 {
								 //if attachment is not availabe(deleted)
								 $post['attachment_type'] = 'deleted';
								  $post['attachment_id'] = 'deleted.jpg';
							 }
							else
							{
								 $post['attachment_id'] = $p;
							}
							break;
						case 'file':
							$this->load->model('media/file_model');
							$p = $this->file_model->get_file_details('name',$post['attachment_id']);
							if($p == FALSE)
							 {
								 //if attachment is not availabe(deleted)
								   $post['attachment_type'] = 'deleted';
								  $post['attachment_id'] = 'deleted.jpg';
							 }
							else
							{
								 $post['attachment_id'] = $p;
							}
							break;
						case 'video':
							$this->load->model('media/video_model');
							$p = $this->video_model->get_video_details('name',$post['attachment_id']);
							if($p == FALSE)
							 {
								  $post['attachment_type'] = 'deleted';
								  $post['attachment_id'] = 'deleted.jpg';
							 }
							else
							{
								 $post['attachment_id'] = $p;
							}
							break;
						case 'link':
							$this->load->model('media/link_model');
							$p = $this->link_model->get_link($post['attachment_id']);
							if($p == FALSE)
							 {
								  $post['attachment_type'] = 'deleted';
								  $post['attachment_id'] = 'deleted.jpg';
							 }
							else
							{
								 $post['attachment_id'] = $p;
							}
							break;
						default:
							break;
					}
				}
				
				$post['group_display'] = 0;
				$post['group_name'] = 0;
				
				if($post['posted_in'] != '0')
				{
					$this->load->model('group/group_model');
					$post['group_display'] = $this->group_model->get_group_info('display',$post['posted_in']);
					$post['group_name'] = $this->group_model->get_group_info('name',$post['posted_in']);
				}
				
				//get no. of likes on post
				$plikes = $this->post_model->get_post_likes($post['post_id']);
				//if current user can like it or not
				$canlike = $this->post_model->can_like($post['post_id']);
				
				$clean_posts[] = array('post'=>$post['post_text'],'post_time'=>$post['post_time'],'post_id'=>$post['post_id'],'attach_type'=>$post['attachment_type'],'attach_link'=>$post['attachment_id'],'posted_in'=>$post['posted_in'],'group_display'=>$post['group_display'],'group_name'=>$post['group_name'],'comment_count'=>$post['comment_count'],'like_count'=>$plikes,'can_like'=>$canlike);						
							
			}
			
			$clean_posters = array();
			
			foreach($poster_details as $poster)
			{
				//save only necessary poster details			
				$clean_posters[] = array('user_name'=>$poster['user_name'],'display_name'=>$poster['display_name'],'photo'=>$poster['photo']);
			}
			
			//merge posts with poster details as one array
			for($i=0; $i<count($clean_posts); $i++)
			{
				$final_posts["posts"][] = array_merge($clean_posts[$i],$clean_posters[$i]);
			}
			
			$c_comments = array();
	
			if(!empty($comments))
			{
				foreach($comments as $comment)
				{
					
					foreach($comment as $c)
					{
						//save only necessary comments details
						$c['comment_time'] = $this->datelib->get_timespan($c['comment_time']);
						
						$c_comments[] = array('comment'=>$c['comment_text'],'comment_id'=>$c['comment_id'],'comment_time'=>$c['comment_time'],'post_id'=>$c['post_id']);
					
						//get details of commenters
						$commenter_details[] = $this->profile_model->get_profile_details('all',$c['commenter']);
					}
				}
			}
			
			$c_c_details = array();
			
			$final_comments = array();
			
			foreach($commenter_details as $c_d)
			{
				//save only necessary info of commenters
				$c_c_details[] = array('user_name'=>$c_d['user_name'],'display_name'=>$c_d['display_name'],'photo'=>$c_d['photo']);
			}
			
			//merge comment details 
			for($i=0; $i<count($c_comments); $i++)
			{
				$final_posts["comments"][] = array_merge($c_comments[$i],$c_c_details[$i]);
			}
			
			return $final_posts;			
		}
		
		public function get_new_post($latest_id)
		{
			$this->db->select_max('post_id');
			$query = $this->db->get('post');
			if($query->num_rows() <= 0)
			{
				return FALSE;
			}
			
			$result = $query->row_array();
			if($result['post_id'] > $latest_id)
			{
				$query = $this->db->get_where('post',array('post_id'=>$result['post_id']));
				
				$post = $query->row_array();
				
				$poster = $this->profile_model->get_profile_details('all', $post['poster']);
				
				$post['post_time'] = $this->datelib->get_timespan($post['post_time']);
				
				if($post['attachment_id'] != 0)
				{
					switch($post['attachment_type'])
					{
						case 'photo':
							$this->load->model('media/photo_model');
							$post['attachment_id'] = $this->photo_model->get_photo_details('name',$post['attachment_id']);
							break;
						case 'file':
							$this->load->model('media/file_model');
							$post['attachment_id'] = $this->file_model->get_file_details('name',$post['attachment_id']);
							break;
						case 'video':
							$this->load->model('media/video_model');
							$post['attachment_id'] = $this->video_model->get_video_details('name',$post['attachment_id']);
							break;
						case 'link':
							$this->load->model('media/link_model');
							$post['attachment_id'] = $this->link_model->get_link($post['attachment_id']);
							break;
						default:
							break;
					}
				}
				
				$post['group_name'] = 0;
				$post['group_display'] = 0;
				
				if($post['posted_in'] != 0)
				{
					$this->load->model('group/group_model');
					$post['group_name'] = $this->group_model->get_group_info('name',$post['posted_in']);
					$post['group_display'] = $this->group_model->get_group_info('display',$post['posted_in']);
				}
				
				$post = array('post'=>$post['post_text'],'poster'=>$post['poster'],'post_time'=>$post['post_time'],'post_id'=>$post['post_id'],'attach_link'=>$post['attachment_id'],'attach_type'=>$post['attachment_type'],'posted_in'=>$post['posted_in'],'group_name'=>$post['group_name'],'group_display'=>$post['group_display']);	
				
				$poster = array('user_name'=>$poster['user_name'],'display_name'=>$poster['display_name'],'photo'=>$poster['photo']);
				
				 $final_post = array_merge($post,$poster);
				 
				 return $final_post;
			}
			else
			{
				return  FALSE;
			}
		}
		public function get_new_comment($latest_id)
		{
			$this->db->select_max('comment_id');
			$query = $this->db->get('comment');
			if($query->num_rows() <= 0)
			{
				return FALSE;
			}
			
			$result = $query->row_array();
			if($result['comment_id'] > $latest_id)
			{
				$query = $this->db->get_where('comment',array('comment_id'=>$result['comment_id']));
				
				$comment = $query->row_array();
				
				$commenter = $this->profile_model->get_profile_details('all', $comment['commenter']);
				
				$comment['orignal_time'] = $comment['comment_time'];
				$comment['comment_time'] = $this->datelib->get_timespan($comment['comment_time']);
				
				$post_user = $this->post_model->get_post('poster',$comment['post_id']);
				$post = $this->post_model->get_post('post',$comment['post_id']);
				$post_username = $this->profile_model->get_profile_details('user',$post_user);
				
				$comment = array('comment'=>$comment['comment_text'],'comment_time'=>$comment['comment_time'],'comment_id'=>$comment['comment_id'],'post_id'=>$comment['post_id'],'post_user'=>$post_user,'commenter'=>$comment['commenter'],'post'=>$post,'post_username'=>$post_username,'orignal_time'=>$comment['orignal_time']);	
				
				$commenter = array('user_name'=>$commenter['user_name'],'display_name'=>$commenter['display_name'],'photo'=>$commenter['photo']);
				
				 $final_comment = array_merge($comment,$commenter);
				 
				 return $final_comment;
			}
			else
			{
				return  FALSE;
			}
		}
	}