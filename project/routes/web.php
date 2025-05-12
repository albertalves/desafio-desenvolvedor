<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    FileDataController,
    FileHistoryController,
};

Route::resource('fileHistory', FileHistoryController::class);

Route::controller(FileDataController::class)->group(function () {
    Route::get('/', 'index')->name('file-data.index');
    Route::post('/import', 'import')->name('file-data.import');
    Route::get('/data', 'getList')->name('file-data.list');
});



