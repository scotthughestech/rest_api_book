<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $number = rand(1,100);
    return [
        'number' => $number,
        'answer' => $number % 2 == 0 ? 'yes' : 'no'
    ];
});
