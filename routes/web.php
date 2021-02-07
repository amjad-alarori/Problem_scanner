<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\CategoriesController;
use App\Http\Controllers\admin\QuestionsController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ResultsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConsulentController;

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


Route::get('/404', function () {
    return view('errors.404');
});

Auth::routes(['verify'=>true]);

Route::group(['middleware' => ['auth','verified']], function () {
    Route::get('/', function () {
        return view('home');
    });
    Route::group(['middleware' => ['level:1']], function () {
        Route::post('consulent.add',[ConsulentController::class,'add'])->name('consulent.add');
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::resource('export', ExportController::class);
        Route::post('saveExport', [ExportController::class, 'export'])->name('saveExport');
        Route::resource('results', ResultsController::class);
        Route::resource('scan',ScanController::class);
        Route::post('answers/export',[ExportController::class,'downloadExport'])->name('answers.export');
        Route::post('results/json/',[ExportController::class,'json'])->name('results.json');
        Route::resource('account',AccountController::class);
        Route::group(['middleware' => ['level:2']], function () {
        Route::resource('consulent',ConsulentController::class);
        Route::post('consulent.accept',[ConsulentController::class,'accept'])->name('consulent.accept');
        Route::post('consulent.recover',[ConsulentController::class,'accept'])->name('consulent.recover');
        Route::post('consulent.remove',[ConsulentController::class,'remove'])->name('consulent.remove');
        });
    });
});




