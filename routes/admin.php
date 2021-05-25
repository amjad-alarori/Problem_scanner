<?php

use App\Http\Controllers\admin\AppConfigController;
use App\Http\Controllers\admin\CompanyController;
use App\Http\Controllers\admin\EmailComponentTranslationController;
use App\Http\Controllers\admin\EmailTranslationController;
use App\Http\Controllers\admin\ResultsController;
use App\Http\Controllers\ConsulentController;
use App\Http\Controllers\admin\LanguagesController;
use App\Http\Controllers\admin\TranslationsController;
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

Route::get('/404', function () {
    return view('errors.404');
});

Route::get('/search/auto', [\App\Http\Controllers\admin\SearchController::class, 'autoComplete']);
Route::get('/search/full', [\App\Http\Controllers\admin\SearchController::class, 'searchFull']);

Route::get('', [DashboardController::class, 'index'])->name('admin');

Route::get('categories/trashed', [CategoriesController::class, 'trashed'])->name('categories.trashed');
Route::post('categories/trashed/update/{id}', [CategoriesController::class, 'updateTrashed'])->name('categories.updateTrashed');
Route::resource('categories', CategoriesController::class);

Route::get('questions/trashed', [QuestionsController::class, 'trashed'])->name('questions.trashed');
Route::post('questions/trashed/update/{id}', [QuestionsController::class, 'updateTrashed'])->name('questions.updateTrashed');
Route::resource('questions', QuestionsController::class);

Route::get('results/trashed', [ResultsController::class, 'trashed'])->name('results.trashed');
Route::post('results/trashed/update/{id}', [ResultsController::class, 'updateTrashed'])->name('results.updateTrashed');
Route::resource('results', ResultsController::class);

//scan routes
Route::get('scan/trashed', [ScanController::class, 'trashed'])->name('scan.trashed');
Route::post('scan/trashed/update/{id}', [ScanController::class, 'updateTrashed'])->name('scan.updateTrashed');
Route::resource('scan', ScanController::class);

Route::post('user/{user}/link',[UserController::class,'link'])->name('user.link');
Route::post('user/{user}/linkDestroy',[UserController::class,'linkDestroy'])->name('user.linkDestroy');
Route::get('user/trashed', [UserController::class, 'trashed'])->name('user.trashed');
Route::post('user/trashed/update/{id}', [UserController::class, 'updateTrashed'])->name('user.updateTrashed');
Route::post('user/trashed',[UserController::class, 'hardDelete'])->name('user.hardDelete');
Route::resource('user', UserController::class);
Route::post('consulent.destroy',[ConsulentController::class,'destroy'])->name('consulent.destroy');

Route::resource('roles', RoleController::class);

Route::resource('emailtranslations', EmailTranslationController::class, [
    'names' => [
        'index' => 'emailtranslation.index',
        'store' => 'emailtranslation.store',
        'edit' => 'emailtranslation.edit',
        'update' => 'emailtranslation.update',
    ]
])->except('create', 'destroy');
Route::get('emailtranslations/{emailtranslation}/preview', [EmailTranslationController::class, 'preview'])->name('emailtranslation.preview');
Route::get('emailtranslations/{emailtranslation}/previewframe', [EmailTranslationController::class, 'previewFrame'])->name('emailtranslation.previewframe');
Route::get('emailtranslations/{emailtranslation}/delete', [EmailTranslationController::class, 'destroy'])->name('emailtranslation.destroy');

Route::resource('appconfigs', AppConfigController::class, [
    'names' => [
        'index' => 'appconfig.index',
        'store' => 'appconfig.store',
    ]
])->only(['index', 'store']);

Route::resource('emailcomponenttranslations', EmailComponentTranslationController::class, [
    'names' => [
        'index' => 'emailcomponenttranslation.index',
        'store' => 'emailcomponenttranslation.store',
        'edit' => 'emailcomponenttranslation.edit',
        'update' => 'emailcomponenttranslation.update',
    ]
])->except('create', 'destroy');
Route::get('emailcomponenttranslations/{emailcomponenttranslation}/delete', [EmailComponentTranslationController::class, 'destroy'])->name('emailcomponenttranslation.destroy');

Route::resource('languages', LanguagesController::class)->only('index', 'store', 'update', 'destroy');
Route::prefix('languages/{languages}')->group(function () {
    Route::resource('translations', TranslationsController::class)->only('index', 'store', 'destroy', 'update');
});
