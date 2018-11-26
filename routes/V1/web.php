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

## Sign-up-in User.
$router->group(
    ['prefix' => 'api/v1/user'],
    function () use ($router) {
        $router->post('signup', 'UserController@createUser');
        $router->post('/', 'UserController@authenticateUser');
    }
);
