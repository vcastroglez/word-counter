<?php

use App\Http\Controllers\WikiReaderController;
use App\Livewire\WordViewer;
use Illuminate\Support\Facades\Route;

Route::get('/', WordViewer::class);

Route::post('/add-more-words', [WikiReaderController::class, 'index']);
