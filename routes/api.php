<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('books/upload', [BooksController::class, 'upload']);
Route::get('/titles/{title}', [DashboardController::class, 'filteredBooks']);
Route::get('/titles', [DashboardController::class, 'titles']);

