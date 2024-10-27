<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Index::index');
#Base
$routes->match(['GET', 'POST'], '/login', 'Login::index');
$routes->get('/logout', 'Login::logout');
$routes->get('/home', 'Index::index');
$routes->get('/sobre', 'Sobre::index');



#Redirect
$routes->addRedirect('(.+)', '/');
