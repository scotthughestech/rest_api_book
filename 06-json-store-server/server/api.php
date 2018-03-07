<?php

use Illuminate\Http\Request;
use App\Bin;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/bins', function (Request $request) {
    // Make sure the body is JSON
    if (!json_decode($request->getContent())) {
        return response(null, 400);
    }

    // If it is, try to save it
    try {
        //throw new Exception();
        $bin = new Bin;
        $bin->data = $request->getContent();
        $bin->save();
    } catch (Exception $e) {
        return response($e, 500);
    }

    // Return the URI
    return response(
        ['uri' => url('api/bins/'.$bin->id)],
        201
    );
});

Route::put('/bins/{bin}', function (Bin $bin, Request $request) {
    // Make sure the body is JSON
    if (!json_decode($request->getContent())) {
        return response(null, 400);
    }

    // If it is, try to update the bin
    try {
        $bin->data = $request->getContent();
        $bin->save();
    } catch (Exception $e) {
        return response($e, 500);
    }

    // Return the data
    return response(
        $bin->data,
        200
    );
});

Route::get('/bins/{bin}', function (Bin $bin) {
    // Return the data
    return response(
        $bin->data,
        200
    );
});
