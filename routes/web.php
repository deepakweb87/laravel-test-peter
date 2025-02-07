<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubmissionController;

Route::view('/', 'home')->name('home');
Route::view('services', 'services')->name('services');
Route::view('about', 'about')->name('about');
Route::view('contact', 'contact')->name('contact');

Route::post('/submissions', [SubmissionController::class, 'store']);
