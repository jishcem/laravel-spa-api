<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH');
header("Access-Control-Allow-Headers: X-Requested-With");

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tasks', function () {
    return ['one', 'two', 'three'];
});
