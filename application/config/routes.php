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
$route['default_controller']    = 'Login';
//$route['default_controller']    = 'Home';
$route['landingpage']    = 'login';
$route['404_override']['GET']   = 'welcome';
$route['translate_uri_dashes']  = FALSE;


$route['Home'] = 'templates/theme01/Home';
$route['Downloads'] = 'templates/theme01/Downloads';
$route['ContactUs'] = 'templates/theme01/ContactUs';
$route['Service'] = 'templates/theme01/Service';
$route['Aboutus'] = 'templates/theme01/Aboutus';

$route['PrivacyPolicy'] = 'templates/theme01/PrivacyPolicy';
$route['Home/PrivacyPolicy'] = 'templates/theme01/PrivacyPolicy';
$route['TermsConditions'] = 'templates/theme01/TermsConditions';
$route['Home/Termsconditions'] = 'templates/theme01/TermsConditions';

$route['RefundPolicy'] = 'templates/theme01/RefundPolicy';




//$route['welcome']['GET'] = 'welcome/index';
//$route['login'] = 'login';