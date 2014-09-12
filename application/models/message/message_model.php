<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Message_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->load->model('profile/profile_model');
			$this->load->library('datelib');
		}
		
		public function get_latest_msg()
		{
			$this->db->select_max('msg_id');
			$query = $this->db->get('message');
			
			$result = $query->row_array();
			
			return $result['msg_id'];
		}
		public function is_unread_msgs()
		{
			$uid = $this->session->userdata('userid');
			
			$query = $this->db->get_where('message',array('msg_receiver'=>$uid,'msg_read'=>0));
			
			if($query->num_rows <= 0)
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		public function get_new_msg($latest_id)
		{
			$this->db->select_max('msg_id');
			$query = $this->db->get('message');
			if($query->num_rows() <= 0)
			{
				return FALSE;
			}			
			$result = $query->row_array();
			
			//check if its latest msg 
			if($result['msg_id'] > $latest_id)
			{
				//retreive this latest msg
				$query = $this->db->get_where('message',array('msg_id'=>$result['msg_id']));
				$result = $query->row_array();
				
				$this_user = $this->session->userdata('userid');
				
				//if it belongs to current user
				if($result['msg_sender'] == $this_user || $result['msg_receiver'] == $this_user)
				{
					$msg = array();
					
					$msg['msg_text'] = $result['msg_text'];
					$msg['msg_time'] = $this->datelib->get_timespan($result['msg_time']);;
					$msg['reply'] = $result['msg_reply'];
					$msg['msg_id'] = $result['msg_id'];
					$msg['msg_read'] = $result['msg_read'];
					
					$sender_info = $this->profile_model->get_basic_detail($result['msg_sender']);
					$rec_info = $this->profile_model->get_basic_detail($result['msg_receiver']);
					
					$msg['sender_display'] = $sender_info['display_name'];
					$msg['sender_user'] = $sender_info['user_name'];
					$msg['sender_photo'] = $sender_info['photo'];
					$msg['sender_id'] = $result['msg_sender'];
					
					$msg['rec_display'] = $rec_info['display_name'];
					$msg['rec_user'] = $rec_info['user_name'];
					$msg['rec_photo'] = $rec_info['photo'];
					$msg['rec_id'] = $result['msg_receiver'];
					
					return $msg;
				}
				else
				{
					return FALSE;
				}				
			}
			else
			{
				return FALSE;
			}
		}
		public function get_all_msgs()
		{
			$uid = $this->session->userdata('userid');
			
			/*$this->db->order_by("msg_time", "desc");
			$this->db->where('msg_sender =', $uid);
			$this->db->or_where('msg_receiver =', $uid);
			$query = $this->db->get('message');*/
			$query = $this->db->query("SELECT * FROM message WHERE (msg_sender = $uid OR msg_receiver = $uid) AND msg_reply = '0' order by msg_id desc");
			
			if($query->num_rows() < 1)
			{
				return FALSE;
			}
			
			$result = $query->result_array();
			
			//var_dump($result);
			$msgs = array();
			
			foreach($result as $r)
			{
				
				$msgs["senders"][] = $this->profile_model->get_basic_detail($r['msg_sender']);
				$msgs["receivers"][] = $this->profile_model->get_basic_detail($r['msg_receiver']);
				
				$r['msg_time'] = $this->datelib->get_timespan($r['msg_time']);
				$msgs["msgs"][] = $r;
					
				//see for replies to this msg
				$this->db->order_by("msg_id", "asc");
				$query = $this->db->get_where('message',array('msg_reply'=>$r['msg_id']));	
				if($query->num_rows() < 1)
				{
					$msgs["replies"][] = FALSE; 
				}
				else
				{
					$replies = $query->result_array();
					
					//convert time into time spans
					for($i=0; $i<count($replies); $i++)
					{
						$replies[$i]['msg_time'] = $this->datelib->get_timespan($replies[$i]['msg_time']);
					}
					
					$msgs["replies"][] = $replies;
				}
			}
			
			//var_dump($msgs["replies"]);
			return $msgs;
		}
		public function mark_all_read()
		{
			$uid = $this->session->userdata('userid');
			
			$this->db->where('msg_receiver', $uid);
			$this->db->update('message',array('msg_read'=>1));
		}
		public function new_message($data)
		{
			return $this->db->insert('message',$data);
		}
		public function delete_user_msgs($uid)
		{
			$this->db->where('msg_sender =',$uid);
			$this->db->or_where('msg_receiver =',$uid);
			return $this->db->delete('message');
		}
	}