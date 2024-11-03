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

#Análise de Rede
// $routes->match(['GET', 'POST'], '/analise/load/json', 'Analise::loadJson');
#Planta

#User
$routes->match(['GET', 'POST'], '/users/list', 'User::index');
$routes->match(['GET', 'POST'], '/users/list/json', 'User::json_list');

#Redirect
$routes->addRedirect('(.+)', '/');
