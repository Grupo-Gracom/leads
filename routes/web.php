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
            Route::get('/', 'AdminController@index');
            //DASHBOARD
            //BANNERS
            Route::get('/banners', 'BannerController@index');
            Route::get('/banners-list', 'BannerController@list');
            Route::get('/banners/{id}', 'BannerController@show');
            Route::post('/banners', 'BannerController@store');
            Route::post('/banners/{id}', 'BannerController@update');
            Route::delete('/banners/{id}', 'BannerController@destroy');
            //GALERIA
            Route::get('/galeria', 'GaleriaController@index');
            Route::get('/galeria-list', 'GaleriaController@list');
            Route::get('/galeria/{id}', 'GaleriaController@show');
            Route::post('/galeria', 'GaleriaController@store');
            Route::post('/galeria/{id}', 'GaleriaController@update');
            Route::delete('/galeria/{id}', 'GaleriaController@destroy');
            //DEPOIMENTOS
            Route::get('/depoimentos', 'DepoimentoController@index');
            Route::get('/depoimentos-list', 'DepoimentoController@list');
            Route::get('/depoimentos/{id}', 'DepoimentoController@show');
            Route::post('/depoimentos', 'DepoimentoController@store');
            Route::post('/depoimentos/{id}', 'DepoimentoController@update');
            Route::delete('/depoimentos/{id}', 'DepoimentoController@destroy');
            //POSTS
            Route::get('/posts', 'PostController@index');
            Route::get('/posts-list', 'PostController@list');
            Route::get('/posts/{id}', 'PostController@show');
            Route::post('/posts', 'PostController@store');
            Route::post('/posts/{id}', 'PostController@update');
            Route::delete('/posts/{id}', 'PostController@destroy');
            //ALUNOS
            
            
            //UNIDADES
            Route::get('/unidades', 'UnidadeController@index');
            Route::get('/unidades-list', 'UnidadeController@list');
            Route::get('/unidades/{id}', 'UnidadeController@show');
            Route::post('/unidades', 'UnidadeController@store');
            Route::post('/unidades/{id}', 'UnidadeController@update');
            Route::delete('/unidades/{id}', 'UnidadeController@destroy');


            Route::get('/logout', function(){
                Auth::logout();
                return Redirect::to('/login');
            });
        });
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
