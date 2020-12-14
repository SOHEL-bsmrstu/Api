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

$router->group(['prefix' => 'api/products', 'middleware' => 'auth',], function () use ($router) {
    $router->get("/", "FetchAction@fetch");
    $router->post('create', 'CreateAction@create');
    $router->put('{product}/update', 'UpdateAction@update');
    $router->delete('{product}/delete', 'DeleteAction@delete');

    $router->get('/{product}/image', ["as" => 'api.products.image', 'uses' => 'FetchAction@imageLink']);
});
