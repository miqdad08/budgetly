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

// Public API (tanpa token)
$routes->post('api/auth/login', 'Api\Auth::login');
$routes->post('api/auth/register', 'Api\Auth::register');

// Protected API (dengan token)
$routes->group('api', ['filter' => 'token'], function($routes) {
    // Auth
    $routes->post('auth/logout', 'Api\Auth::logout');

    // Accounts
    $routes->get('accounts', 'Api\Accounts::index');
    $routes->get('accounts/(:num)', 'Api\Accounts::show/$1');
    $routes->post('accounts', 'Api\Accounts::create');
    $routes->put('accounts/(:num)', 'Api\Accounts::update/$1');
    $routes->delete('accounts/(:num)', 'Api\Accounts::delete/$1');

    // Categories
    $routes->get('categories', 'Api\Categories::index');
    $routes->get('categories/(:num)', 'Api\Categories::show/$1');
    $routes->post('categories', 'Api\Categories::create');
    $routes->put('categories/(:num)', 'Api\Categories::update/$1');
    $routes->delete('categories/(:num)', 'Api\Categories::delete/$1');

    // Transactions
    $routes->get('transactions', 'Api\Transactions::index');
    $routes->get('transactions/(:num)', 'Api\Transactions::show/$1');
    $routes->post('transactions', 'Api\Transactions::create');
    $routes->put('transactions/(:num)', 'Api\Transactions::update/$1');
    $routes->delete('transactions/(:num)', 'Api\Transactions::delete/$1');
    $routes->get('transactions/trends', 'Api\Transactions::trends');
    $routes->get('transactions/recent', 'Api\Transactions::recent');

    // Dashboard
    $routes->get('dashboard', 'Api\Dashboard::index');
});