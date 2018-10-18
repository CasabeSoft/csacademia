<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
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
require APPPATH.'helpers/client_helper.php';
$subdomain = get_subdomain();
$subdomain_is_client = subdomain_is_client($subdomain);

$route['default_controller'] = $subdomain_is_client ?
        'user_pages/login' :
        'public_pages/home';

$route['api/config/front'] = 'config/front';
$route['api/config/value'] = 'config/value';
$route['api/config/value/(:any)'] = 'config/value/$1';
$route['api/email/contact'] = 'api_messaging/email_contact';
$route['api/email'] = 'api_messaging/email';
$route['api/sms/contact'] = 'api_messaging/sms_contact';
$route['api/sms'] = 'api_messaging/sms';
$route['user/(:any)'] = 'user_pages/$1';
$route['manage/contact'] = 'contact/admin';
$route['manage/teacher'] = 'teacher/admin';
$route['manage/student'] = 'student/admin';
$route['manage/group'] = 'group/admin';
$route['catalog/(:any)'] = 'admin_pages/$1';
$route['manager/(:any)'] = 'manager_pages/$1';
$route['contact/(:any)'] = 'contact/$1';
$route['teacher/(:any)'] = 'teacher/$1';
$route['student/(:any)'] = 'student/$1';
$route['group/(:any)'] = 'group/$1';
$route['task/(:any)'] = 'task/$1';
$route['picture/(:any)'] = 'picture/$1';
$route['report/birthday'] = 'student/birthday';
$route['report/payments'] = 'student/payments';
$route['report/payments_bank'] = 'student/payments_bank';
$route['report/attendance'] = 'group/attendance';
$route['tools/tasks'] = 'task/admin';
$route['tools/bulk_operations'] = 'manager_pages/bulk_operations';
$route['help/about'] = 'manager_pages/main';

$route['login'] = 'user_pages/login';
$route['change_password'] = 'user_pages/change_password';
$route['profile'] = 'user_pages/profile';
$route['denied'] = 'user_pages/denied';
$route['close'] = 'user_pages/close';

$route["lang/(:any)"] = "public_pages/lang/$1";

$route['(:any)'] = $subdomain_is_client ?
        'user_pages/login' :
        'public_pages/$1';

$route['404_override'] = 'public_pages/error404';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
