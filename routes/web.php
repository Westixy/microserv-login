<?php

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

$router->get('/', function () use ($router) {
    return response()->json(['version'=>'1.0.0', 'description'=>'micro-service used to register / verify if the credentials are available'],200);
});

$router->post('/login', 'UserController@login');
$router->post('/register', 'UserController@register');
$router->post('/reset-password', 'UserController@resetPassword');
$router->get('/login', 'UserController@getLogin');
$router->delete('/delete', 'UserController@delete');