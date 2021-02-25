<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', ['uses' => 'MenuController@index', 'as' => 'dishes.index']);
$router->get('/dishes/create', ['uses' => 'MenuController@create', 'as' => 'dishes.create']);
$router->post('/dishes/create', ['uses' => 'MenuController@store', 'as' => 'dishes.store']);
$router->get('/dishes/{id}', ['uses' => 'MenuController@edit', 'as' => 'dishes.edit']);
$router->put('/dishes/{id}', ['uses' => 'MenuController@update', 'as' => 'dishes.update']);
$router->delete('/dishes/{id}', ['uses' => 'MenuController@destroy', 'as' => 'dishes.delete']);

$router->get('/menu', ['uses' => 'MenuController@menu', 'as' => 'menu.index']);
$router->get('/menu/autocomplete', ['uses' => 'MenuController@autocomplete', 'as' => 'menu.autocomplete']);
