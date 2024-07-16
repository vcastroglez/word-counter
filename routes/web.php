<?php

use App\Http\Controllers\WikiReaderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WikiReaderController::class, 'index']);
