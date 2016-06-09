<?php

Route::group(['prefix' => 'api', 'middleware' => 'cors'], function () {

    Route::post('/login', [ 'uses' => 'AuthController@postLogin' ]);

    Route::get('/tasks', function () {
        return ['one', 'two', 'three'];
    });

});

Route::get('/', function () {
    return view('welcome');
});
