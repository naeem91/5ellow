<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	class Notification extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->load->model('notification/notification_model');
			
		}
		
		public function save_comment_notification()
		{
			$sender = $this->input->post('sender');
			$post = $this->input->post('post');		
			$time = $this->input->post('time');
			$receiver = $this->input->post('receiver');;
			
			$notify_data = array('sender'=>$sender,'receiver'=>$receiver,'post'=>$post,'time'=>$time,'type'=>'comment');
			
			if($this->notification_model->save_notification($notify_data) == TRUE)
			{
				echo TRUE;
			}
			else
			{
				echo FALSE;
			}
		}
		
		public function mark_all_read()
		{
			$id = $this->session->userdata('userid');
			
			if($this->notification_model->mark_read($id) == TRUE)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
			
		}
	}