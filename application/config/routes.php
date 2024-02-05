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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'home';

$route['features'] = 'Home/features';
$route['digital-board-packs'] = 'Home/digital_board_packs';
$route['contact'] = 'Home/contact';
$route['product-level'] = 'Home/product_level';
$route['security'] = 'Home/security';
$route['pricing'] = 'Home/pricing';
$route['company'] = 'Home/company';
$route['services'] = 'Home/services';
$route['why-us'] = 'Home/why_us';

$route['admin'] = 'admin/Index';
$route['404_override'] = '404';

$route['admin/homesetting/practical-board'] = 'admin/Homesetting/practicalboard_setting';
$route['admin/homesetting/why-us'] = 'admin/Homesetting/why_us_setting';

$route['admin/homesetting/scheule-section'] = 'admin/Homesetting/schedule_section';

$route['admin/homesetting/cosec-action-section'] = 'admin/Homesetting/cosecaction_section';

$route['admin/homesetting/key-features'] = 'admin/Homesetting/key_features';

$route['admin/homesetting/get-more-cosec'] = 'admin/Homesetting/get_more_cosec';
$route['translate_uri_dashes'] = FALSE;


$route['login'] = 'home/login';
$route['register'] = 'home/register';
$route['recover-password'] = 'home/forgot_password';
$route['new-arrivals'] = 'home/new_arrivals';
$route['product/(:any)'] = 'home/product_detail/$1';
$route['cart'] = 'home/view_cart';
$route['checkout'] = 'home/checkout';
$route['payment-success'] = 'home/payment_success';
$route['my-account'] = 'home/my_account';
$route['my-orders'] = 'home/my_orders';
$route['wishlist'] = 'home/wishlist';
$route['faq'] = 'home/faq';
$route['page/(:any)'] = 'home/pages/$1';

