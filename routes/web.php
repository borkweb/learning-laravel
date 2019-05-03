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

Auth::routes();

// pages that require authentication. Hint: all of them
Route::group( [ 'middleware' => 'auth' ], function() {
    Route::get( '/', function () {
        return view( 'welcome' );
    } );
} );
