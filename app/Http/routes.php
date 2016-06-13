<?php

Route::group(['prefix' => 'api', 'middleware' => 'cors'], function () {

    Route::post('/login', [ 'uses' => 'AuthController@postLogin' ]);

    Route::group(['middleware' => 'jwt.refresh'], function () {
        Route::post('/refresh-token', [ 'uses' => 'AuthController@refreshToken' ]);
    });

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('/me', 'AuthController@getMe');
        Route::get('/task', 'TaskController@index');
        Route::post('/task', 'TaskController@store');
        Route::post('/task/delete/{id}', 'TaskController@destroy');
    });

    Route::get('/tasks', function () {
        return ['one', 'two', 'three'];
    });

});

Route::get('/', function () {
    return view('welcome');
});
