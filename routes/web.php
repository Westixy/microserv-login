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
    return $router->app->version();
});

$router->post('/login',
['middleware' => 'auth',
function() {
    return response()->json(['login'=>'OK'],200);
}
]
);

$router->post('/register', 'UserController@register');

$router->get('/login', ['middleware' => 'auth', function() {
    return response()->json(['login'=>'OK'],200);
}]);