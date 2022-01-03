<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;


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

Route::post('/import', [StockController::class, 'importCsv']);
Route::get('/export', [StockController::class, 'exportExcel']);
