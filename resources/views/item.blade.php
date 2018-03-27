@extends('layouts.master')

@section('content')

    <h2>Tambah Barang</h2>
    <p class="req-field">
        <span class="field">
            * data wajib : Kode Barang, Nama Barang, SKU Barang, Item kuantitas, minimal kuantitas, supplier
        </span>
    </p>
    <form action="{{url('doInsertItem')}}" onsubmit="return validateData('item')" method="post">
        {{csrf_field()}}
        <table>
            <tr>
                <td>kode barang</td>
                <td><input type="text" name="itemCode"  required></td>
            </tr>
            <tr>
                <td>merek barang</td>
                <td><input type="text" name="itemBrand"></td>
            </tr>
            <tr>
                <td>Nama Barang</td>
                <td><input type="text" name="name"  required></td>
            </tr>
            <tr>
                <td>SKU Barang</td>
                <td><input type="text" name="itemSku"  required></td>
            </tr>

            <tr>
                <td>kategori barang</td>
                <td>
                <select name="category" id="">
                    @foreach($cateData as $cate)
                        <option value="{{$cate->id}}">{{$cate->name}}</option>
                    @endforeach
                </select>
                </td>
            </tr>
            <tr>
                <td>kuantitas barang</td>
                <td> <input type="number" name="qty" min="0" placeholder="hanya angka"  required> </td>
            </tr>
            <tr>
                <td>minimal kuantitas barang</td>
                <td><input type="number" name="minQty" min="1" placeholder="hanya angka"  required></td>
            </tr>
            <tr align="center">
                <td colspan="2">
                    <input type="submit" value="simpan">
                    <a href="{{url('barang')}}">
                        <button type="button">batal</button>
                    </a>
                </td>
            </tr>
        </table>
    </form>
    
    <h2>Cari berdasarkan kode or nama</h2>
    <form action="{{url('doSearchBarang')}}" method="post">
        {!! csrf_field() !!}
        <input type="text" name="search" class="searchid" placeholder="input kode atau nama"  required>
        <input type="submit" value="cari">   
    </form>
    @if(isset($_REQUEST['search']) != "")
    <a href="{{url('barang')}}">
        <button class="btn-back">kembali ke semua hasil</button>
    </a>
    @endif
    <div id="page-target">
    <h2>Data Barang</h2>
    <table border="1" class="table-data">
        <thead>
        <tr>
            <th class="table-head">id</th>
            <th>kode barang</th>
            <th>SKU barang</th>
            <th>Nama barang</th>
            <th>merek barang</th>
            <th>kategori barang</th>
            <th>kuantitas Barang</th>
            <th>kuantitas Minimum</th>
            <th class="table-head-status">status</th>
            <th class="table-head-action">aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($barangData as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->item_code}}</td>
                <td>{{$data->item_sku}}</td>
                <td>{{$data->item_name}}</td>
                <td>{{$data->item_brand}}</td>
                <td>{{$data->Category()->first()->name}}</td>
                <td>{{$data->item_qty}}</td>
                <td>{{$data->item_min_qty}}</td>
                @if($data->status == 1)
   <td>Aktif</td>
@else
   <td>Tidak Aktif</td>
@endif
                <td>
                    <div class="click">
                        <button type="button" onclick="confirmStatus('{{$data->id}}','{{$data->status}}','Item')">Ganti Status</button>
                        <a href="{{url("updateItem?id=$data->id")}}">
                            <button type="button">Ubah</button>
                        </a>
                        <button type="button" onclick="confirmDelete('{{$data->id}}','Barang')">Hapus</button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    @if(isset($_REQUEST['search']) == "")
    <div class="div-paging-button">
        @for($i = 1; $i <= $barangData->lastPage(); $i++)
            <button class="paging-button" onclick="doPaging({{$i}})">{{$i}}</button>
        @endfor
    </div>
    @endif
    @include('layouts.popupSupplier')
    @include('layouts.popupDetail')
    @include('layouts.popupConfirm')
    @include('layouts.errorMessage')
@endsection
