<?php

use App\Helpers\EmailHelper;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\RaportagePdfController;
use App\Http\Controllers\ResultsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConsulentController;
use Illuminate\Support\Facades\Auth;

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

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::group(['middleware' => ['level:1']], function () {
        Route::get('/consultant/detach/{user}', [AccountController::class, 'DetachConsultant']);
        Route::post('consulent.store', [ConsulentController::class, 'store'])->name('consulent.store');
        Route::post('consulent.add', [ConsulentController::class, 'add'])->name('consulent.add');
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::resource('export', ExportController::class);
        Route::post('scan/{scan}',[ScanController::class,'show'])->name('scan.show');
        Route::post('/export/{result}', [RaportagePdfController::class, 'export'])->name('exportpdf');
        Route::post('scan/',[ScanController::class,'show'])->name('scan.show');
        Route::post('saveExport', [ExportController::class, 'export'])->name('saveExport');
        Route::resource('results', ResultsController::class);
        Route::resource('scan', ScanController::class);
        Route::post('answers/export', [ExportController::class, 'downloadExport'])->name('answers.export');
        Route::post('results/json/', [ExportController::class, 'json'])->name('results.json');
        Route::resource('account', AccountController::class);
        Route::group(['middleware' => ['level:2']], function () {
            Route::resource('consulent', ConsulentController::class);
            Route::post('consulent.accept', [ConsulentController::class, 'accept'])->name('consulent.accept');
            Route::post('consulent.recover', [ConsulentController::class, 'accept'])->name('consulent.recover');
            Route::post('consulent.remove', [ConsulentController::class, 'remove'])->name('consulent.remove');
            Route::post('consulent.updatePassword', [ConsulentController::class, 'updatePassword'])->name('consulent.updatePassword');
        });
//        Route::group(['middleware' => ['level:4']], function () {
//            Route::get('company', [CompanyController::class, 'index'])->name('company.index');
//            Route::post('company/store', [CompanyController::class, 'store'])->name('company.store');
//            Route::get('company/user/{id}', [CompanyController::class, 'show'])->name('company.show');
//            Route::put('company/user/update', [CompanyController::class, 'update'])->name('company.update');
//            Route::get('company/customers', [CompanyController::class, 'customers'])->name('company.customers');
//            Route::post('company/{user}/link', [CompanyController::class, 'link'])->name('company.link');
//            Route::post('company/{user}/linkDestroy', [CompanyController::class, 'linkDestroy'])->name('company.linkDestroy');
//        });
    });
});




