<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/prestadores', function () {
    return view('purveyors.purveyorsList');
})->name('purveyors.purveyorsList');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');