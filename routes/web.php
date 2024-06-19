<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;



Route::get('/',[HomeController::class, 'index'])->name('home');
Route::get('/homein',[HomeController::class, 'invalidhome'])->name('invalidhome');
Route::post('/signin',[HomeController::class,'signin'])->name('signin');
Route::post('/signup',[HomeController::class,'signup'])->name('signup');
Route::get('/signup', [HomeController::class, 'showSignupForm'])->name('signup.form');
Route::get('/signin', [HomeController::class, 'showSigninForm'])->name('signin.form');
Route::get('/verify/{token}', [HomeController::class, 'verify']);
Route::get('/redirects', [HomeController::class, 'redirects']);
Route::get('/redirectsuser', [HomeController::class, 'redirectsuser']);


Route::middleware([EnsureEmailIsVerified::class])->group(function () {
    Route::get('/about',[HomeController::class, 'about']);
    Route::post('/addcart/{id}', [HomeController::class, 'addcart']);
    Route::get('/showcart/{id}', [HomeController::class, 'showcart']);
    Route::get('/deletecart/{id}', [HomeController::class, 'deletecart']);
    Route::get('/search', [HomeController::class, 'search'])->name('food.search');
    Route::get('/reservation', [HomeController::class, 'reservation']);

    Route::post('/contact', [HomeController::class, 'sendEmail'])->name('contact.send');
    Route::post('/ordermail', [HomeController::class, 'ordermail']);
    Route::get('/myorderlist', [HomeController::class, 'myorderlist']);
    Route::get('/category/{slug}',[CategoryController::class, 'bakery'])->name('category.view');
});

Route::get('/test',[HomeController::class,'testfunc']);

Route::post('/checkout', [HomeController::class, 'checkout']);
Route::post('/adminlog',[HomeController::class,'adminlog'])->name('adminsignin');
Route::get('/adminlog', [HomeController::class, 'adminshowSigninForm'])->name('adminsignin.form');
Route::get('/logout', [HomeController::class, 'logout']);

Route::get('/deletefood/{id}', [AdminController::class, 'deletefood']);
Route::get('/updateview/{id}', [AdminController::class, 'updateview']);
Route::post('/update/{id}', [AdminController::class, 'update']);
Route::get('/adminlogout',[AdminController::class,'adminlogout']);
Route::get('/categoryMenu', [AdminController::class, 'categoryMenu']);
Route::post('/uploadcategory', [AdminController::class, 'uploadcategory']);
Route::get('/deletecategory/{id}', [AdminController::class, 'deletecategory']);
Route::get('/updatecategory/{id}', [AdminController::class, 'updatecategory']);
Route::post('/updatecat/{id}', [AdminController::class, 'updatecat']);

Route::get('/orders', [AdminController::class,'orders']);
Route::get('/orders/count', [AdminController::class, 'getOrderCount']);
Route::get('/orders/details', [AdminController::class, 'getOrderDetails']);

Route::get('/pusher',function (){
    return view('pusher');
});


Route::get('/users', [AdminController::class,'users'])->name('users');
Route::get('/deleteuser/{id}', [AdminController::class, 'deleteUser'])->name('deleteuser');
Route::get('/addfood', [AdminController::class, 'showAddFoodForm']);
Route::post('/uploadfood', [AdminController::class, 'upload']);
Route::match(['get', 'post'], '/foodMenu', [AdminController::class, 'foodMenu']);
Route::get('/fetch-food-items', [AdminController::class, 'fetchFoodItems']);
Route::post('/uploadfood', [AdminController::class, 'uploadFood']);

Route::post('/uploadfoods', [AdminController::class, 'uploadFoods']);


Route::delete('/deletefood/{id}', [AdminController::class, 'destroy'])->name('deletefood');
Route::get('/fetch-food-item/{id}', [AdminController::class, 'fetchFoodItem']);
Route::post('/updatefood/{id}', [AdminController::class, 'updateFood']);

Route::get('/appetizer',[CategoryController::class, 'appetizer']);
Route::get('/dessert',[CategoryController::class, 'dessert']);

Route::get('/forgot-password',[ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password',[ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}',[ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('/reset-password',[ResetPasswordController::class,'reset'])->name('password.update');

