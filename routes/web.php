<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/secured', function () {
   return "You are authenticated";
})->middleware('auth');

//Route::resource('/products', 'ProductController');
//Route::resource('/products', 'ProductController')->only(['index', 'update']);
//Route::resource('/products', 'ProductController')->except(['destroy']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/upload', 'HomeController@upload')->name('upload');
Route::get('/download/{fileName}', 'HomeController@download')->name('download');

