<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	class Chat_Sup extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('account/account_model');
		}
		
		public function online_status()
		{
			if($this->session->userdata('logged_in') == TRUE)
			{
				$this->account_model->update_login_status();
			}
		}
		public function get_online_users()
		{
			$users = $this->account_model->get_online_users();
			if($users == FALSE)
			{
				echo 'false';
			}
			else
			{
				//var_dump($users);
				echo json_encode($users);
			}
		}
	}