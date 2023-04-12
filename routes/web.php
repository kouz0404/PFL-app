<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index']);
    Route::get('/search', [App\Http\Controllers\ItemController::class, 'search'])->name('search');
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::get('/detail/{item_name}', [App\Http\Controllers\DetailController::class, 'detail']);
    Route::get('detail/edit/{id}', [App\Http\Controllers\EditController::class, 'edit']);
    Route::post('/edit', [App\Http\Controllers\EditController::class, 'edit']);
    Route::post('detail/delete/{id}', [App\Http\Controllers\EditController::class, 'delete']);
});
Route::get('/search', [App\Http\Controllers\ItemController::class, 'search'])->name('search');
Route::get('/search/sell', [App\Http\Controllers\SellController::class, 'search'])->name('search');


Route::prefix('sell')->group(function () {
    Route::get('/', [App\Http\Controllers\SellController::class, 'index']);
    Route::get('/add', [App\Http\Controllers\SellController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\SellController::class, 'add']);
    Route::get('/goal', [App\Http\Controllers\SellController::class, 'goal']);
    Route::post('/goal', [App\Http\Controllers\SellController::class, 'goal']);
    Route::get('/myhistory', [App\Http\Controllers\SellController::class, 'history']);
    Route::get('/allhistory', [App\Http\Controllers\SellController::class, 'allhistory']);
    Route::get('/myhistory/edit/{id}', [App\Http\Controllers\SellController::class, 'history_edit']);
    Route::get('/myhistory/delete/{id}', [App\Http\Controllers\SellController::class, 'delete']);
    Route::post('/myhistory/edit', [App\Http\Controllers\SellController::class, 'history_edit']);
    //Route::post('/goal', [App\Http\Controllers\SellController::class, 'goal']);
    Route::get('/sell_items/{id}', [App\Http\Controllers\SellController::class, 'sell_items']);
});

Route::prefix('notice')->group(function () {
    Route::get('/', [App\Http\Controllers\NoticeController::class, 'index']);
    Route::post('/', [App\Http\Controllers\NoticeController::class, 'add']);
    Route::get('/list/{id}', [App\Http\Controllers\NoticeController::class, 'list']);
    Route::get('/list/delete/{id}', [App\Http\Controllers\NoticeController::class, 'delete']);   
    Route::get('/list/edit/{id}', [App\Http\Controllers\NoticeController::class, 'edit']);
    Route::post('/list/edit/{id}', [App\Http\Controllers\NoticeController::class, 'edit']);
});






