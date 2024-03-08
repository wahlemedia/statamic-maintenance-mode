<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Wahlemedia\StatamicMaintenanceMode\Http\Controllers\CP\MaintainanceModeController;

Route::prefix('utilities/maintenance/')
    ->name('wahlemedia.maintenance.settings.')
    ->group(function () {
        Route::get('/', [MaintainanceModeController::class, 'index'])->name('index');
        Route::post('/', [MaintainanceModeController::class, 'update'])->name('update');
    });
