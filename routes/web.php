<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AttachmentController;
/*
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();
// Route::match(['get', 'post'], 'register', function(){
//     return redirect('/');
//     });
Route::get('/', function () {
    return view('welcome');
});

Route::get('/{page}', [AdminController::class,'index']);



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// invoices



Route::controller(InvoiceController::class)
    ->prefix('invoices')
    ->as('invoices.')
    ->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/show/{invoice}', 'show')->name('show');
        Route::post('/store', 'store')->name('store');
        Route::put('/update', 'update')->name('update');
        Route::delete('/destroy', 'destroy')->name('destroy');
        Route::delete('/archive_destroy', 'archive_destroy')->name('archive_destroy');
        Route::put('/unarchive', 'unarchive')->name('unarchive');
        Route::delete('/archive', 'archive')->name('archive');
        Route::get('/getProduct/{id}', 'getProduct');
        Route::get('/{invoice}/edit','edit')->name('edit');
        Route::put('/update/{invoice}','update')->name('update');
        Route::get('/invoices_archive', 'invoices_archive')->name('invoices_archive');
        Route::get('/changePayment/{invoice}', 'changePayment')->name('changePayment');
        Route::put('/updatePayment/{invoice}', 'updatePayment')->name('updatePayment');
        Route::get('/invoice_paid', 'invoice_paid')->name('invoice_paid');
        Route::get('/invoice_unpaid', 'invoice_unpaid')->name('invoice_unpaid');
        Route::get('/invoice_partial', 'invoice_partial')->name('invoice_partial');
        Route::get('/invoice_print/{invoice}', 'invoice_print')->name('invoice_print');
    });
    // attchments
    Route::controller(AttachmentController::class)
    ->prefix('attachments')
    ->as('attachments.')
    ->group(function () {
        Route::post('/store', 'store')->name('store');
        Route::get('/showFile/{file}/{invoice_number}', 'showFile')->name('showFile');
        Route::get('/downloadFile/{file}/{invoice_number}', 'downloadFile')->name('downloadFile');
        Route::delete('/destroy', 'destroy')->name('destroy');
       
        
    });
    //sections
    Route::controller(SectionController::class)
    ->prefix('sections')
    ->as('sections.')
    ->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::put('/update', 'update')->name('update');
        Route::delete('/destroy', 'destroy')->name('destroy');
    });


     //products
     Route::controller(ProductController::class)
     ->prefix('products')
     ->as('products.')
     ->group(function () {
         Route::get('/index', 'index')->name('index');
         Route::post('/store', 'store')->name('store');
         Route::put('/update', 'update')->name('update');
         Route::delete('/destroy', 'destroy')->name('destroy');
     });


    //  /////////////////////////////