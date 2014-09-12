<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "welcome";
$route['404_override'] = '';
$route['signup'] = "account/account/register";
$route['login'] = "account/account/login";
$route['account/change_password'] = "account/account/change_password";
$route['resendVerificationEmail'] = "account/account/resend_verify_email";
$route['forgetPassword'] = "account/account/forget_password";
$route['register/jsUserCheck'] = "account/account/js_user_check";
$route['register/jsEmailCheck'] = "account/account/js_email_check";
$route['account/logout'] = "account/account/logout";
$route['verification']="account/account/verification";
$route['unverifiedAccount']="account/account/unverified_user";

$route['community']="stream/stream/index";
$route['download']="stream/stream/download";
$route['chat']="chat/chat";
$route['admin']="stream/stream/admin";
$route['admin/(:any)']="stream/stream/admin/$1";
$route['search']="stream/stream/search";


$route['account/settings']="profile/profile_settings/index";
$route['account/personal-settings']="profile/profile_settings/index";
$route['account/change-password']="profile/profile_settings/change_password";
$route['account/education-settings'] = "profile/profile_settings/education_settings";

$route['account/make_fellow']="profile/profile_settings/make_fellow";
$route['account/save_education']="profile/profile_settings/add_new_inst";
$route['account/delete_education']="profile/profile_settings/del_inst";
$route['account/update_education']="profile/profile_settings/update_inst";

$route['post/do_post']="post/post/do_post";
$route['post/do_comment']="post/post/do_comment";
$route['post/del_post']="post/post/del_post";
$route['post/del_comment']="post/post/del_comment";
$route['post/like_post']="post/post/like_post";
$route['post/get_likers']="post/post/get_likers";

$route['stream/check_update']="stream/stream/is_updates";
$route['stream/check_comment']="stream/stream/is_comment";
$route['stream/load_stream']="stream/stream/load_more_stream";
$route['notify/notify_comment'] = "notification/notification/save_comment_notification";
$route['notify/mark_read'] = "notification/notification/mark_all_read";
$route['members/get_members'] = "messages/messages/get_members";
$route['message/new_message'] = "messages/messages/save_message";
$route['message/new_reply'] = "messages/messages/save_reply";
$route['message/check_message'] = "messages/messages/is_msg";
$route['message/mark_read'] = "messages/messages/mark_all_read";
$route['photos/upload_photo'] = "media/media/upload_photo";
$route['photos/del_photo'] = "media/media/del_photo";
$route['files/del_file'] = "media/media/del_file";
$route['files/upload_file'] = "media/media/upload_file";
$route['videos/del_video'] = "media/media/del_video";
$route['videos/upload_video'] = "media/media/upload_video";
$route['user/update_status']="chat/chat_sup/online_status";
$route['user/online_users']="chat/chat_sup/get_online_users";
$route['group/create_group']="group/group/create_group";
$route['group/group_name']="group/group/group_name";
$route['group/make_member']="group/group/make_group_member";
$route['group/update_settings']="group/group/update_group";
$route['group/del_member']="group/group/delete_group_member";

$route['user/del_user']="admin/admin/delete_user";
$route['user/ban_user']="admin/admin/ban_user";
$route['user/unban_user']="admin/admin/unban_user";

$route['manage/del_admin']="admin/admin/delete_admin";
$route['manage/add_admin']="admin/admin/add_admin";


$route['search/do_search']="search/search/do_search";

$route['service/update_service']="admin/admin/update_service";


$route['groups/(:any)'] = "stream/stream/group_stream/$1";

$route['(:any)'] = "stream/stream/user_stream/$1";
//$route['(:any)/info'] = "profile/profile_info/user_info";

$route['test']="test";
$route['fetch']="media/media/fetch_link_data";

$route['test/up_photo']="test/up_photo";

/* End of file routes.php */
/* Location: ./application/config/routes.php */