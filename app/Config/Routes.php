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
