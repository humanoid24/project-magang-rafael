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
    Route::get('/ppic/import', [AdminPPICController::class, 'importCreate'])->name('ppic.import.form');
    Route::post('/ppic/import', [AdminPPICController::class, 'import'])->name('ppic.import.process');
    Route::resource('/ppic', AdminPPICController::class);
    Route::get('/ppic/user/show', [AdminPPICController::class, 'indexUser'])->name('ppic.index.user');
    Route::delete('/ppic/delete/user/{$id}',[AdminPPICController::class, 'destroyUser'])->name('ppic.delete.user');

    Route::get('/ppic-janfar', [AdminPPICController::class, 'janfar'])->name('ppic.janfar');
    Route::get('/ppic-janfar/filterdata', [AdminPPICController::class, 'lihatsemuadatajanfar'])->name('ppic.janfar.filter');
    Route::get('/ppic/janfar/export', [AdminPPICController::class, 'exportJanfar'])->name('ppic.export.janfar');
    Route::delete('/ppic/janfar/delete', [AdminPPICController::class, 'deleteJanfar'])->name('ppic.delete.janfar');


    Route::get('/ppic-sawing', [AdminPPICController::class, 'sawing'])->name('ppic.sawing');
    Route::get('/ppic-sawing/filterdata', [AdminPPICController::class, 'lihatsemuadatasawing'])->name('ppic.sawing.filter');
    Route::get('/ppic/sawing/export', [AdminPPICController::class, 'exportSawing'])->name('ppic.export.sawing');
    Route::delete('/ppic/sawing/delete', [AdminPPICController::class, 'deleteSawing'])->name('ppic.delete.sawing');



    Route::get('/ppic-cutting', [AdminPPICController::class, 'cutting'])->name('ppic.cutting');
    Route::get('/ppic-cutting/filterdata', [AdminPPICController::class, 'lihatsemuadatacutting'])->name('ppic.cutting.filter');
    Route::get('/ppic/cutting/export', [AdminPPICController::class, 'exportCutting'])->name('ppic.export.cutting');
    Route::delete('/ppic/cutting/delete', [AdminPPICController::class, 'deleteCutting'])->name('ppic.delete.cutting');



    Route::get('/ppic-bending', [AdminPPICController::class, 'bending'])->name('ppic.bending');
    Route::get('/ppic-bending/filterdata', [AdminPPICController::class, 'lihatsemuadatabending'])->name('ppic.bending.filter');
    Route::get('/ppic/bending/export', [AdminPPICController::class, 'exportBending'])->name('ppic.export.bending');
    Route::delete('/ppic/bending/delete', [AdminPPICController::class, 'deleteBending'])->name('ppic.delete.bending');



    Route::get('/ppic-press', [AdminPPICController::class, 'press'])->name('ppic.press');
    Route::get('/ppic-press/filterdata', [AdminPPICController::class, 'lihatsemuadatapress'])->name('ppic.press.filter');
    Route::get('/ppic/press/export', [AdminPPICController::class, 'exportPress'])->name('ppic.export.press');
    Route::delete('/ppic/press/delete', [AdminPPICController::class, 'deletePress'])->name('ppic.delete.press');



    Route::get('/ppic-racking', [AdminPPICController::class, 'racking'])->name('ppic.racking');
    Route::get('/ppic-racking/filterdata', [AdminPPICController::class, 'lihatsemuadataracking'])->name('ppic.racking.filter');
    Route::get('/ppic/racking/export', [AdminPPICController::class, 'exportRacking'])->name('ppic.export.racking');
    Route::delete('/ppic/racking/delete', [AdminPPICController::class, 'deleteRacking'])->name('ppic.delete.racking');



    Route::get('/ppic-rollforming', [AdminPPICController::class, 'rollforming'])->name('ppic.rollforming');
    Route::get('/ppic-rollforming/filterdata', [AdminPPICController::class, 'lihatsemuadatarollforming'])->name('ppic.rollforming.filter');
    Route::get('/ppic/rollforming/export', [AdminPPICController::class, 'exportrollForming'])->name('ppic.export.rollforming');
    Route::delete('/ppic/rollforming/delete', [AdminPPICController::class, 'deleteRollForming'])->name('ppic.delete.rollforming');



    Route::get('/ppic-spotwelding', [AdminPPICController::class, 'spotwelding'])->name('ppic.spotwelding');
    Route::get('/ppic-spotwelding/filterdata', [AdminPPICController::class, 'lihatsemuadataspotwelding'])->name('ppic.spotwelding.filter');
    Route::get('/ppic/spotwelding/export', [AdminPPICController::class, 'exportSpotWelding'])->name('ppic.export.spotwelding');
    Route::delete('/ppic/spotwelding/delete', [AdminPPICController::class, 'deleteSpotWelding'])->name('ppic.delete.spotwelding');



    Route::get('/ppic-weldingaccesoris', [AdminPPICController::class, 'weldingaccesoris'])->name('ppic.weldingaccesoris');
    Route::get('/ppic-weldingaccesoris/filterdata', [AdminPPICController::class, 'lihatsemuadataweldingaccesoris'])->name('ppic.weldingaccesoris.filter');
    Route::get('/ppic/weldingaccesoris/export', [AdminPPICController::class, 'exportWeldingAccesoris'])->name('ppic.export.weldingaccesoris');
    Route::delete('/ppic/weldingaccesoris/delete', [AdminPPICController::class, 'deleteWeldingAccesoris'])->name('ppic.delete.weldingaccesoris');



    Route::get('/ppic-weldingshofiting1', [AdminPPICController::class, 'weldingshofiting1'])->name('ppic.weldingshofiting1');
    Route::get('/ppic-weldingshofiting1/filterdata', [AdminPPICController::class, 'lihatsemuadataweldingshofiting1'])->name('ppic.weldingshofiting1.filter');
    Route::get('/ppic/weldingshofiting1/export', [AdminPPICController::class, 'exportWeldingShofiting1'])->name('ppic.export.weldingshofiting1');
    Route::delete('/ppic/weldingshofitirng1/delete', [AdminPPICController::class, 'deleteWeldingShofiting1'])->name('ppic.delete.weldingshofiting1');



    Route::get('/ppic-weldingshofiting2', [AdminPPICController::class, 'weldingshofiting2'])->name('ppic.weldingshofiting2');
    Route::get('/ppic-weldingshofiting2/filterdata', [AdminPPICController::class, 'lihatsemuadataweldingshofiting2'])->name('ppic.weldingshofiting2.filter');
    Route::get('/ppic/weldingshofiting2/export', [AdminPPICController::class, 'exportWeldingShofiting2'])->name('ppic.export.weldingshofiting2');
    Route::delete('/ppic/weldingshofiting2/delete', [AdminPPICController::class, 'deleteWeldingShofiting2'])->name('ppic.delete.weldingshofiting2');



    Route::get('/ppic-weldingdoor', [AdminPPICController::class, 'weldingdoor'])->name('ppic.weldingdoor');
    Route::get('/ppic-weldingdoor/filterdata', [AdminPPICController::class, 'lihatsemuadataweldingdoor'])->name('ppic.weldingdoor.filter');
    Route::get('/ppic/weldingdoor/export', [AdminPPICController::class, 'exportWeldingDoor'])->name('ppic.export.weldingdoor');
    Route::delete('/ppic/weldingdoor/delete', [AdminPPICController::class, 'deleteWeldingDoor'])->name('ppic.delete.weldingdoor');
});

