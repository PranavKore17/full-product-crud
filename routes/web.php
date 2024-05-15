<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\NotificationController;

Route::middleware(['preventBack'])->group(function(){

Route::middleware(['isLoggedIn'])->group(function(){


Route::get('/index',[ProductController::class,'index'])->name('products.index');

Route::get('/products/create',[ProductController::class,'create'])->name('products.create');

Route::post('/products/store',[ProductController::class,'store'])->name('products.store');

Route::get('/products/edit/{id}',[ProductController::class,'edit'])->name('products.edit');

Route::get('/products/destroy/{id}',[ProductController::class,'destroy'])->name('products.destroy');

Route::get('/products/view/{id}',[ProductController::class,'view'])->name('products.view');

Route::get('/product_ajax',[ProductController::class,'product_ajax'])->name('product_ajax');


Route::post('/products/import',[ProductController::class,'import'])->name('products.import');

Route::get('/products/pdf',[ProductController::class,'pdf'])->name('products.pdf');

Route::post('/getState',[ProductController::class,'getState'])->name('getState');

Route::post('/getCity',[ProductController::class,'getCity'])->name('getCity');

Route::post('/statuschange',[ProductController::class,'status'])->name('products.status'); 
}) ;
});
Route::post('/exportproduct',[ProductController::class,'exportproduct'])->name('export-product')->middleware('isLoggedIn');


// ************************************************************************************************


Route::get('/',[CustomAuthController::class,'login'])->name('login')->middleware('alreadyLoggedIn') ;

Route::post('login-user',[CustomAuthController::class,'loginUser'])->name('login-user'); 

Route::get('registration',[CustomAuthController::class,'registration'])->name('registration')->middleware('alreadyLoggedIn');

Route::post('register-user',[CustomAuthController::class,'registerUser'])->name('register-user'); 

Route::get('dashboard',[CustomAuthController::class,'dashboard'])->name('dashboard')->middleware('isLoggedIn');

Route::get('logout',[CustomAuthController::class,'logout'])->name('logout'); 

//********************************************************************************************************************** */

Route::get('/notify',[NotificationController::class,'index']);

