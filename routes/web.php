<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiagnosController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ImagesController;
use Illuminate\Support\Facades\Artisan;
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

Route::middleware(['guest:web', 'preventBackHistory'])->name('auth.')->group(function () {
    Route::get('/', [AuthController::class,'index'])->name('form');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');


Route::middleware(['auth:web', 'preventBackHistory','authenticatedUser'])->name('admin.')->group(function () {
    Route::get('admin',[EmployeeController::class,'index'])->name('index');
    Route::get('employee/create',[EmployeeController::class,'create'])->name('create');
    Route::post('employee/store',[EmployeeController::class,'store'])->name('store');
    Route::get('employee/edit/{employee}',[EmployeeController::class,'edit']);
    Route::post('employee/list',[EmployeeController::class,'list']);
    // diagnosis record
    Route::get('employee/diagnosis/{employee}',[DiagnosController::class,'index']);
    Route::post('employee/diagnosis/store',[DiagnosController::class,'store']);
    Route::post('employee/diagnosis/{id}/list',[DiagnosController::class,'list']);
    Route::get('employee/diagnosis/{diagnos}/edit',[DiagnosController::class,'edit']);
    Route::get('employee/diagnosis/{diagnos}/print',[DiagnosController::class,'print']);
    // images record
    Route::post('employee/images/store',[ImagesController::class,'store']);
    Route::get('employee/images/{id}/list',[ImagesController::class,'list']);
    Route::delete('employee/images/{images}/delete',[ImagesController::class,'destroy']);

});

Route::get('/clear', function () { //-> tawagin mo to url sa browser -> 127.0.0.1:8000/clear
    Artisan::call('view:clear'); //   -> Clear all compiled files
    Artisan::call('route:clear'); //  -> Remove the route cache file 
    Artisan::call('optimize:clear'); //-> Remove the cache bootstrap files
    Artisan::call('event:clear'); //   -> clear all cache events and listener
    Artisan::call('config:clear'); //  -> Remove the configuration cache file
    Artisan::call('cache:clear'); //   -> Flush the application cache
    return back();
});


