<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->post('/login', 'Auth::loginProcess');

$routes->get('/register', 'Auth::register');
$routes->post('/registration', 'Auth::registration');

$routes->get('/logout', 'Auth::logout');

$routes->get('/homepage', 'Home::index');
$routes->get('/profile', 'Profile::index');

$routes->get('/topup', 'Topup::index');
$routes->post('/topup', 'Topup::store');

$routes->get('/transaction/history', 'Transaction::index');
$routes->get('/transaction/loadMoreTransactions', 'Transaction::loadMoreTransactions');
$routes->get('/transaction/payment/(:segment)', 'Transaction::payment/$1');
$routes->post('/transaction', 'Transaction::store');