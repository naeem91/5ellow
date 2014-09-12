<?php
class Test extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		//load required library and models
		$this->load->library('form_validation');
		//custome class, contains email functions
		$this->load->library('myemail');
		$this->load->library('photo');
		$this->load->library('uploading');
		$this->load->model('account/account_model');
		$this->load->model('profile/profile_model');			
		$this->load->library('datelib');			
		$this->load->model('media/photo_model');
		$this->load->model('post/post_model');			
		$this->load->model('stream/stream_model');
		$this->load->model('notification/notification_model');
		$this->load->model('message/message_model');
		$this->load->model('group/group_model');
		
		$username = $this->profile_model->get_profile_details('user', $this->session->userdata('userid'));
		
		 $_SESSION['username'] = $username;
		 
		date_default_timezone_set( 'Asia/Karachi');
		$this->load->helper('date');
		//set title,scripts & css for page
		$this->data['title'] = "Account Settings";
		$this->data['css'] = array('default.css','chat.css','screen.css','jqvideobox.css');
		$this->data['scripts'] = array('jquery.js','jquery.timers.js','chat.js','jqvideobox.js','swfobject.js','jquery.form.js','jquery.validate.js','validation.js');	
	}
	public function index()
	{
		$this->post_model->get_likers_details(409);
			//$this->load->view('upload',$this->data);
		//$this->message_model->delete_user_msgs(14);
			//$this->group_model->delete_from_all_groups(10);
			//echo $this->post_model->delete_user_posts(10);
			//echo $this->post_model->delete_user_comments(10);
			
			//echo 1;
		
		
	}
	public function up_photo()
	{
		$url = $_REQUEST['url'];
		$string = $this->fetch_record($url);
		/// fecth title
		$title_regex = "/<title>(.+)<\/title>/i";
		preg_match_all($title_regex, $string, $title, PREG_PATTERN_ORDER);
		$url_title = $title[1];
		 
		/// fecth decription
		$tags = get_meta_tags($url);
		 
		// fetch images
		$image_regex = '/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui';
		preg_match_all($image_regex, $string, $img, PREG_PATTERN_ORDER);
		$images_array = $img[1];
		
		$im = "<img src='".@$images_array[1]."' width='100'>";
		$data = array('title'=>$url_title[0],'url'=>substr($url ,0,35),'desc'=>$tags['description'],'img'=>$im);
		
		echo json_encode($data);
	}
	
	function fetch_record($path)
	{
		$file = fopen($path, "r"); 
		if (!$file)
		{
			exit("Problem occured");
		} 
		$data = '';
		while (!feof($file))
		{
			$data .= fgets($file, 1024);
		}
		return $data;
	}
	
	public function thelist()
	{
		$this->db->select('user_name,user_id');
		$this->db->where('last_active_time >', NOW()-60);
		$this->db->where('user_id !=', $this->session->userdata('userid'));
		$query = $this->db->get('user');
		
		if($query->num_rows() < 1)
		{
			echo FALSE;
		}
		
		$result = $query->result_array();
		$users = array();
		foreach($result as $r)
		{
			$display = $this->profile_model->get_profile_details('name',$r['user_id']);
			
			$users[] = array('name'=>$r['user_name'],'display'=>$display);
			//$users[]['name'] = $r['user_name'];
			
		}
		//var_dump($users);
		echo json_encode($users);
	}
	public function upload()
	{
		if($this->session->userdata('logged_in') == TRUE)
		{
			$this->db->where('user_id', $this->session->userdata('userid'));
			$this->db->update('user',array('last_active_time'=>NOW()));
		}
	}
	
	
	
	function duration($integer)
 { 

     $seconds=$integer; 
     $minutes = 0;
     $hours = 0;
     $days = 0;
     $weeks = 0;
     $return = "";
     if ($seconds/60 >=1) 

     { 

     $minutes=floor($seconds/60); 

     if ($minutes/60 >= 1) 

     { # Hours 

     $hours=floor($minutes/60); 

     if ($hours/24 >= 1) 

     { #days 

     $days=floor($hours/24); 

     if ($days/7 >=1) 

     { #weeks 

     $weeks=floor($days/7); 

     if ($weeks>=2) $return="$weeks Weeks"; 

     else $return="$weeks Week"; 

     } #end of weeks 

     $days=$days-(floor($days/7))*7; 

     if ($weeks>=1 && $days >=1) $return="$return, "; 

     if ($days >=2) $return="$return $days days";

     if ($days ==1) $return="$return $days day";

     } #end of days

     $hours=$hours-(floor($hours/24))*24; 

     if ($days>=1 && $hours >=1) $return="$return, "; 

     if ($hours >=2) $return="$return $hours hours";

     if ($hours ==1) $return="$return $hours hour";

     } #end of Hours

     $minutes=$minutes-(floor($minutes/60))*60; 

     if ($hours>=1 && $minutes >=1) $return="$return, "; 

     if ($minutes >=2) $return="$return $minutes minutes";

     if ($minutes ==1) $return="$return $minutes minute";

     } #end of minutes 

     $seconds=$integer-(floor($integer/60))*60; 

     if ($minutes>=1 && $seconds >=1) $return="$return, "; 

     if ($seconds >=2) $return="$return $seconds seconds";

     if ($seconds ==1) $return="$return $seconds second";

     $return="$return."; 

     return $return; 

 }

	function time_ago_in_words($time) {
  $from_time = strtotime($time);

  $to_time = strtotime(gmd());
  $distance_in_minutes = round((($to_time - $from_time))/60);

  if ($distance_in_minutes < 0)
    return (string)$distance_in_minutes.'E';

  if (between($distance_in_minutes, 0, 1))
    return '1 minute';

  elseif (between($distance_in_minutes, 2, 44))
    return $distance_in_minutes.' minutes';

  elseif (between($distance_in_minutes, 45, 89))
    return '1 hour';

  elseif (between($distance_in_minutes, 90, 1439))
    return round($distance_in_minutes/60).' hours';

  elseif (between($distance_in_minutes, 1440, 2879))
    return '1 day';

  elseif (between($distance_in_minutes, 2880, 43199))
    return round($distance_in_minutes/1440).' days';

  elseif (between($distance_in_minutes, 43200, 86399))
    return '1 month';

  elseif (between($distance_in_minutes, 86400, 525959))
    return round($distance_in_minutes/43200).' months';

  elseif ($distance_in_minutes > 525959)
    return number_format(round(($distance_in_minutes/525960), 1), 1).' years';
}
function time_ago($time, $max_units = NULL)
	{
		$lengths = array(1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600);
		$units = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade');
		$unit_string_array = array();

		$max_units = (is_numeric($max_units) && in_array($max_units, range(1,8))) ? $max_units : sizeOf($lengths);
		$diff = (is_numeric($time) ? time() - $time : time() - strtotime($time));
		$future = ($diff < 0) ? 1 : 0;
		$diff = abs($diff); // Let's get positive!

		$total_units = 0;
		for ($i = sizeOf($lengths) - 1; $i >= 0; $i--)
		{
			if ($diff > $lengths[$i] && $total_units < $max_units)
			{
				$amount = floor($diff / $lengths[$i]);
				$mod = $diff % $lengths[$i];

				$unit_string_array[] = $amount . ' ' . $units[$i] . (($amount == 1) ? '' : 's');
				$diff = $mod;
				$total_units++;
			}
		}

		return ($future) ? implode($unit_string_array, ', ') . ' to go' : implode($unit_string_array, ', ') . ' ago';
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
$time_since = $hours > 1 ? "about $hours hours" : "about $hours hour";
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


