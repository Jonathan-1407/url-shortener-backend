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

$router->get('/', 'RedirectController@index');
$router->get('/{code}', 'RedirectController@redirect');
$router->post('/{code}/report', 'RedirectController@report');

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'auth'], function () use ($router) {
        /* Matches "/api/auth/route-name */
        $router->post('/register', 'AuthController@register');
        $router->post('/login', 'AuthController@login');

        $router->group(['prefix' => 'user', 'middleware' => 'auth'], function () use ($router) {
            /* Matches "/api/auth/user/route-name */
            $router->get('/profile', 'AuthController@profile');
            $router->put('/profile/update', 'UserController@update');
        });

        $router->group(['prefix' => 'admin', 'middleware' => ['auth', 'is_admin']], function () use ($router) {
            /* Matches "/api/auth/admin/route-name */
            $router->group(['prefix' => 'users'], function () use ($router) {
                $router->get('/', 'UserController@users');
            });
        });
    });
    $router->group(['prefix' => 'url', 'middleware' => 'auth'], function () use ($router) {
        /* Matches "/api/url/route-name */
        $router->get('/owner', 'UrlShortenerController@index');
        $router->post('/create', 'UrlShortenerController@store');
        $router->put('/update/{id}', 'UrlShortenerController@update');
        $router->delete('/delete/{id}', 'UrlShortenerController@destroy');
    });
});
