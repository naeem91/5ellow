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

class Date 
{
    public function __construct()
    {
		//get CI's reference to use CI's libraries
		$this->CI = & get_instance();
		$this->CI->load->helper('date');
		
    }
	public function make_nice_date($date)
	{
		 return unix_to_human($date);
	}
}
