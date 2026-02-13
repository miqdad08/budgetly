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