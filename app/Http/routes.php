<?php

Route::group(['prefix' => 'api', 'middleware' => 'cors'], function () {

    Route::post('/login', [ 'uses' => 'AuthController@postLogin' ]);
    Route::post('/refresh-token', [ 'uses' => 'AuthController@refreshToken' ]);

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('/me', [ 'uses' => 'AuthController@getMe' ]);
    });

    Route::get('/tasks', function () {
        return ['one', 'two', 'three'];
    });

});

Route::get('/', function () {
    return view('welcome');
});
