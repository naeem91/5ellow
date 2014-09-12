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

class DateLib 
{
    public function __construct()
    {
		//get CI's reference to use CI's libraries
		$this->CI = & get_instance();
		$this->CI->load->helper('date');
		
    }
	public function make_nice_date($date)
	{
		$d = explode('-',$date);
		
		$months = array('01'=>'January','02'=>'Februray','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August',                 '09'=>'September','10'=>'October','11'=>'November','12'=>'December');
		
		$month = $months["$d[1]"];
		
		return $month.' '.$d[2].','.$d[0];
	}
	public function last_active($time)
	{
		return mysql_to_unix($time);
	}
	public function get_timespan($time)
	{
		$time = mysql_to_unix($time);
		//$time -= -3600;
		return $this->time_since($time);
		//return $time;
		//return timespan($time, $now);
	}
		function time_since($time)
{

$now = time();
$now_day = date("j", $now);
$now_month = date("n", $now);
$now_year = date("Y", $now);

$time_day = date("j", $time);
$time_month = date("n", $time);
$time_year = date("Y", $time);
$time_since = "";

switch(TRUE)
{
case ($time == 0):
$time_since = 'Never';
break;
case ($now-$time < 60):
// RETURNS SECONDS
$seconds = $now-$time;
// Append "s" if plural
$time_since = $seconds > 1 ? "$seconds seconds" : "$seconds second";
break;
case ($now-$time < 45*60): // twitter considers > 45 mins as about an hour, change to 60 for general purpose
// RETURNS MINUTES
$minutes = round(($now-$time)/60);
$time_since = $minutes > 1 ? "$minutes minutes" : "$minutes minute";
break;
case ($now-$time < 86400):
// RETURNS HOURS
$hours = round(($now-$time)/3600);
$time_since = $hours > 1 ? " $hours hours" : " $hours hour";
break;
case ($now-$time < 1209600):
// RETURNS DAYS
$days = round(($now-$time)/86400);
$time_since = "$days days";
break;
case (mktime(0, 0, 0, $now_month-1, $now_day, $now_year) < mktime(0, 0, 0, $time_month, $time_day, $time_year)):
// RETURNS WEEKS
$weeks = round(($now-$time)/604800);
$time_since = "$weeks weeks";
break;
case (mktime(0, 0, 0, $now_month, $now_day, $now_year-1) < mktime(0, 0, 0, $time_month, $time_day, $time_year)):
// RETURNS MONTHS
if($now_year == $time_year) { $subtract = 0; } else { $subtract = 12; }
$months = round($now_month-$time_month+$subtract);
$time_since = "$months months";
break;
default:
// RETURNS YEARS
if ($now_month < $time_month)
{
$subtract = 1;
}
elseif ($now_month == $time_month)
{
if ($now_day < $time_day)
{
$subtract = 1;
}
else
{
$subtract = 0;
}
}
else
{
$subtract = 0;
}
$years = $now_year-$time_year-$subtract;
$time_since = "$years years";
break;
}

return $time_since .' ago';
}
}
