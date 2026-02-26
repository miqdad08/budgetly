<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginAction');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::registerSave');
$routes->get('/logout', 'Auth::logout');

// ========== DASHBOARD ==========
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/test', 'Test::index');

$routes->get('/transactions', 'Transactions::index');
$routes->get('/transactions/create', 'Transactions::create');
$routes->post('/transactions/store', 'Transactions::store');
$routes->get('/transactions/edit/(:num)', 'Transactions::edit/$1');
$routes->post('/transactions/update/(:num)', 'Transactions::update/$1');
$routes->get('/transactions/delete/(:num)', 'Transactions::delete/$1');

// ========== PROFILE ==========
$routes->get('/profile', 'Profile::index');
$routes->get('/profile/accounts/create', 'Profile::createAccount');
$routes->post('/profile/accounts/store', 'Profile::storeAccount');
$routes->get('/profile/accounts/edit/(:num)', 'Profile::editAccount/$1');
$routes->post('/profile/accounts/update/(:num)', 'Profile::updateAccount/$1');
$routes->get('/profile/accounts/delete/(:num)', 'Profile::deleteAccount/$1');
// Categories
$routes->get('/profile/categories/create', 'Profile::createCategory');
$routes->post('/profile/categories/store', 'Profile::storeCategory');
$routes->get('/profile/categories/edit/(:num)', 'Profile::editCategory/$1');
$routes->post('/profile/categories/update/(:num)', 'Profile::updateCategory/$1');
$routes->post('/profile/categories/delete/(:num)', 'Profile::deleteCategory/$1');