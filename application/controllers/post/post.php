<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Post extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->load->model('account/account_model');
			$this->load->model('post/post_model');
			$this->load->model('media/photo_model');
			$this->load->model('media/file_model');
			$this->load->model('media/video_model');
			$this->load->model('media/link_model');
			
			$this->load->library('datelib');
			$this->load->library('uploading');
			//if logged-in redirect to community
			if($this->account_model->is_logged_in() == FALSE)
			{
				redirect(base_url().'community');
			}
			if($this->account_model->is_verified() == FALSE)
			{
				//redirect to unverified account page				
				redirect(base_url());
			}
			
			//set userid of logged-in user
			$this->uid = $this->session->userdata('userid');
		}
		
		public function do_post()
		{
			$post = $this->input->post('post-data');
			
			$post_data = array('post_text'=>$post,'poster'=>$this->uid);

			$iserror = FALSE;
			$error = array();
			$id = NULL;
			$name = NULL;
			$in = FALSE;
			
			//check if post is made in a group
			$group_id = $this->input->post('group-id');
			if(!empty($group_id))
			{
				$post_data['posted_in'] = $group_id;
				$in = $group_id;
			}
			
			//check if a file is attached
			if(isset($_FILES['userfile']['name']))
			{				
				$file = $this->input->post('userfile');
				$file_name = $_FILES['userfile']['name'];
				$file_type = $_FILES['userfile']['type'];
				
				if($file_type == "image/png" || $file_type == "image/jpeg" || $file_type == "image/gif")
				{
					//attachment is a photo
					$isUploaded = $this->uploading->photo_upload($file,$file_name);
					if($isUploaded == 'uploaded')
					{
						//if photo upload succesfull, save its record in database
						$photo_data['user_id'] = $this->session->userdata('userid');
						$photo_data['photo_name'] = $file_name;
						
						if($in != FALSE)
						{
							$photo_data['uploaded_in'] = $in;
						}
						
						$photo_id = $this->photo_model->create($photo_data);
				
						//attach photo with post
						$post_data['attachment_type'] = 'photo';
						$post_data['attachment_id'] = $photo_id;
						
						$id = $photo_id;
						$name = $file_name;
					}
					else
					{
						$iserror = TRUE;
						$error = $isUploaded;
					}
				}
				
				else
				{
					//attachment is a file
					$isUploaded = $this->uploading->file_upload($file);
					if($isUploaded == 'uploaded')
					{
						//if photo upload succesfull, save its record in database
						$file_data['user_id'] = $this->session->userdata('userid');
						$file_data['file_name'] = $file_name;
						
						if($in != FALSE)
						{
							$file_data['uploaded_in'] = $in;
						}
						
						$file_id = $this->file_model->create($file_data);
				
						//attach photo with post
						$post_data['attachment_type'] = 'file';
						$post_data['attachment_id'] = $file_id;
						
						$id = $file_id;
						$name = $file_name;
					}
					else
					{
						$iserror = TRUE;
						$error = $isUploaded;
					}
							
				}
				
				//$this->uploading->photo_upload($photo,$pic_name);
			}
			
			//check if a video link is posted
			$vid_link = $this->input->post('video_link');
			if(!empty($vid_link))
			{
				$vid = $this->input->post('video_link');
				
				if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $vid))
				{
					$video_data['user_id'] = $this->session->userdata('userid');
					$video_data['video_link'] = $vid;
					
					if($in != FALSE)
					{
						$video_data['uploaded_in'] = $in;
					}
					
					$video_id = $this->video_model->create($video_data);
					
					//attach video with post
					$post_data['attachment_type'] = 'video';
					$post_data['attachment_id'] = $video_id;
					
					$id = $video_id;
				}
				else
				{
					$iserror = TRUE;
					$error['error'] = "URL for video is not valid";
				}
			}
			$link = $this->input->post('link_link');
			if(!empty($link))
			{
				$link = $this->input->post('link_link');
				
				if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $link))
				{
					//$link_data['user_id'] = $this->session->userdata('userid');
					$link_data = array();
					$link_data['link_link'] = $link;
					
					
					
					$link_id = $this->link_model->create_link($link_data);
					
					//attach video with post
					$post_data['attachment_type'] = 'link';
					$post_data['attachment_id'] = $link_id;
					
					$id = $link_id;
				}
				else
				{
					$iserror = TRUE;
					$error['error'] = "URL for link is not valid";
				}
			}
			if($iserror == TRUE)
			{
				$error['is_error'] = $iserror;
				echo json_encode($error);
				return;
			}
			
			$result = $this->post_model->new_post($post_data);
			if($result != FALSE)
			{
				//return post id
				$data = array('is_error'=>$iserror,'id'=>$id,'name'=>$name);
				echo json_encode($data);
				/*$post_time = $this->post_model->get_post('time',$result);
				$post_time = $this->datelib->get_timespan($post_time);
				
				$data = array('id'=>$result,'time'=>$post_time);
				echo json_encode($data);*/ 
			}
			
		}
		
		
		public function del_post()
		{
			$post_id = $this->input->post('data');
			if($this->post_model->delete_post($post_id) == TRUE)
			{
				echo TRUE;
			}
			else
			{
				echo FALSE;
			}
		}
		public function do_comment()
		{
			$comment = $this->input->post('data');
		
			$post_id = $this->input->post('id');
			
			$comment_data = array('comment_text'=>$comment,'commenter'=>$this->uid,'post_id'=>$post_id);
			
			$result = $this->post_model->new_comment($comment_data);
			if($result != FALSE)
			{
				$comment_time = $this->post_model->get_comment('time',$result);
				$comment_time = $this->datelib->get_timespan($comment_time);
				
				echo $comment_time; 
			}
			else
			{
				echo FALSE;
			}
		}
		public function del_comment()
		{
			$comment_id = $this->input->post('data');
			if($this->post_model->delete_comment($comment_id) == TRUE)
			{
				echo TRUE;
			}
			else
			{
				echo FALSE;
			}
		}
		public function like_post()
		{
			$uid = $this->input->post('uid');
			$post = $this->input->post('post');
			
			$data = array('post_id'=>$post,'liker'=>$uid);
			
			return $this->post_model->new_like($data);
		}
		public function get_likers()
		{
			$post = $this->input->post('post');
			
			$likers = $this->post_model->get_likers_details($post);
			
			echo json_encode($likers);
		}
	}
