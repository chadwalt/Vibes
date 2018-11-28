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

/**
 * Sign-up-in User Routes.
 */
$router->group(
    ['prefix' => 'api/v1/user'],
    function () use ($router) {
        $router->post('signup', 'UserController@createUser');
        $router->post('/', 'UserController@authenticateUser');
    }
);

/*
* Album Routes.
*/
$router->group(
    ['prefix' => 'api/v1/album'],
    function () use ($router) {
        $router->post('/', 'AlbumController@create');
        $router->get('/', 'AlbumController@getAlbums');
        $router->patch('/{album_id}', 'AlbumController@update');
        $router->delete('/{album_id}', 'AlbumController@delete');
    }
);

/*
* Song Routes.
*/
$router->group(
    ['prefix' => 'api/v1/song/album/{album_id}'],
    function () use ($router) {
        $router->post('/', 'SongController@create');
    }
);