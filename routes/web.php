<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Route::get('/', function () {
//     return view('welcome');
// });

//rota da pagina principal
Route::get('/', [ProductController::class, 'index'])->name('index');

//rota para criar o produtos
Route::get('/create', [ProductController::class, 'create'])->name('create');
Route::post('store/', [ProductController::class, 'store'])->name('store');

// rota para vizualizar produto em específico
Route::get('show/{product}', [ProductController::class, 'show'])->name('show');

//rota para editar um produto em específico
Route::get('edit/{product}', [ProductController::class,'edit'])->name('edit');
Route::put('edit/{product}', [ProductController::class, 'update'])->name('update');

// rota para deletar o produto em específico
Route::get('/{product}',[ProductController::class ,'destroy'])->name('destroy');

//rota para apagar a img do edit
Route::get('/products/delete-image/{imageId}', [ProductController::class ,'deleteImage'])->name('deleteImage');
