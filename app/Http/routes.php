<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/clear-cache', function() {
    $clearCache = Artisan::call('cache:clear');
    $clearView = Artisan::call('view:clear');
    return redirect('dashboard');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/','AdminController@index');
    Route::post('/doLogin','Auth\AuthController@postLogin');
    Route::get('/auth/login','Auth\AuthController@getLogin');
});


Route::group(['middleware' => 'auth'], function () {
    //global
    
    Route::get('/loadCode/{menu}/{code}','AdminController@loadCode');
    Route::get('/loadCategoryNameUpdate/{id}/{name}','AdminController@loadCategoryNameUpdate');
    Route::get('/loadSku/{sku}','AdminController@loadSku');


    Route::get('/master','AdminController@master');
    Route::get('/log','AdminController@log');
    Route::get('/dashboard','AdminController@dashboard');
    Route::get('/stockcard','AdminController@stockcard');
    Route::get('/detailBarang','AdminController@detailBarang');
    Route::post('/doSearchLog','AdminController@doSearchLog');
    Route::get('/doReadNotif','AdminController@doReadNotif');
    
    

    Route::get('/supplier','SupplierController@supplier');
    Route::post('/doInsertSupplier','SupplierController@doInsertSupplier');
    Route::get('/doChangeSupplierStatus','SupplierController@doChangeStatus');
    Route::get('/updateSupplier','SupplierController@updateSupplier');
    Route::post('/doUpdateSupplier','SupplierController@doUpdateSupplier');
    Route::post('/doSearchSupplier','SupplierController@doSearchSupplier');
    Route::get('/supplierAjax/{id}','SupplierController@supplierAjax');
    Route::get('/doDeleteSupplier','SupplierController@doDeleteSupplier');


    Route::get('/customer','CustomerController@customer');
    Route::post('/doInsertCustomer','CustomerController@doInsertCustomer');
    Route::get('/doChangeCustomerStatus','CustomerController@doChangeStatus');
    Route::get('/updateCustomer','CustomerController@updateCustomer');
    Route::post('/doUpdateCustomer','CustomerController@doUpdateCustomer');
    Route::post('/doSearchCustomer','CustomerController@doSearchCustomer');
    Route::get('/customerAjax/{id}','CustomerController@customerAjax');
    Route::get('/doDeleteCustomer','CustomerController@doDeleteCustomer');

    Route::get('/barang','BarangController@barang');
    Route::post('/doInsertItem','BarangController@doInsertItem');
    Route::get('/doChangeItemStatus','BarangController@doChangeStatus');
    Route::get('/updateItem','BarangController@updateItem');
    Route::post('/doUpdatetItem','BarangController@doUpdatetItem');
    Route::post('/doSearchBarang','BarangController@doSearchBarang');
    Route::get('/doDeleteBarang','BarangController@doDeleteBarang');
    Route::get('/loadSupplierAjax','BarangController@loadSupplierAjax');
    Route::get('/loadSupplierAjaxSearch/{name}','BarangController@loadSupplierAjaxSearch');

    
    Route::get('/kategori','BarangController@kategori');
    Route::post('/doInsertCategory','BarangController@doInsertCategory');
    Route::post('/doSearchCategory','BarangController@doSearchCategory');
    Route::get('/updateCategory','BarangController@updateCategory');
    Route::post('/doUpdateCategory','BarangController@doUpdateCategory');

    Route::get('/pembelian',[ 'as' => 'pembelian', 'uses' => 'PembelianController@pembelian']);
    // Route::get('/pembelian','PembelianController@pembelian');
    Route::post('/doInsertPembelian','PembelianController@doInsertPembelian');
    Route::get('/doChangePembelianStatus','PembelianController@doChangePembelianStatus');
    Route::get('/updatePembelian','PembelianController@updatePembelian');
    Route::post('/doUpdatePembelian','PembelianController@doUpdatePembelian');
    Route::post('/doSearchPembelian','PembelianController@doSearchPembelian');
    Route::get('/pembelianDetailAjax/{id}','PembelianController@pembelianDetailAjax');
    Route::get('/doDeletePembelian','PembelianController@doDeletePembelian');
    Route::get('/loadPembelianDetailAjax/{id}','PembelianController@loadPembelianDetailAjax');
    
    Route::get('/pembelianRecap','PembelianController@pembelianRecap');
    Route::post('/doRecapPembelian','PembelianController@doRecapPembelian');
    Route::get('/pembelianArchive','PembelianController@pembelianArchive');
    Route::post('/doSearchArchivePembelian','PembelianController@doSearchArchivePembelian');



    Route::get('/penjualan','PenjualanController@penjualan');
    Route::post('/doInsertPenjualan','PenjualanController@doInsertPenjualan');
    Route::get('/doChangePenjualanStatus','PenjualanController@doChangePenjualanStatus');
    Route::get('/updatePenjualan','PenjualanController@updatePenjualan');
    Route::post('/doUpdatePenjualan','PenjualanController@doUpdatePenjualan');
    Route::post('/doSearchPenjualan','PenjualanController@doSearchPenjualan');
    Route::post('/doSearchPenjualanNota','PenjualanController@doSearchPenjualanNota');
    Route::get('/loadItemAjax/{id}','PenjualanController@loadItemAjax');
    Route::get('/loadItemAjaxSearch/{name}/{id}','PenjualanController@loadItemAjaxSearch');
    Route::get('/penjualanDetailAjax/{id}','PenjualanController@penjualanDetailAjax');
    Route::get('/doDeletePenjualan','PenjualanController@doDeletePenjualan');
    Route::get('/loadCustomerAjax','PenjualanController@loadCustomerAjax');
    Route::get('/loadCustomerAjaxSearch/{name}','PenjualanController@loadCustomerAjaxSearch');
    Route::get('/loadPenjualanDetailAjax/{id}','PenjualanController@loadPenjualanDetailAjax');

    Route::get('/penjualanRecap','PenjualanController@penjualanRecap');
    Route::post('/doRecapPenjualan','PenjualanController@doRecapPenjualan');
    Route::get('/penjualanArchive','PenjualanController@penjualanArchive');
    Route::post('/doSearchArchivePenjualan','PenjualanController@doSearchArchivePenjualan');
    
    
    Route::get('/transaksireturan','TransaksiController@transaksireturan');
    Route::post('/tahaplanjutreturan','TransaksiController@tahaplanjutreturan');
    Route::post('/doInsertReturan','TransaksiController@doInsertReturan');
    Route::get('/wastelist','TransaksiController@wastelist');
    Route::get('/doChangeReturanStatus','TransaksiController@doChangeReturanStatus');
    Route::post('/doSearchReturan','TransaksiController@doSearchReturan');
    Route::get('/updateReturan','TransaksiController@updateReturan');
    Route::post('/doUpdateReturan','TransaksiController@doUpdateReturan');
    Route::get('/loadPenjualanAjax','TransaksiController@loadPenjualanAjax');
    Route::get('/loadPenjualanAjaxSearch/{name}','TransaksiController@loadPenjualanAjaxSearch');
    Route::get('/returanDetailAjax/{id}','TransaksiController@returanDetailAjax');
    Route::post('/doSearchWaste','TransaksiController@doSearchWaste');

    Route::get('/PembelianPdf/{from}/{to}','PdfController@PembelianPdf');
    Route::get('/deletePembelianArchive/{from}/{to}','PdfController@deletePembelianArchive');

    Route::get('/PenjualanPdf/{from}/{to}','PdfController@PenjualanPdf');
    Route::get('/deletePenjualanArchive/{from}/{to}','PdfController@deletePenjualanArchive');


    Route::get('/logout','Auth\AuthController@getLogout');

});