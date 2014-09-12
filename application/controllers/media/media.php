<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	class Media extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->load->model('media/photo_model');
			$this->load->model('media/file_model');
			$this->load->model('media/video_model');

			$this->load->model('post/post_model');	
			//$this->load->model('profile/profile_model');			
			
			$this->load->library('uploading');
		}
		public function del_photo()
		{
			$photo_id = $this->input->post('photo');
			
			if($this->photo_model->delete_photo($photo_id) == TRUE)
			{
				
				echo TRUE;
			}
			else
			{
				echo FALSE;
			}
		}
		
		public function upload_file()
		{
			$post = $this->input->post('post-data');
			$uid = $this->session->userdata('userid');
			$post_data = array('post_text'=>$post,'poster'=>$uid);

			$iserror = FALSE;
			$error = array();
			$id = NULL;
			
			//check if a file is attached
			if(isset($_FILES['userfile']['name']))
			{				
				$file = $this->input->post('userfile');
				$file_name = $_FILES['userfile']['name'];
				//$file_type = $file_type = $_FILES['userfile']['type'];
				$isUploaded = $this->uploading->file_upload($file);
				if($isUploaded == 'uploaded')
				{
				  //if photo upload succesfull, save its record in database
				  $file_data['user_id'] = $this->session->userdata('userid');
				  $file_data['file_name'] = $file_name;
				  $file_id = $this->file_model->create($file_data);
		  
				  //attach photo with post
				  $post_data['attachment_type'] = 'file';
				  $post_data['attachment_id'] = $file_id;
				  
				  $id = $file_id;
				}
				else
				{
					$iserror = TRUE;
					$error = $isUploaded;
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
					$data = array('is_error'=>$iserror,'id'=>$id,'name'=>$file_name);
					echo json_encode($data);
				/*$post_time = $this->post_model->get_post('time',$result);
				$post_time = $this->datelib->get_timespan($post_time);
				
				$data = array('id'=>$result,'time'=>$post_time);
				echo json_encode($data);*/ 
				}
			}
		}
		public function upload_photo()
		{
			$post = $this->input->post('post-data');
			$uid = $this->session->userdata('userid');
			$post_data = array('post_text'=>$post,'poster'=>$uid);

			$iserror = FALSE;
			$error = array();
			$id = NULL;
			
			//check if a file is attached
			if(isset($_FILES['userfile']['name']))
			{				
				$photo = $this->input->post('userfile');
				$photo_name = $_FILES['userfile']['name'];
				//$file_type = $file_type = $_FILES['userfile']['type'];
				$isUploaded = $this->uploading->photo_upload($photo,$photo_name);
				if($isUploaded == 'uploaded')
				{
				  //if photo upload succesfull, save its record in database
				  $photo_data['user_id'] = $this->session->userdata('userid');
				  $photo_data['photo_name'] = $photo_name;
				  $photo_id = $this->photo_model->create($photo_data);
		  
				  //attach photo with post
				  $post_data['attachment_type'] = 'photo';
				  $post_data['attachment_id'] = $photo_id;
				  
				  $id = $photo_id;
				}
				else
				{
					$iserror = TRUE;
					$error = $isUploaded;
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
					$data = array('is_error'=>$iserror,'id'=>$id,'name'=>$photo_name);
					echo json_encode($data);
				/*$post_time = $this->post_model->get_post('time',$result);
				$post_time = $this->datelib->get_timespan($post_time);
				
				$data = array('id'=>$result,'time'=>$post_time);
				echo json_encode($data);*/ 
				}
			}
		}
		public function upload_video()
		{
			$post = $this->input->post('post-data');
			$uid = $this->session->userdata('userid');
			$post_data = array('post_text'=>$post,'poster'=>$uid);

			$iserror = FALSE;
			$error = array();
			$id = NULL;
			
			$vid_link = $this->input->post('video_link');
			if(!empty($vid_link))
			{
				$vid = $this->input->post('video_link');
				
				if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $vid))
				{
				
				  $video_data['user_id'] = $this->session->userdata('userid');
				  $video_data['video_link'] = $vid;
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
				$data = array('is_error'=>$iserror,'id'=>$id);
				echo json_encode($data);
				/*$post_time = $this->post_model->get_post('time',$result);
				$post_time = $this->datelib->get_timespan($post_time);
				
				$data = array('id'=>$result,'time'=>$post_time);
				echo json_encode($data);*/ 
			}
		}
		public function del_file()
		{
			$file_id = $this->input->post('file');
			
			if($this->file_model->delete_file($file_id) == TRUE)
			{
				
				echo TRUE;
			}
			else
			{
				echo FALSE;
			}
		}
		public function del_video()
		{
			$video_id = $this->input->post('video');
			
			if($this->video_model->delete_video($video_id) == TRUE)
			{
				
				echo TRUE;
			}
			else
			{
				echo FALSE;
			}
		}
		public function fetch_link_data()
		{
			$url = $_GET['url'];
			$url = $this->checkValues($url);
				
				
				$string = $this->fetch_record($url);
				if($string == FALSE)
				{
					echo FALSE;
					return;
				}
				
				/// fecth title
				$title_regex = "/<title>(.+)<\/title>/i";
				preg_match_all($title_regex, $string, $title, PREG_PATTERN_ORDER);
				$url_title = $title[1];
				
				/// fecth decription
				$tags = get_meta_tags($url);
				
				// fetch images
				$image_regex = '/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui';
				preg_match_all($image_regex, $string, $img, PREG_PATTERN_ORDER);
				$images_array = $img[1];
				
				$data = array();
				$pimg = FALSE;
				
				if(@$images_array[0])
				{
					$pimg = @$images_array[0];	
				}
				$data = array('title'=>$url_title[0],'url'=>substr($url,0,35),'desc'=>$tags['description'],'img'=>$pimg);
				echo json_encode($data);
		}
		function checkValues($value)
				{
					$value = trim($value);
					if (get_magic_quotes_gpc()) 
					{
						$value = stripslashes($value);
					}
					$value = strtr($value, array_flip(get_html_translation_table(HTML_ENTITIES)));
					$value = strip_tags($value);
					$value = htmlspecialchars($value);
					return $value;
				}	
				function fetch_record($path)
				{
					$file = fopen($path, "r"); 
					if (!$file)
					{
						return FALSE;
					} 
					$data = '';
					while (!feof($file))
					{
						$data .= fgets($file, 1024);
					}
					return $data;
				}
						
	}