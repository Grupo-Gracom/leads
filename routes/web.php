<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();
Route::get('/', 'LogarController@index');
Route::fallback(function () {
    return view("site.404");
});

/* rotas do admin */

Route::middleware(['admin'])->group(function(){
    Route::prefix("admin")->group(function(){
        Route::namespace("Admin")->group(function(){
            Route::get('/', 'AdminController@teste')->name('admin');
            //DASHBOARD
            //Leads Gracom
            Route::get('/gracom/{unidade?}', 'ApiController@gracom')->name('gracom');
            Route::get('/imugi/{unidade?}', 'ApiController@imugi')->name('imugi');
            Route::get('/logout', function(){
                Auth::logout();
                return Redirect::to('/login');
            });
        });
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
