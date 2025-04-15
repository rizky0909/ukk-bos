<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('loginStore');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/product', [ProductsController::class, 'index'])->name('products');
    Route::get('/', [TransactionsController::class, 'index'])->name('transaction');
    Route::get('/downloadPDF/{id}', [TransactionsController::class, 'downloadPDF'])->name('downloadPDF');
    Route::get('/downloadExcel', [TransactionsController::class, 'downloadExcel'])->name('downloadExcel');


    Route::middleware(['admin'])->group(function () {
        Route::prefix('/products')->group(function () {
            Route::get('/create', [ProductsController::class, 'create'])->name('productCreate');
            Route::post('/store', [ProductsController::class, 'store'])->name('productStore');
            Route::get('/edit/{id}', [ProductsController::class, 'edit'])->name('productEdit');
            Route::patch('/update/{id}', [ProductsController::class, 'update'])->name('productUpdate');
            Route::delete('/delete/{id}', [ProductsController::class, 'destroy'])->name('productDelete');
            Route::patch('/updateStock/{id}', [ProductsController::class, 'updatestock'])->name('updateStock');
        });

        Route::prefix('/users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users');
            Route::get('/create', [UserController::class, 'create'])->name('userCreate');
            Route::post('/store', [UserController::class, 'store'])->name('userStore');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('userEdit');
            Route::patch('/update/{id}', [UserController::class, 'update'])->name('userUpdate');
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('userDelete');
        });
    });

    Route::middleware(['staff'])->group(function () {
        Route::prefix('/transactions')->group(function () {
            Route::get('/create', [TransactionsController::class, 'create'])->name('transactionCreate');
            Route::post('/cart', [TransactionsController::class, 'cart'])->name('cart');
            Route::get('/checkout', [TransactionsController::class, 'checkout'])->name('checkout');
            Route::get('/invoice/{id}', [TransactionsController::class, 'invoice'])->name('invoice');
            Route::post('/store', [TransactionsController::class, 'store'])->name('transactionStore');
            Route::get('/member/{id}', [TransactionsController::class, 'member'])->name('member');
            Route::post('/update/member', [TransactionsController::class, 'updateMember'])->name('updateMember');
        });
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});
