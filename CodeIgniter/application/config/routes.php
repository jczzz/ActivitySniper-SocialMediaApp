<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['user/edit/(:any)']='user/edit/$1';
$route['user/checkinfor/']='user/check_information/';
$route['activity/cal']='activity/cal';
$route['logout']='user/logout';
$route['activity/view/(:any)/(:any)/(:any)/(:any)']='activity/view/$1/$2/$3/$4';
$route['activity/join_friend_activity/(:any)/(:any)/(:any)']='activity/join_friend_activity/$1/$2/$3';
$route['activity/friendactivity/(:any)/(:any)']='activity/friendactivity/$1/$2';
$route['user/friend/(:any)']='user/friend/$1';
$route['user/information/(:any)']='user/information/$1';
$route['activity/showall/(:any)']='activity/showall/$1';
$route['activity/view/(:any)/(:any)/(:any)']='activity/view/$1/$2/$3';
$route['activity/remove/(:any)/(:any)']='activity/remove/$1/$2';
$route['activity/join/(:any)/(:any)']='activity/join/$1/$2';
$route['activity/create/(:any)']='activity/create/$1';
//$route['activity/select/(:any)']='activity/location/$1';
//$route['activity/index']='activity/index';
$route['activity/index/(:any)/(:any)']='activity/index/$1/$2';
$route['activity/create']='activity/create';
$route['activity/(:any)/delete']='activity/delete/$1';
$route['activity/(:any)/(:any)']='activity/view/$1/$2';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['default_controller'] = "user/login";
