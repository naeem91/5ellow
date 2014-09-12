<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Class Name: MyEmail 
* Responsibility: Performs email related functions
*
* Methods:
* - send verification email
* - send email
* 
* Last Updated: August 4,2012 
*/

class MyEmail 
{
    public function __construct()
    {
		//get CI's reference to use CI's libraries
		$this->CI = & get_instance();
		$this->CI->load->library('email');
		
		$this->CI->email->from('admin@5ellow.com', '5ellow');
    }
/**	
 * send verification email
 *
 * this function generates a verification link,subject,body & send email
 * 
 * @param 	array	userdata
 * 
 */

	public function send_verification_email($udata)
	{
		$verLink = base_url().'verification?user='.urlencode($udata['user']).'&code='.$udata['code'];
		
		$to = $udata['email'];
		$subject = "Email Confirmation";
		$msg = "Welcome to 5ellow. Click on the following link to complete your registration \n".$verLink;				
		
		$this->send_email($to,$subject,$msg);
	}
/**	
 * send email
 *
 * this function send email 
 * 
 * @param 	string	email address
 * @param	string	email subject
 * @param	string	message
 */

	public function send_email($to,$subject,$message)
	{
		$this->CI->email->to($to);
		$this->CI->email->subject($subject);
		$this->CI->email->message($message);
		
		$this->CI->email->send();
	}
}

/* End of Email.php */
/* Location: application/libraries/MyEmail.php */