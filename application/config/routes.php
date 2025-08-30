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
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['W_Order/W_order'] = 'W_Order/W_order_count';
$route['Atas_Order/Atas_order'] = 'Atas_Order/Atas_order_count';
$route['K8_W/K8_W_order'] = 'K8_W/K8_W_order_count';
$route['W_Order/get_mistake_chart_data'] = 'W_Order/get_mistake_chart_data';
$route['W_Order/get_all_orders_barline_chart_se'] = 'W_Order/get_all_orders_barline_chart_se';
$route['emp_perfomance/(:any)'] = 'Emp_Perfomance/emp_perfomance/$1';
$route['employee/chart/(:any)'] = 'Emp_Perfomance/chart_view/$1';
// $route['dropdown'] = 'YourController/showEnumDropdown';
$route['W_Order/showMistakeChart/(:any)'] = 'W_Order/showMistakeChart/$1';
$route['Atas_Order/showMistakeChart/(:any)'] = 'Atas_Order/showMistakeChart/$1';
$route['Warning/Add_Warning'] = 'Warning/save';
$route['order_report'] = 'Order/order_report';
$route['order_report/filter'] = 'Order/filter_orders';
$route['ir/resolved'] = 'IR/resolved_ir';
$route['order_report/get_all_orders_barline_chart'] = 'Order_report/get_all_orders_barline_chart';
$route['Order_report/get_order'] = 'Order_report/get_order';






