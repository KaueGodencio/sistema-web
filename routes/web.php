<?php

use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('pedidos.index');
});

Route::resource('fornecedores', FornecedorController::class);
Route::resource('produtos', ProdutoController::class);
Route::resource('pedidos', PedidoController::class);
