<div class="navigation">
    <a href="{{url('supplier')}}">
        <div class="nav-block" id="{{ in_array(Route::getFacadeRoot()->current()->uri(), ['supplier','updateSupplier','doSearchSupplier']) ? 'active-menu' : '' }}">Master Supplier</div>
    </a>
    <a href="{{url('customer')}}">
        <div class="nav-block" id="{{ in_array(Route::getFacadeRoot()->current()->uri(), ['customer','updateCustomer','doSearchCustomer']) ? 'active-menu' : '' }}">Master Customer</div>
    </a>
    <a href="{{url('kategori')}}">
        <div class="nav-block" id="{{ in_array(Route::getFacadeRoot()->current()->uri(), ['kategori','updateCategory','doSearchCategory']) ? 'active-menu' : '' }}">Master Kategori</div>
    </a>
    <a href="{{url('barang')}}">
        <div class="nav-block" id="{{ in_array(Route::getFacadeRoot()->current()->uri(), ['barang','updateItem','doSearchBarang']) ? 'active-menu' : '' }}">Master Barang</div>
    </a>
    <a href="{{url('pembelian')}}">
        <div class="nav-block" id="{{ in_array(Route::getFacadeRoot()->current()->uri(), ['pembelian','updatePembelian','doSearchPembelian','pembelianRecap','doRecapPembelian','pembelianArchive','doSearchArchivePembelian']) ? 'active-menu' : '' }}">Transaksi Pembelian</div>
    </a>
    <a href="{{url('penjualan')}}">
        <div class="nav-block" id="{{ in_array(Route::getFacadeRoot()->current()->uri(), ['penjualan','updatePenjualan','doSearchPenjualan','penjualanRecap','doRecapPenjualan','penjualanArchive','doSearchArchivePenjualan']) ? 'active-menu' : '' }}">Transaksi Penjualan</div>
    </a>
    <a href="{{url('transaksireturan')}}">
        <div class="nav-block" id="{{ in_array(Route::getFacadeRoot()->current()->uri(), ['transaksireturan','tahaplanjutreturan','doSearchReturan']) ? 'active-menu' : '' }}">Transaksi Returan Penjualan</div>
    </a>
    <a href="{{url('wastelist')}}">
        <div class="nav-block" id="{{ in_array(Route::getFacadeRoot()->current()->uri(), ['wastelist','doSearchWaste']) ? 'active-menu' : '' }}">Daftar Kerugian</div>
    </a>
    <a href="{{url('dashboard')}}">
        <div class="nav-block" id="{{ Route::getFacadeRoot()->current()->uri() === 'dashboard' ? 'active-menu' : '' }}">Dasbor</div>
    </a>
    <a href="{{url('stockcard')}}">
        <div class="nav-block" id="{{ in_array(Route::getFacadeRoot()->current()->uri(), ['stockcard','detailBarang']) ? 'active-menu' : '' }}">Kartu Stok</div>
    </a>
    <a href="{{url('log')}}">
        <div class="nav-block" id="{{ Route::getFacadeRoot()->current()->uri() === 'log' ? 'active-menu' : '' }}">Catatan Sistem</div>
    </a>
</div>
