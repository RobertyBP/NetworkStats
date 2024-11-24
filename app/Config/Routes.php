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

#Rede
$routes->get('/redes/list', 'Rede::index');
$routes->match(['GET', 'POST'], '/redes/list/json', 'Rede::json_list');
$routes->match(['GET', 'POST'], '/redes/(add)', 'Rede::upsert/$1');
$routes->match(['GET', 'POST'], '/redes/(edit)/(:num)', 'Rede::upsert/$1/$2');
$routes->match(['GET', 'POST'], '/redes/delete/(:num)', 'Rede::redeDelete/$1');

#Cômodo
$routes->get('/comodos/list', 'Comodo::index');
$routes->match(['GET', 'POST'], '/comodos/list/json', 'Comodo::json_list');
$routes->match(['GET', 'POST'], '/comodos/(add)', 'Comodo::upsert/$1');
$routes->match(['GET', 'POST'], '/comodos/(edit)/(:num)', 'Comodo::upsert/$1/$2');
$routes->match(['GET', 'POST'], '/comodos/delete/(:num)', 'Comodo::comodoDelete/$1');

#Sinal
$routes->get('/sinais/list', 'Sinal::index');
$routes->match(['GET', 'POST'], '/sinais/list/json', 'Sinal::json_list');
$routes->match(['GET', 'POST'], '/sinais/(add)', 'Sinal::upsert/$1');
$routes->match(['GET', 'POST'], '/sinais/(edit)/(:num)', 'Sinal::upsert/$1/$2');
$routes->match(['GET', 'POST'], '/sinais/delete/(:num)', 'Sinal::sinalDelete/$1');

#User
$routes->match(['GET', 'POST'], '/users/list', 'User::index');
$routes->match(['GET', 'POST'], '/users/list/json', 'User::json_list');
$routes->match(['GET', 'POST'], '/users/(add)', 'User::upsert/$1');
$routes->match(['GET', 'POST'], '/users/(edit)/(:num)', 'User::upsert/$1/$2');
$routes->match(['GET', 'POST'], '/users/delete/(:num)', 'User::userDelete/$1');
$routes->match(['GET', 'POST'], '/user/account/(:any)/changePassword', 'User::alterarSenha/$1');

#Index
$routes->match(['GET', 'POST'], '/analise/list/json', 'Index::json_list');

#Redirect
$routes->addRedirect('(.+)', '/');
