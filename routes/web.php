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
    return view('welcome');
});
Route::get('/listen', function () {
    return view('pusher-test');
});
Route::get('test', function () {
    event(new App\Events\StatusLiked('Someone'));
    return "Order has been sent!";
});
Route::get('test/new', function () {
    event(new App\Events\MyEvent('You Have Three New Orders!'));
});