<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/get-area', 'Home::getArea');
$routes->get('/get-chart', 'Home::getChart');
$routes->get('/get-list', 'Home::getList');
