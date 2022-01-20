<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/login', 'LoginController@singin');
$router->post('/login', 'LoginController@singinAction');
$router->get('/cadastro', 'LoginController@singup');
$router->post('/cadastro', 'LoginController@singupAction');

/*
$router->get('/pesquisa');
$router->get('/perfil');
$router->get('/amigos');
$router->get('/fotos');
$router->get('/config');
$router->get('/sair');
*/