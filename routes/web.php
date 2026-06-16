<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hobi', function () {
    return 'Aku suka bermain bola dan belajar koding! ⚽💻';
});

Route::get('/makanan', function () {
    return 'Selamat datang! Makanan favoritku adalah Pizza dan Es Krim! 🍕🍦';
});

Route::get('/minuman', function () {
    return 'Selamat datang! Minuman favoritku adalah Es Teh Manis dan Es Kopi Caramel Macchiato ☕';
});

