<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/subnet' , 'Home::subnet');
$routes->get('/Hote' , 'Home::hote');
$routes->get('/dhcp' , 'Dhcp::index');

$routes->get('/globale' , 'Dhcp::globale');
$routes->get('/specific' , 'Dhcp::specific');
$routes->get('/netfilter' , 'Netfilter::index');
