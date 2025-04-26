<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');

$routes->get('/register', 'Auth::register');
$routes->post('/registration', 'Auth::registration');
