<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Notification_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->load->model('profile/profile_model');
			$this->load->library('datelib');
		}
		
		public function save_notification($data)
		{
			return $this->db->insert('notification',$data);
		}
		public function get_notifications($which = 'unread',$uid = FALSE)
		{
			$user_id = $this->session->userdata('userid');
			if($uid != FALSE)
			{
				$user_id = $uid;
			}
			
			$this->db->order_by("id", "desc");
			$query = $this->db->get_where('notification',array('receiver'=>$user_id,'read'=>0));
			
			if($which != 'unread')
			{
				$this->db->order_by("id", "desc");
				$query = $this->db->get_where('notification',array('receiver'=>$user_id));				
			}
			
			
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$result = $query->result_array();
			
			$final_notifs = array();
			
			foreach($result as $notice)
			{
				$sender_name = $this->profile_model->get_profile_details('name',$notice['sender']);
				$sender_user = $this->profile_model->get_profile_details('user',$notice['sender']);
				
				$notice['time'] = $this->datelib->get_timespan($notice['time']);
				
				$final_notifs[] = '<li><span class="display"><a href="'.base_url().$sender_user.'">'.$sender_name.'</a></span> commented on your <a class="post-link" href="'.base_url().'community#f'.$notice["post"].'">post</a>  <span class="ctime"> '.$notice["time"].'</span></li>';
				
			}
			
			return $final_notifs;
		}
		
		public function mark_read($id)
		{
			return $this->db->update('notification',array('read'=>'1'), "receiver = $id");
		}
	}