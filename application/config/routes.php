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

$route['compliance-bundles'] = "bundle_con/index";
$route['compliance-bundles'] = "bundle_con/index";
$route['compliance-landing'] = "landing_con/index";

$route['compliance-bundles/(:num)'] = "bundle_con/index/$1";
$route['compliance-landing/(:any)'] = "landing_con/index/$1";
$route['compliance-bundles/(:num)/(:any)'] = "bundle_con/bundle_details/$1/$2";
$route['individual-courses/(:num)/(:any)'] = "course_con/course_details/$1/$2";
$route['individual-courses'] = "course_con/index";
$route['individual-courses/(:num)'] = "course_con/index/$1";
$route['logout'] = "customer_con/logout";
$route['cart'] = "cart_con/index";
$route['checkout'] = "checkout_con/index";
$route['success'] = "checkout_con/success";
$route['mycourses'] = "customer_con/user_courses";
$route['myorders'] = "customer_con/get_order_details";
$route['mysetting'] = "customer_con/user_setting";
$route['mybilling'] = "customer_con/my_billing";
$route['mycredits'] = "customer_con/my_credit";
$route['mycredits/(:num)'] = "customer_con/my_credit/$1";
$route['subscriptions'] = 'subscription_con/index';
$route['login'] = "customer_con/login";
$route['start-review/(:num)'] = "customer_con/start_review_exam/$1";
$route['take-course/(:num)'] = "customer_con/take_courses/$1";
$route['start-exam/(:num)'] = "customer_con/start_final_exam/$1";
$route['mycertificates'] = "customer_con/user_certificates";
$route['course-evalution/(:num)'] = "customer_con/course_evalution/$1";
//$route['download-certificate/(:any)'] = "customer_con/download_certificate/$i";
$route['default_controller'] = 'index_con/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
