<?php

use App\Http\Controllers\admin\ResultsController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\CategoriesController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\QuestionsController;
use App\Http\Controllers\admin\ScanController;
use App\Http\Controllers\admin\RoleController;

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



Route::post('search', [DashboardController::class,'search'])->name('search');

Route::get('', [DashboardController::class,'index'])->name('admin');

Route::get('categories/trashed',[CategoriesController::class,'trashed'])->name('categories.trashed');
Route::post('categories/trashed/update/{id}',[CategoriesController::class,'updateTrashed'])->name('categories.updateTrashed');
Route::resource('categories', CategoriesController::class);

Route::get('questions/trashed',[QuestionsController::class,'trashed'])->name('questions.trashed');
Route::post('questions/trashed/update/{id}',[QuestionsController::class,'updateTrashed'])->name('questions.updateTrashed');
Route::resource('questions', QuestionsController::class);

Route::get('results/trashed',[ResultsController::class,'trashed'])->name('results.trashed');
Route::post('results/trashed/update/{id}',[ResultsController::class,'updateTrashed'])->name('results.updateTrashed');
Route::resource('results', ResultsController::class);

//scan routes
Route::get('scan/trashed',[ScanController::class,'trashed'])->name('scan.trashed');
Route::post('scan/trashed/update/{id}',[ScanController::class,'updateTrashed'])->name('scan.updateTrashed');
Route::resource('scan',ScanController::class);

Route::get('user/trashed',[UserController::class,'trashed'])->name('user.trashed');
Route::post('user/trashed/update/{id}',[UserController::class,'updateTrashed'])->name('user.updateTrashed');
Route::resource('user',UserController::class);

Route::resource('roles',RoleController::class);
