<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Lomkit\Export\Http\Controllers\ExportController;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::group(['as'=>'export.'], function() {
    Route::get('get/fields', [ExportController::class, 'fields'])->name('get.fields');
    Route::get('fields', [ExportController::class, 'exportAll'])->name('fields');
    Route::get('fields/{field}', [ExportController::class, 'exportField'])->name('field');
});
