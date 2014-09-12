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

class Photo
{
    public function __construct()
    {
		//get CI's reference to use CI's libraries
		$this->CI = & get_instance();
    }
	public function get_profile_photo($pid)
	{
		$image = base_url()."uploads/profile_pics/".$pid.".jpg";
		return $image;
	}
	public function get_thumb($pid)
	{
		$image = base_url()."uploads/thumbs/".$pid.".jpg";
		return $image;
	}
	public function get_photo($pid)
	{
		$image = base_url()."uploads/photos/".$pid.".jpg";
		
		return $image;
	}
	
}