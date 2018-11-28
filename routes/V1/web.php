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
        $router->post('/validate', 'UserController@validateData');
    }
);

/**
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

/**
 * Song Routes.
 */
$router->group(
    ['prefix' => 'api/v1/song'],
    function () use ($router) {
        $router->post('/album/{album_id}', 'SongController@create');
        $router->get('/{song_id}', 'SongController@download');
        $router->delete('/{song_id}', 'SongController@delete');
        $router->get('/', 'SongController@getSongs');
        $router->post('/{song_id}/comment', 'CommentController@create');
    }
);

/**
 * Search Routes.
 */
$router->group(
    ['prefix' => 'api/v1/search'],
    function () use ($router) {
        $router->get('/song', 'SongController@search');
    }
);

/**
 * Playlist Routes.
 */
$router->group(
    ['prefix' => 'api/v1/playlist'],
    function () use ($router) {
        $router->post('/', 'PlaylistController@create');
        $router->post('/{playlist_id}/song/{song_id}', 'PlaylistController@addSong');
    }
);