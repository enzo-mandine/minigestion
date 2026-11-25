<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin', [
    'filter' => 'throttle:10:60'
]);
$routes->post('logout', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('clients', 'Clients::index');
    $routes->get('clients/new', 'Clients::new');
    $routes->post('clients', 'Clients::create');
    $routes->get('clients/(:num)/edit', 'Clients::edit/$1');
    $routes->get('clients/(:num)/show', 'Clients::show/$1');
    $routes->post('clients/(:num)/update', 'Clients::update/$1');
    $routes->post('clients/(:num)/delete', 'Clients::delete/$1');
    $routes->get('about', 'About::index');
});
