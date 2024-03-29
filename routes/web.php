<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerolaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/perolas', [PerolaController::class, 'index']);
Route::post('/atualizar-perola', [PerolaController::class, 'atualizarPerola']);
Route::post('/calcular-perolas-necessarias', [PerolaController::class, 'calcularOrdemForja']);

