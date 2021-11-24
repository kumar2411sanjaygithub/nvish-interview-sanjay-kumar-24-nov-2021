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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});
Route::get('crop-image-upload', 'CropImageController@index');
Route::post('crop-image-upload ', 'CropImageController@uploadCropImage');

// Route::get('/', function () {
//     // return view('auth.login');
//     $visits = Redis::incr('visits');
//     return $visits;
// });