<?php

use App\Http\Controllers\AuthController;
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

Route::get('/register', function () {
    return view('register');
});
Route::get('/home', [AuthController::class, 'index']);
Route::post('/register/create', [AuthController::class, 'register']);
Route::get('emailConfirmation/{email}/{hash}', [AuthController::class, 'verify']);
Route::get('/login', function () {
    if (session()->has('user_id')) {
        return redirect('home');
    }
    return view('login');
});
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', function () {
    if (session()->has('user_id')) {
        session()->flush();
    }
    return redirect('login');
});
