<?php

$route['default_controller']             	= "home";
$route['404_override']                   	= "home/error";
$route['translate_uri_dashes'] 				= FALSE;

//Distributor's Login/Register 
$route['dashboard']             			= "Home/dashboard";

$route['approve']            				= "Home/approve";
$route['block']              				= "Home/block";
$route['distributor/login']                	= "Home/login";
$route['register']                			= "Home/register";

$route['register-data'] 					= 'Home/register_data';
$route['login-check'] 						= 'Home/login_check';
$route['logout']					 		= 'Home/logout';

$route['forgot-password']					= 'Home/forgot_pwd';
$route['change-password']					= 'Home/change_pwd';
$route['check-email']						= 'Home/check_email';
$route['password-update']					= 'Home/password_update';

//Product Section
$route['Medical-Devices']        			= "home/section";
$route['Hospital-Furnitures']        		= "home/section";
$route['Medical-Supplies']        			= "home/section";
$route['Home-Healthcare']        			= "home/section";

//Section Product
$route['Medical-Devices/(:any)']        	= "home/product_category";
$route['Hospital-Furniture/(:any)']       	= "home/product_category";
$route['Medical-Supplies/(:any)']        	= "home/product_category";
$route['Home-Healthcare/(:any)']        	= "home/product_category";

$route['contact-us']                     	= "home/contactus";
$route['about-us']                       	= "home/aboutus";

$route['all-products']                     	= "home/allproduct";
$route['search']                     		= "home/search";
$route['gallery']                     		= "home/gallery";

$route['enquiry']                       	= "home/enquiry";
$route['catalog/(:any)']                    = "home/catalog";
$route['compare']                        	= "home/compare";
$route['quote']                         	= "home/quote";


$route['(:any)']      						= "home/section";
$route['([a-zA-Z0-9\/_-]+)']     			= "home/route";

/* End of file routes.php */
/* Location: ./application/config/routes.php */