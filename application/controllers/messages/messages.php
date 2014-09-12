<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	class Messages extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->load->model('profile/profile_model');
			$this->load->model('message/message_model');
		}
		
		public function save_message()
		{
			$sender = $this->session->userdata('userid');
			$receiver = $this->input->post('to');
			$msg = $this->input->post('msg');
			
			$msg_data = array('msg_sender'=>$sender,'msg_receiver'=>$receiver,'msg_text'=>$msg);
			if($this->message_model->new_message($msg_data))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		public function save_reply()
		{
			$sender = $this->input->post('sender');
			$receiver = $this->input->post('to');
			$msg = $this->input->post('msg');
			$reply_to = $this->input->post('reply');
			
			$msg_data = array('msg_sender'=>$sender,'msg_receiver'=>$receiver,'msg_text'=>$msg,'msg_reply'=>$reply_to);
			if($this->message_model->new_message($msg_data))
			{
				echo TRUE;
			}
			else
			{
				echo FALSE;
			}
		}
		public function is_msg()
		{
			$latest_id = $this->input->post('data');
			
			if(empty($latest_id))
			{
				echo FALSE;
			}
			
			$new_msg = $this->message_model->get_new_msg($latest_id);
			if($new_msg == FALSE)
			{
				echo FALSE;
			}
			
			$new_msg = json_encode($new_msg);
			
			echo $new_msg;
		}
		public function mark_all_read()
		{
			$this->message_model->mark_all_read();
			
		}
		public function get_members()
		{
			$q = strtolower($_GET["term"]);
			if (!$q) return;
			
			$items = $this->profile_model->get_all_members();
			
			$result =array();
			foreach ($items as $key=>$value) 
			{
				if (strpos(strtolower($key), $q) !== false) 
				{
					array_push($result, array("id"=>$value, "label"=>$key, "value" => strip_tags($key)));
				}
	
				if (count($result) > 11)
					break;
			}
			
			echo $this->array_to_json($result);

		}
		
		function array_to_json( $array )
		{
			if( !is_array( $array ) )
			{
        		return false;
    		}

    		$associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    		if( $associative )
			{
        		$construct = array();
        		foreach( $array as $key => $value )
				{
            		// We first copy each key/value pair into a staging array,
            		// formatting each key and value properly as we go.

            		// Format the key:
            		if( is_numeric($key) )
					{
                		$key = "key_$key";
            		}
            		$key = "\"".addslashes($key)."\"";

            		// Format the value:
            		if( is_array( $value ))
					{
                		$value = $this->array_to_json( $value );
            		} 
					else if( !is_numeric( $value ) || is_string( $value ) )
					{
                		$value = "\"".addslashes($value)."\"";
            		}
            
					// Add to staging array:
            		$construct[] = "$key: $value";
        		}

        		// Then we collapse the staging array into the JSON form:
       			 $result = "{ " . implode( ", ", $construct ) . " }";

    		} 
			else 
			{ 
				// If the array is a vector (not associative):
        		$construct = array();
        		foreach( $array as $value )
				{
            		// Format the value:
            		if( is_array( $value ))
					{
                		$value = $this->array_to_json( $value );
            		} 
					else if( !is_numeric( $value ) || is_string( $value ) )
					{
                		$value = "'".addslashes($value)."'";
            		}

            		// Add to staging array:
            		$construct[] = $value;
        		}

        			// Then we collapse the staging array into the JSON form:
        			$result = "[ " . implode( ", ", $construct ) . " ]";
    		}

    		return $result;
		}

	}