<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['about-us'] = 'home/aboutUs';

$route['super-admin/module-access'] = 'superadmin/moduleAccess';

$route['super-admin'] = 'superadmin/login';
$route['super-admin/module-access'] = 'superadmin/moduleAccess';

// Admin Routing
$route['admin-login'] = 'main/login';
$route['admin'] = 'main/login';
$route['login'] = 'main/login';
$route['admin-dashboard'] = 'main/index';

$route['staff'] = 'main/staff';
$route['staffPermission/(:any)'] = 'main/staffPermission/$1';

$route['admin-shop-type'] = 'main/shopType';
$route['admin-category'] = 'main/category';
$route['admin-sub-category'] = 'main/subCategory';
$route['admin-brands'] = 'main/brands';
$route['admin-unit'] = 'main/unit';
$route['admin-subscription'] = 'main/subscription';
$route['admin-form-fields'] = 'main/formFields';

$route['admin-create-offers'] = 'main/addOffersPage';
$route['admin-list-offers'] = 'main/offersList';

$route['admin-banners'] = 'main/banners';

$route['admin-manage-coupon'] = 'main/manageCoupon';

$route['admin-vendor-list'] = 'main/vendorList';
$route['admin-pending-vendor'] = 'main/pendingVendor';
$route['admin-approve-vendor'] = 'main/vendorApproval';
$route['admin-vendor-product'] = 'main/vendorProductList';
$route['admin-vendor-user'] = 'main/vendorUserList';
$route['admin-vendor-orders-list'] = 'main/vendorOrdersList';
$route['admin-vendor-orders-view'] = 'main/vendorOrdersView';

$route['admin-add-product'] = 'main/addProduct';
$route['admin-view-product'] = 'main/productList';
$route['admin-create-product-details'] = 'main/createProductDetails';
$route['admin-product-unit-stock/(:any)'] = 'main/productUnitStockPrice/$1';
$route['admin-update-product/(:any)'] = 'main/updateProduct/$1';

$route['admin-add-agent'] = 'main/addAgent';
$route['admin-agent-list'] = 'main/agentList';
$route['admin-agent-package'] = 'main/agentPackage';

$route['admin-vendor-approval'] = 'main/vendorApproval';
$route['admin-vendor-details'] = 'main/vendorDetails';


// Seller Routes
$route['partner'] = 'seller/index';
$route['partner-dashboard'] = 'seller/dashboard';
$route['partner-subscription'] = 'seller/subscription';
$route['partner-import-list'] = 'seller/importList';
$route['partner-setting'] = 'seller/setting';


// website
$route['about-us'] = 'home/about';
$route['contact-us'] = 'home/contact';
$route['integrations'] = 'home/integrations';
$route['partnerships'] = 'home/partnerships';
