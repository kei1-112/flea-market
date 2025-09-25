<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MyListController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\EmailVerificationController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

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

Route::get('/', [ItemController::class, 'index']);
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [AuthenticatedSessionController  ::class, 'destroy']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');

Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');

Route::get('/item:{itemId}', [ItemController::class, 'detail']);
Route::get('/search', [ItemController::class, 'search'])->name('search');
Route::middleware('auth')->group(function(){
    Route::get('/purchase', [ItemController::class, 'purchase']);
});
Route::middleware('auth')->group(function(){
    Route::post('/purchase', [OrderController::class, 'storePurchase']);
});
Route::middleware('auth')->group(function(){
    Route::get('/purchase/address', [OrderController::class, 'updateAddress']);
});
Route::middleware('auth')->group(function(){
    Route::get('/sell', [ItemController::class, 'sell']);
});
Route::middleware('auth')->group(function(){
    Route::post('/sell', [ItemController::class, 'storeSell']);
});
Route::middleware('auth')->group(function(){
    Route::get('/mypage', [UserController::class, 'showProfile']);
});
Route::middleware('auth')->group(function(){
    Route::get('/mypage/profile', [UserController::class, 'setProfile']);
});

Route::middleware('auth')->group(function(){
    Route::post('/mypage/profile', [UserController::class, 'update']);
});

Route::middleware('auth')->group(function(){
    Route::post('/mylists', [MyListController::class, 'store']);
});

Route::middleware('auth')->group(function(){
    Route::delete('/mylists', [MyListController::class, 'destroy']);
});

Route::middleware('auth')->group(function(){
    Route::post('/comments', [CommentController::class, 'store']);
});