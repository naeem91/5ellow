<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	class Stream extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->load->model('account/account_model');
			$this->load->helper('url');
			//if not logged-in, redirect to home
			if($this->account_model->is_logged_in() == FALSE)
			{
				redirect(base_url());
			}
			if($this->account_model->is_verified() == FALSE)
			{
				//redirect to unverified account page
				redirect(base_url().'unverifiedAccount');
			}
			
			$this->data['title'] = "5ellow";
			$this->data['css'] = array('default.css','jqvideobox.css','jquery.lightbox.css','jquery-ui.css','chat.css','screen.css');
			$this->data['scripts'] = array('jquery.js','jquery.form.js','jquery.livequery.js','jquery.timers.js','jquery.lightbox.js','jquery-ui.js','jqvideobox.js','swfobject.js','chat.js','jquery.validate.js','jquery.endless-scroll.js','jquery.watermarkinput.js');

			$this->data['page'] = "stream";
			
			$this->load->model('profile/profile_model');
			$this->load->model('profile/personal_profile_model');
			$this->load->model('post/post_model');
			$this->load->model('stream/stream_model');
			$this->load->model('notification/notification_model');
			$this->load->model('message/message_model');
			$this->load->model('media/photo_model');
			$this->load->model('media/video_model');
			$this->load->model('media/file_model');
			$this->load->model('group/group_model');
			$this->load->model('admin/admin_model');
			
			$this->load->library('datelib');

			$this->load->helper('download');
			
			//save logged-in user id and profile id for using in script
			$this->userid = $this->session->userdata('userid');
			$this->profileid = $this->session->userdata('profileid');
			
			//set user name, and id of this signedin user
			$this->data['signed_user_name'] = $this->account_model->get_account_details('name');
			$this->data['signed_user_photo'] = $this->profile_model->get_profile_details('photo');
			$this->data['signed_user_display'] = $this->profile_model->get_profile_details('name');
			$this->data['signed_user_id'] = $this->userid;
			
			$this->data['is_user_stream'] = FALSE;
			$this->data['this_user_id'] = $this->userid;
			
			$this->data['super_admin'] = FALSE;
			$this->data['is_admin'] = FALSE;
			
			if($this->session->userdata('admin') == TRUE)
	        {     	
				$this->data['is_admin'] = TRUE;
				
				if($this->session->userdata('super_admin') == TRUE)
				{
					$this->data['super_admin'] = TRUE;
				}
			}
			
			$this->data['uploading_enable'] = TRUE;
			if($this->post_model->uploading_status() == FALSE)
			{
				$this->data['uploading_enable'] = FALSE;
			}
			
			$this->data['group_info'] = 0;
			$this->data['this_group_id'] = 0;
			
			$this->data['notifications'] =	$this->notification_model->get_notifications();
			
			$this->data['latest_post'] = $this->post_model->get_latest_post();
			$this->data['latest_comment'] = $this->post_model->get_latest_comment();
			$this->data['latest_msg'] = $this->message_model->get_latest_msg();
			$this->data['msgs'] = $this->message_model->is_unread_msgs();
			
			$this->data['show_controls'] = TRUE;
			
			$_SESSION['username'] = $this->data['signed_user_name'];
			
			$this->data['top_groups'] = $this->group_model->get_top_groups();
			$this->data['top_users'] = $this->profile_model->get_top_members();
		}
		public function index()
		{	
			//fetch user details 
			$this->_fetch_details($this->userid);		
			
			$this->data['content'] = "public-stream";
			
			//fetch public stream
			$this->get_public_stream();
			
			$this->load->view('templates/signedin-layout',$this->data);
		}
		public function user_stream()
		{
			$this->_get_user_info();
			//$this->get_public_stream(FALSE,);
			
			$this->load->view('templates/signedin-layout',$this->data);
		}
		public function group_stream()
		{
			$this->_get_group_info();
			$this->_fetch_details($this->userid);
			
			$this->load->view('templates/signedin-layout',$this->data);
		}
		public function search()
		{
			$this->_fetch_details($this->userid);
			
			$this->data['content'] = 'search';
			
			
			$q = $this->input->get('q');
			
			$this->data['gresults'] = $this->group_model->custom_search($q);
			$this->data['uresults'] = $this->profile_model->search_members($q);
			
			$this->data['title'] = $q. ' - 5ellow Search';	
			
			$this->load->view('templates/signedin-layout',$this->data);
		}
		public function admin()
		{
			
			if($this->data['is_admin'] == FALSE)
			{
				redirect(base_url().'community');
			}
			
			$this->_get_admin_info();
			$this->_fetch_details($this->userid);
			
			$this->data['page'] = 'admin';
			$this->data['title'] = 'Admin Panel';	
			
			$this->load->view('templates/signedin-layout',$this->data);

		}
		private function _fetch_details($uid)
		{
			
			//get that user's details
			$this->data['basic_details'] = $this->profile_model->get_profile_details('all',$uid);				
		
			//$this->data['basic_details'] = $this->profile_model->get_profile_details();
			$this->data['display_name'] = $this->data['basic_details']['display_name'];
			$this->data['user_name'] = $this->account_model->get_account_details('name',$uid,'id');
			//get profile picture
			$this->data['profile_pic'] =  $this->data['basic_details']['photo'];
			
		
			//get education details	
			$this->data['education'] = $this->personal_profile_model->get_details('education',$this->data['basic_details']['profile_id']);
			//change dob's format
			if($this->data['basic_details']['dob'] != "")
			$this->data['basic_details']['dob'] = $this->datelib->make_nice_date($this->data['basic_details']['dob']);
			
			//get fellowers
			$this->get_fellowers($uid);
			//get photos
			//$this->get_follows($uid);
			$this->data['photos'] = $this->photo_model->get_all_photos($uid);
			$this->data['videos'] = $this->video_model->get_all_videos($uid);
			$this->data['files'] = $this->file_model->get_all_files($uid);

			
		}
		
		private function _get_admin_info()
		{
			
			
			
			
			
			$uri = uri_string();
			
			
			$uri_segments = explode('/',$uri);	
			
			if(count($uri_segments) > 2)
			{
				//redirect to 404 page
				redirect(show_404());
			}
			if(count($uri_segments) == 1)
			{
				$this->data['content'] = 'admin-stats';
				$this->data['stats'] = $this->admin_model->get_stats();
			}
			
			if(count($uri_segments) == 2)
			{
				$opt = $uri_segments[1];
				switch($opt)
				{
					case 'services':
						$this->data['content'] = 'admin-service';
						$this->data['service'] = $this->admin_model->get_status();
						break;
					case 'users':
						$this->data['content'] = 'admin-user';
						$this->data['users'] = $this->admin_model->get_users();
						break;
					case 'admins':
						if($this->data['super_admin'] == FALSE)
						{
							redirect(base_url().'admin');
						}
						$this->data['content'] = 'manage-admin';
						$this->data['admins'] = $this->admin_model->get_admins();
						break;
					default:
						redirect(show_404());
						break;
				}
				
			}
			
		}
		
		private function _get_group_info()
		{
			$uri = uri_string();
			
			$uri_segments = explode('/',$uri);
			
			if(count($uri_segments) > 3)
			{
				//redirect to 404 page
				redirect(show_404());
			}
			
			$group_name = $uri_segments[1];
			$this->data['content'] = "group-stream";
			
			$group_id = $this->group_model->get_group_info('id',$group_name,'name');
			
			$this->data['is_group_member'] = TRUE;
			//check if current user is group members or not
			if($this->group_model->is_member($group_id,$this->userid) == FALSE)
			{
				$this->data['is_group_member'] = FALSE;
			}
			
			$this->data['is_group_admin'] = FALSE;
			//check if current user is group admin	
			if($this->group_model->is_admin($group_id,$this->userid) == TRUE)
			{
				$this->data['is_group_admin'] = TRUE;
			}
			
			//var_dump($uri_segments);
			//echo count($uri_segments);
			if(count($uri_segments) == 3)
			{
				//some group info is requested, e.g, groups/groupname/info
				$group_res = $uri_segments[2];
				switch($group_res)
				{
					case 'info':
						$this->data['content'] = 'group-info';
						break;
					case 'photos':
						$this->data['content'] = 'group-photos';
						break;
					case 'videos':
						$this->data['content'] = 'group-videos';
						break;
					case 'files':
						$this->data['content'] = 'group-files';
						break;
					case 'settings':
						if($this->data['is_group_admin'] == FALSE)
						{
							redirect(base_url().'groups/'.$group_name);
						}
						$this->data['content'] = 'group-settings';
						break;
					default:
						break;
				}
			}
			
			
			
			$group_info = $this->group_model->get_group_info('all',$group_id);
			
			$group_info['members'] = $this->group_model->get_group_members($group_id);
			$group_info['photos'] = $this->group_model->get_group_photos($group_id);
			$group_info['videos'] = $this->group_model->get_group_videos($group_id);
			$group_info['files'] = $this->group_model->get_group_files($group_id);

			$this->data['group_info'] = $group_info;
			
			
			$this->data['this_group_id'] = $group_id;
			
			$this->data['title'] = $group_info['group_display_name'];	
			
			$this->get_public_stream(FALSE,FALSE,$group_id);
		}
		private function _get_user_info()
		{
			//analyze URI to load required user info
			$uri = uri_string();
			//$uri = trim_slashes($uri);
			
			$uri_segments = explode('/',$uri);
			
			//if only a username is passed. like 5ellow.com/picasso
			if(count($uri_segments) == 1)
			{
				$user_name = $uri_segments[0];
				$this->data['content'] = "user-stream";
				$this->data['is_user_stream'] = TRUE;
			}
			else if(count($uri_segments) > 2)
			{
				//redirect to 404 page
				redirect(show_404());
			}
			else
			{
				$user_name = $uri_segments[0];
				
				$this->data['is_user_stream'] = TRUE;
				
				//check if current user is signed-in user or not, if not don't show controls like edit/delete
				$id = $this->account_model->get_account_details('id',$user_name,'user');
				if($id != $this->userid)
				{
					$this->data['show_controls'] = FALSE;
					
					if($this->data['is_admin'] == TRUE)
					{
						$this->data['show_controls'] = TRUE;
					}
				}
				
				switch($uri_segments[1])
				{
					case "info":
						$this->data['content'] = "info";
						break;
					case "fellows":
						$this->data['content'] = "fellows";
						break;
					case "photos":
						$this->data['content'] = "photos";						
						break;
					case "videos":
						$this->data['content'] = "videos";
						break;
					case "files":
						$this->data['content'] = "files";
						break;
					case "notifications":
						//if not signed-in user, redirect to user stream
						if($this->data['show_controls'] == FALSE)
						{
							redirect(base_url().$user_name);
						}
						$this->data['content'] = "notifications";
						$this->data['is_user_stream'] = FALSE;
						$this->data['title'] = 'Notifications';	
						$this->data['all_notifs'] = $this->notification_model->get_notifications('all');
						break;
					case "messages":
						//if not signed-in user, redirect to user stream
						if($this->data['show_controls'] == FALSE)
						{
							redirect(base_url().$user_name);
						}
						$this->data['content'] = "messages";
						$this->data['is_user_stream'] = FALSE;						
						$this->data['title'] = 'Messages';		
						$this->data['messages'] = $this->message_model->get_all_msgs();
						break;
					case "groups":
						$this->data['content'] = "groups";
						$this->data['is_user_stream'] = FALSE;
						$this->data['title'] = 'Groups';		
						$this->data['groups'] = $this->group_model->get_all_groups();
						break;
					default:
						redirect(show_404());
						break;
				}
			}
			
			//if user exists and verified, fetch its details
			$id = $this->account_model->get_account_details('id',$user_name,'user'); 
			
			//if user does not exists or unverified
			if($id == FALSE || $this->account_model->is_verified($id) == FALSE)
			{
				//redirect to 404 page
				redirect(show_404());
			}
			
			$this->data['show_postbox'] = TRUE;
			//if userid is not equal to signed user name,user is viewing other user's stream
			if($id != $this->userid)
			{
				
				$this->data['this_user_id'] = $id;
				
			
				$this->data['show_postbox'] = FALSE;
				//check if this user can be followed or not
				$this->data['is_fellow'] = $this->profile_model->is_following($id,$this->userid);
				
			}
			
			//fetch details of that id
			$this->_fetch_details($id);
			
			if($this->data['content'] == 'user-stream'  || $this->data['is_user_stream'] == TRUE)
			{
				$this->data['title'] = $this->data['display_name'];
			}
				
			$this->get_public_stream(FALSE,$id);	
		}
		public function get_fellowers($u)
		{
			$uids = $this->profile_model->get_fellowers($u);
			if($uids == FALSE)
			{
				return;
			}
			
			$fellow_data = array();
			
			foreach($uids as $uid)
			{
				$id = $uid['fellower_id'];
				
				$user_name = $this->account_model->get_account_details('name',$id,'id');
				$name = $this->profile_model->get_profile_details('name',$id);
				$photo = $this->profile_model->get_profile_details('photo',$id);
				
				$fellow_data[] = array('user'=>$user_name,'name'=>$name,'photo'=>$photo);	
			}
			
			$this->data['fellowers'] = $fellow_data;
		}
		public function get_follows($u)
		{
			$uids = $this->profile_model->get_follows($u);
			if($uids == FALSE)
			{
				return;
			}
			
			$follow_data = array();
			
			
			foreach($uids as $uid)
			{
				$id = $uid['user_id'];
				
				$user_name = $this->account_model->get_account_details('name',$id,'id');
				$name = $this->profile_model->get_profile_details('name',$id);
				$photo = $this->profile_model->get_profile_details('photo',$id);
				
				$follow_data[] = array('user'=>$user_name,'name'=>$name,'photo'=>$photo);	
			}
			
			$this->data['follows'] = $follow_data;
		}
		
		public function get_public_stream($p=FALSE,$uid=FALSE,$gid=FALSE)
		{
			$stream = $this->stream_model->get_public_stream($p,$uid,$gid);
			
			$this->data['stream'] = $stream;
		}
		public function is_updates()
		{
			$latest_id = $this->input->post('data');
			if(empty($latest_id))
			{
				echo FALSE;
			}
			
			$new_post = $this->stream_model->get_new_post($latest_id);
			if($new_post == FALSE)
			{
				echo FALSE;
			}
			
			$new_post = json_encode($new_post);
			
			echo $new_post;
		}
		public function is_comment()
		{
			$latest_id = $this->input->post('data');
			
			if(empty($latest_id))
			{
				echo FALSE;
			}
			
			$new_comment = $this->stream_model->get_new_comment($latest_id);
			if($new_comment == FALSE)
			{
				echo FALSE;
			}
			
			$new_comment = json_encode($new_comment);
			
			echo $new_comment;
		}
		
		public function load_more_stream()
		{
			$page = $this->input->post('data');
			
			$user = $this->input->post('user');
			
			$group = $this->input->post('group');
			
			if($user == 'false')
			{
				$user = FALSE;
			}
			
			if($group == 'false')
			{
				$group = FALSE;
			}
			
			$new_stream = $this->stream_model->get_public_stream($page,$user,$group);
			
			//echo $new_stream;
			echo json_encode($new_stream);
		}
		public function download()
		{
			$file = $this->input->get('file');
			
			$data = file_get_contents(base_url()."uploads/files/".$file); // Read the file's contents
			$name = $file;

			force_download($name, $data); 
		}
	}
?>