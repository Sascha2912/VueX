<?php

use App\Http\Controllers\Api\ConstantController;
use Illuminate\Support\Facades\Route;

Route::get('/constants', [ConstantController::class, 'getConstants'])->name('constants');