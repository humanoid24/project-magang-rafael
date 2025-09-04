<?php

use App\Http\Controllers\AdminPPICController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');

// Register
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register/action', [AuthController::class, 'actionRegister'])->name('actionRegister');


// Login
Route::post('actionlogin', [AuthController::class, 'actionLogin'])->name('actionLogin');
Route::get('actionlogout', [AuthController::class, 'actionLogout'])->name('actionLogout')->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::resource('/dashboard', ReportController::class);
    Route::resource('/ppic', AdminPPICController::class);

    Route::get('/ppic-janfar', [AdminPPICController::class, 'janfar'])->name('ppic.janfar');
    Route::get('/ppic-janfar', [AdminPPICController::class, 'lihatsemuadatajanfar'])->name('ppic.janfar');

    Route::get('/ppic-sawing', [AdminPPICController::class, 'sawing'])->name('ppic.sawing');
    Route::get('/ppic-sawing', [AdminPPICController::class, 'lihatsemuadatasawing'])->name('ppic.sawing');

    Route::get('/ppic-cutting', [AdminPPICController::class, 'cutting'])->name('ppic.cutting');
    Route::get('/ppic-cutting', [AdminPPICController::class, 'lihatsemuadatacutting'])->name('ppic.cutting');

    Route::get('/ppic-bending', [AdminPPICController::class, 'bending'])->name('ppic.bending');
    Route::get('/ppic-bending', [AdminPPICController::class, 'lihatsemuadatabending'])->name('ppic.bending');

    Route::get('/ppic-press', [AdminPPICController::class, 'press'])->name('ppic.press');
    Route::get('/ppic-press', [AdminPPICController::class, 'lihatsemuadatapress'])->name('ppic.press');

    Route::get('/ppic-racking', [AdminPPICController::class, 'racking'])->name('ppic.racking');
    Route::get('/ppic-racking', [AdminPPICController::class, 'lihatsemuadataracking'])->name('ppic.racking');

    Route::get('/ppic-rollforming', [AdminPPICController::class, 'rollforming'])->name('ppic.rollforming');
    Route::get('/ppic-rollforming', [AdminPPICController::class, 'lihatsemuadatarollforming'])->name('ppic.rollforming');

    Route::get('/ppic-spotwelding', [AdminPPICController::class, 'spotwelding'])->name('ppic.spotwelding');
    Route::get('/ppic-spotwelding', [AdminPPICController::class, 'lihatsemuadataspotwelding'])->name('ppic.spotwelding');

    Route::get('/ppic-weldingaccesoris', [AdminPPICController::class, 'weldingaccesoris'])->name('ppic.weldingaccesoris');
    Route::get('/ppic-weldingaccesoris', [AdminPPICController::class, 'lihatsemuadataweldingaccesoris'])->name('ppic.weldingaccesoris');

    Route::get('/ppic-weldingshofiting1', [AdminPPICController::class, 'weldingshofiting1'])->name('ppic.weldingshofiting1');
    Route::get('/ppic-weldingshofiting1', [AdminPPICController::class, 'lihatsemuadataweldingshofiting1'])->name('ppic.weldingshofiting1');

    Route::get('/ppic-weldingshofiting2', [AdminPPICController::class, 'weldingshofiting2'])->name('ppic.weldingshofiting2');
    Route::get('/ppic-weldingshofiting2', [AdminPPICController::class, 'lihatsemuadataweldingshofiting2'])->name('ppic.weldingshofiting2');

    Route::get('/ppic-weldingdoor', [AdminPPICController::class, 'weldingdoor'])->name('ppic.weldingdoor');
    Route::get('/ppic-weldingdoor', [AdminPPICController::class, 'lihatsemuadataweldingdoor'])->name('ppic.weldingdoor');



});

