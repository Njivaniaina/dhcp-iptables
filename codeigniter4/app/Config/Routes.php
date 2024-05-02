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
$routes->get('/netfilter/list', 'Netfilter::list');
$routes->get('/netfilter/add', 'Netfilter::add');                   #formulaire d'ajout
$routes->post('/netfilter/addData', 'Netfilter::addData');
$routes->get('/netfilter/addData', 'Netfilter::addData');
$routes->get('/netfilter/police', 'Netfilter::police');
$routes->post('/netfilter/add', 'Netfilter::add');
$routes->post('/netfilter/police', 'Netfilter::police');

$routes->get('/netfilter/error', 'Netfilter::error');
