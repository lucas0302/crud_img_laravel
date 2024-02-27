<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

//rota da pagina principal
Route::controller(ProductController::class)->group(function(){
    //rota para a pagina principal
    Route::get('/', 'index')->name('index');

    //rota para criar o produtos
    Route::get('/create', 'create')->name('create');
    Route::post('store/', 'store')->name('store');

    // rota para vizualizar produto em específico
    Route::get('show/{product}', 'show')->name('show');

    //rota para editar um produto em específico
    Route::get('edit/{product}','edit')->name('edit');
    Route::put('edit/{product}', 'update')->name('update');

    // rota para deletar o produto em específico
    Route::get('/{product}','destroy')->name('destroy');

    //rota para apagar a img do edit
    Route::get('/products/delete-image/{imageId}','deleteImage')->name('deleteImage');
});



