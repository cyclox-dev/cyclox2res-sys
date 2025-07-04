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

// メンテナンスモードときにはこの行の1つ下の行で /* を有効にすること。//* ならメンテナンス解除となる。
//*


//$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['meet/(:any)'] = 'meet/view/$1';
$route['meet'] = 'meet/index';

$route['meet__/(:any)'] = 'meet/view__/$1';
$route['meets/index__'] = 'meet/index__';
$route['meets__'] = 'meet/index__';

$route['race/(:num)'] = 'race/view/$1';
$route['race/(:any)/(:any)'] = 'race/view_race/$1/$2';

$route['race__/(:num)'] = 'race/view__/$1';


$route['racers'] = 'racer';
$route['racer/(:any)'] = 'racer/view/$1';

$route['racer__/(:any)'] = 'racer/view__/$1';

$route['point_series/before'] = 'point_series/index/before';
$route['point_series/(:num)'] = 'point_series/view/$1';
$route['point_series/index/(:any)'] = 'point_series/index/$1';
$route['point_series'] = 'point_series';

$route['point_series__/(:any)'] = 'point_series/view__/$1';

$route['ajocc_ranking/(:num)/(:num)/(:any)'] = 'ajocc_ranking/view/$1/$2/$3';
$route['ajocc_ranking/index/(:any)'] = 'ajocc_ranking/index/$1';
$route['ajocc_ranking'] = 'ajocc_ranking';

$route['ajocc_ranking__/(:num)/(:num)/(:any)'] = 'ajocc_ranking/view__/$1/$2/$3';


$route['(:any)'] = 'pages/view/$1';
$route['default_controller'] = 'pages/home';

/*/

$route['default_controller'] = 'pages/maintenance';
$route['(:any)'] = 'pages/maintenance';
$route['404_override'] = 'pages/maintenance';

//*/
