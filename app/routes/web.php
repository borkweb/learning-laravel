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

// Login route
Route::get( 'login', 'Auth\LoginController@login' );
Route::get( 'login/callback', 'Auth\LoginController@loginCallback' );
Route::get( 'logout', 'Auth\LoginController@logout' );

Auth::routes();

Route::get( '/', function () {
    return view( 'home' );
} );

// pages that require authentication. Hint: all of them
Route::group( [ 'middleware' => 'auth' ], function() {
    // place pages that require authentication in here
} );
