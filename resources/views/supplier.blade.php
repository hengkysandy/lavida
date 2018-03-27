@extends('layouts.master')

@section('content')
    <div id="menu-supplier"></div>
    <button id="tambahSupplier">Tambah supplier</button>
    <div id="fade" class="blackoverlay"></div>
    <div id="light" class="whitecontent">
        <p class="req-field">
        <span class="field">
            * data wajib : Kode supplier, nama supplier, Telpon PIC, Alamat
        </span>
    </p>
    <form class="popupForm" action="{{url('doInsertSupplier')}}" onsubmit="return validateData('supplier')" method="post">
        {{csrf_field()}}
        <table>
            <tr>
                <td>kode supplier</td>
                <td><input type="text" name="supplierCode"  required></td>
            </tr>
            <tr>
                <td>nama supplier</td>
                <td><input type="text" name="supplierName"  required></td>
            </tr>
            <tr>
                <td>nama pic</td>
                <td><input type="text" name="picName"></td>
            </tr>
            <tr>
                <td>telepon pic</td>
                <td><input type="number" class="no-spin" name="contact" placeholder="hanya angka"  required></td>
            </tr>
            <!-- <tr>
                <td>email pic</td>
                <td><input type="text" name="email"></td>
            </tr> -->
            <tr>
                <td>lokasi supplier</td>
                <td> <textarea name="location" id="" cols="21" rows="3"  required></textarea> </td>
            </tr>
            <tr>
                <td>deskripsi</td>
                <td> <textarea name="description" id="" cols="21" rows="3"></textarea> </td>
            </tr>
            <tr align="center">
                <td colspan="2">
                    <input type="submit" value="simpan">
                    <button type="button" onclick="popupOff()">batal</button>
                </td>
            </tr>
        </table>
    </form>
    </div>
    <h2>Cari berdasarkan kode atau nama</h2>
    <form action="{{url('doSearchSupplier')}}" method="post">
        {!! csrf_field() !!}
        <input type="text" name="search" class="searchid" placeholder="input kode atau nama"  required>
        <input type="submit" value="cari">
    </form>
    @if(isset($_REQUEST['search']) != "")
    <a href="{{url('supplier')}}">
        <button class="btn-back">kembali ke semua hasil</button>
    </a>
    @endif
    <div id="page-target">
    <h2>supplier Data</h2>
    <table border="1" class="table-data">
        <thead>
        <tr>
            <th class="table-head">id</th>
            <th>kode supplier</th>
            <th>nama supplier</th>
            <th>rincian supplier</th>
            <th class="table-head-status">status</th>
            <th class="table-head-action">aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($supplierData as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->supplier_code}}</td>
                <td>{{$data->supplier_name}}</td>
                <td>
                    <button type="button" class="supplierDetail" value="{{$data->id}}">lihat rincian </button>
                </td>
                @if($data->status == 1)
                    <td>Aktif</td>
                @else
                    <td>Tidak Aktif</td>
                @endif
                <td>
                    <div class="click">
                        <button type="button" onclick="confirmStatus('{{$data->id}}','{{$data->status}}','Supplier')">Ganti Status</button>
                        <a href="{{url("updateSupplier?id=$data->id")}}">
                            <button type="button">Ubah</button>
                        </a>
                        <button type="button" onclick="confirmDelete('{{$data->id}}','Supplier')">Hapus</button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    @if(isset($_REQUEST['search']) == "")
    <div class="div-paging-button">
        @for($i = 1; $i <= $supplierData->lastPage(); $i++)
            <button class="paging-button" onclick="doPaging({{$i}})">{{$i}}</button>
        @endfor
    </div>
    @endif
    @include('layouts.popupDetail')
    @include('layouts.popupConfirm')
    @include('layouts.errorMessage')
@endsection
