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

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('register', 'RegisterController@register');

    $router->post('login', 'LoginController@login');
    $router->post('logout', 'LoginController@logout');

    $router->post('auth', 'LoginController@authUser');
    $router->post('refresh', 'LoginController@refresh');
});
