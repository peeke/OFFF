<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = 'page/home';
$route['404_override'] = '';

$route['user'] = 'user/view';
$route['user/confirm_user/(:any)'] = 'user/confirm_user/$1';
$route['user/(:any)/(:any)'] = 'user/$1/$2';
$route['user/(:any)'] = 'user/$1';
$route['profile/(:any)'] = 'user/view/$1';
$route['profile'] = 'user/view';
$route['page/view/(:any)'] = 'page/view/$1';
$route['page/embed/(:any)'] = 'page/embed/$1';
$route['page/canvas'] = 'page/canvas';
$route['page/ranking'] = 'page/ranking';
$route['page/(:any)'] = 'page/view/$1';
$route['do/(:any)'] = 'page/$1';
$route['start'] = 'page/start'; 
$route['start/(:any)'] = 'page/start/$1'; 
$route['activity/index'] = 'activity/index';
$route['activity/(:any)'] = 'activity/view/$1';
$route['submission/view/(:any)'] = 'submission/view/$1'; 
$route['submission/(:any)/(:any)'] = 'submission/$1/$2'; 
$route['submission/(:any)'] = 'submission/$1'; 
$route['widget/(:any)/(:any)'] = 'widget/$1/$2';
$route['widget/(:any)'] = 'widget/view/$1';
$route['like/(:any)/(:any)'] = 'like/$1/$2';

$route['(:any)'] = 'page/$1'; 



/* End of file routes.php */
/* Location: ./application/config/routes.php */