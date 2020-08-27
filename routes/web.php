<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'BarangController@index')->name('barang.home');
Route::get('/getAllBarang', 'BarangController@getAllBarang')->name('barang.alldata');
Route::post('/store', 'BarangController@store')->name('barang.store');
Route::get('/{encrypt}', 'BarangController@show');
