<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH');
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

Route::group(['prefix' => 'api'], function () {

    Route::post('/login', [ 'uses' => 'AuthController@postLogin' ]);

    Route::get('/tasks', function () {
        return ['one', 'two', 'three'];
    });

});

Route::get('/', function () {
    return view('welcome');
});
