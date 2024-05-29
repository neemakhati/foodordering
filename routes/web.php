<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
Route::get('/',[HomeController::class, 'index']);
Route::get('/about',[HomeController::class, 'about']);
Route::get('/redirects', [HomeController::class, 'redirects']);

Route::get('/redirectsuser', [HomeController::class, 'redirectsuser']);
//Route::get('/dashboard', function () {
//    return redirect('/redirects');
//})->name('dashboard');
//Route::middleware([
//    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified',
//])->group(function () {
//    Route::get('/dashboard', function () {
//        return redirect('/redirects');
//    })->name('dashboard');
//});
Route::post('/addcart/{id}', [HomeController::class, 'addcart']);
Route::get('/showcart/{id}', [HomeController::class, 'showcart']);
Route::get('/deletecart/{id}', [HomeController::class, 'deletecart']);
Route::get('/search', [HomeController::class, 'search'])->name('food.search');
Route::get('/reservation', [HomeController::class, 'reservation']);
Route::post('/checkout', [HomeController::class, 'checkout']);

Route::get('/category/{slug}',[CategoryController::class, 'bakery'])->name('category.view');
Route::get('/appetizer',[CategoryController::class, 'appetizer']);
Route::get('/dessert',[CategoryController::class, 'dessert']);


Route::post('/contact', [HomeController::class, 'sendEmail'])->name('contact.send');
Route::post('/ordermail', [HomeController::class, 'ordermail']);
Route::get('/myorderlist', [HomeController::class, 'myorderlist']);


Route::post('/signup',[HomeController::class,'signup'])->name('signup');
Route::post('/signin',[HomeController::class,'signin'])->name('signin');
Route::get('/signup', [HomeController::class, 'showSignupForm'])->name('signup.form');
Route::get('/signin', [HomeController::class, 'showSigninForm'])->name('signin.form');

Route::post('/adminlog',[HomeController::class,'adminlog'])->name('adminsignin');
Route::get('/adminlog', [HomeController::class, 'adminshowSigninForm'])->name('adminsignin.form');


Route::get('/foodMenu', [AdminController::class, 'foodMenu']);
Route::post('/uploadfood', [AdminController::class, 'upload']);
Route::get('/deletefood/{id}', [AdminController::class, 'deletefood']);
Route::get('/updateview/{id}', [AdminController::class, 'updateview']);
Route::post('/update/{id}', [AdminController::class, 'update']);




Route::get('/categoryMenu', [AdminController::class, 'categoryMenu']);
Route::post('/uploadcategory', [AdminController::class, 'uploadcategory']);
Route::get('/deletecategory/{id}', [AdminController::class, 'deletecategory']);
Route::get('/updatecategory/{id}', [AdminController::class, 'updatecategory']);
Route::post('/updatecat/{id}', [AdminController::class, 'updatecat']);
Route::get('/orders', [AdminController::class,'orders']);
Route::get('/users', [AdminController::class,'users']);
