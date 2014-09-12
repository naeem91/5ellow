<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Controller Name: Welcome 
* Methods:
* - index() 
*  
* Author Name: Naeem Ilyas 
* Last Updated: August 2,2012 
*/

class Welcome extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('account/account_model');
					
		
		//set title,scripts & css for page
		$this->data['title'] = "5ellow";
		$this->data['css'] = array('default.css','jquery-ui.css');
	}
	public function index()
	{
		//if user has enabled "keep me sign in"
		if(isset($_COOKIE['umail']))
		{
			//echo $_COOKIE['umail'];
			//setcookie('umail','',time()-1*24*60*60);
			//var_dump($_COOKIE);
			$this->account_model->login($_COOKIE['umail']);
		}
		//if logged-in & vierified, redirect to community home
		if($this->account_model->is_logged_in() == TRUE && $this->account_model->is_verified() == TRUE)
		{
			redirect(base_url().'community');
		}
		else if($this->account_model->is_logged_in() == TRUE && $this->account_model->is_verified() == FALSE)
		{
			redirect(base_url().'unverifiedAccount');
		}
		else
		{
			$this->data['title'] .= " - Welcome to 5ellow!";
			$this->data['css'] = array('default.css');
			$this->data['scripts'] = array('jquery.js','jquery.validate.js','validation.js');
		
			$this->data['signup_enable'] = $this->account_model->check_service('reg');	
		
			$this->load->view('home',$this->data); 
		}
	}
}


/* End of file welcome.php */ 
/* Location: application/controllers/welcome.php */