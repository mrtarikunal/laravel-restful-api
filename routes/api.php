<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//api auth ise token bazlı doğrulama ister. bunun için user tablosunda api_token kolonu olştrdk

Route::middleware('auth.basic')->get('/user-basic', function (Request $request) {
    return $request->user();
});
//basic authenticaiton da session bilgisi tutar. kullanıcı email ve şifre siter girerken
Route::get('/merhaba', function () {
    return "Merhaba Restful Api";
});
Route::get('/users', function () {
    return factory(User::class, 10)->make();
});

Route::get('/categories/custom1', 'Api\CategoryController@custom1');
Route::get('/products/custom1', 'Api\ProductController@custom1');
Route::get('/products/custom2', 'Api\ProductController@custom2');
Route::get('/categories/report1', 'Api\CategoryController@report1');
Route::get('/users/custom1', 'Api\UserController@custom1');
Route::get('/products/custom3', 'Api\ProductController@custom3');
Route::get('/products/listwithcategories', 'Api\ProductController@listwithcategories');

Route::post('/auth/login', 'Api\AuthController@login');
//dinamik token oluşturma

Route::post('/upload', 'Api\UploadController@upload');


Route::middleware('api-token')->group(function () {
    Route::get('/auth/token', function (Request $request) {
        $user = $request->user();
        return response()->json([
            'name' => $user->name,
            'access_token' => $user->api_token,
            'time' => time()
        ], 401);
    });
});
//bearer token uygulaması. kendi middleware tanımladık ApiToken.php


//Route::apiResource('/products', 'Api\ProductController');
//Route::apiResource('/users', 'Api\UserController');

Route::middleware(['auth:api', 'throttle:rate_limit,1'])->group(function () {
    //user tablosunda rate_limit kolonu oluştrdk. orda verdiğimiz değerler buraya gelir. o değere göre bir dk yapacağı isyeği
    //kullanıcı bazlı ayarladık.
    Route::apiResources([
        'products' => 'Api\ProductController',
        'users' => 'Api\UserController',
        'categories' => 'Api\CategoryController'
    ]);
});

Route::middleware('throttle:5|10,1')->group(function () {
    //kullanıcı girişi yapmamış kullanıcılar 1dk 5 istek, giriş yapmış olanlar 10 istek yapablr
    Route::get('/throttle-guest', function () {
        return 'throttle guest test';
    });

    Route::get('/throttle-auth', function (Request $request) {
        return 'throttle auth test';
    })->middleware('auth:api');
});

/*
Route::middleware('throttle:5|rate_limit,1')->group(function () {
    //kullanıcı girişi yapmamış kullanıcılar 1dk 5 istek, giriş yapmış olanlar kullanıcı tablosundaki rate_limit kolonuna göre istek yapablr
    Route::get('/throttle-guest', function () {
        return 'throttle guest test';
    });

    Route::get('/throttle-auth', function (Request $request) {
        return 'throttle auth test';
    })->middleware('auth:api');
});
*/

