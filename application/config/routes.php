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

$route['messages/page']      = "messages/index";
$route['messages/page/:num'] = "messages/index";
$route['search/(:any)/keyword/(:any)/page/(:num)'] = "messages/search/$1/$2/$3";
$route['search/(:any)/keyword/(:any)'] = "messages/search/$1/$2";
$route['search/(:any)/keyword'] = "messages/index";
$route['(:any)/(:any)/compare/(:any)/(:any)/search/(:any)/keyword/(:any)/page/(:num)'] = "messages/search2/$1/$2/$3/$4/$5/$6/$7";
$route['(:any)/(:any)/compare/(:any)/(:any)/search/(:any)/keyword/(:any)'] = "messages/search2/$1/$2/$3/$4/$5/$6";
$route['(:any)/(:any)/compare/(:any)/(:any)/search/(:any)/keyword'] = "messages/index";
$route['default_controller'] = "messages/index";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */