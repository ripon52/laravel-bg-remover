<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\BackgroundRemoverController;


Route::get('/', function () {
    return view('welcome');
});

Route::post("image-bg-remove",[BackgroundRemoverController::class,"removeBackground"])->name("image.bg.remove");


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
