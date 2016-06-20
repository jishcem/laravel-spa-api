<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'cors'], function ($api) {

    $api->post('/login', [ 'uses' => 'App\Http\Controllers\AuthController@postLogin' ]);

    $api->group(['middleware' => 'jwt.refresh'], function ($api) {
        $api->post('/refresh-token', [ 'uses' => 'App\Http\Controllers\AuthController@refreshToken' ]);
    });

    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->post('/me', 'App\Http\Controllers\AuthController@getMe');
        $api->get('/task', 'App\Http\Controllers\TaskController@index');
        $api->post('/task', 'App\Http\Controllers\TaskController@store');
        $api->post('/task/delete/{id}', 'App\Http\Controllers\TaskController@destroy');
        $api->post('/task/edit/{id}', 'App\Http\Controllers\TaskController@edit');
        $api->post('/task/update/{id}', 'App\Http\Controllers\TaskController@update');
    });
});
