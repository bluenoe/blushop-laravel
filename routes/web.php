<?php 
 
 use Illuminate\Support\Facades\Route; 
 
 Route::get('/', fn () => view('welcome'))->name('home'); 
 
 // 👇 Thêm dashboard để các test auth khỏi lỗi 
 Route::get('/dashboard', fn () => view('welcome'))->middleware(['auth'])->name('dashboard'); 
 
 // 👇 Nhớ include auth routes của Breeze 
 require __DIR__.'/auth.php';
