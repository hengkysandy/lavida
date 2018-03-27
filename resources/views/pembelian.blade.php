@extends('layouts.master')

@section('content')
<?php
    use Carbon\Carbon;
    $datetime_today = Carbon::now();
    $datetime_tommorow = Carbon::now()->addDay(1);
?>
    <div id="menu-pembelian"></div>
    <h2>Tambah Stok</h2>
    <button id="pilihSupplier" type="button">Pilih supplier</button>

    <form action="{{url('doInsertPembelian')}}" onsubmit="return validateInsertPembelian()" method="post">
        {{csrf_field()}}
        <table>
            <tr id="selectedSupplier">
            <td>nama supplier</td>
            <td id="selectedSupplier1">:</td>
            </tr>
            <!-- <tr>
                <td>Nomor Nota</td>
                <td><input type="text" name="noNota"  required/></td>
            </tr>
            <tr>
                <td>Tanggal PO</td>
                <td><input type="text" name="getDateTimeNow" class="datetimepicker" value="{{$datetime_today}}"  required/></td>
            </tr>
            <tr>
                <td>Tanggal Estimasi</td>
                <td><input type="text" name="estimate" class="datetimepicker" value="{{$datetime_tommorow}}"  required/></td>
            </tr> -->
            <tr>
                <td>Tanggal Barang Datang</td>
                <td><input type="text" name="estimate" class="datetimepicker" value="{{$datetime_tommorow}}"  required/></td>
            </tr>
            
            <tr id="buttonAddBarang"></tr>
            <!-- <tr>
                <td colspan="2">
                    <button type="button" id="btnAddBarang" onclick="addBarang()">tambah Barang</button>
                </td>
            </tr> -->
        </table>
        <table border="1" class="table-data">
        <thead>
            <tr>
                <th class="table-head">id barang</th>
                <th>kode barang</th>
                <th>nama barang</th>
                <th>kuantitas barang</th>
                <th>jumlah beli</th>
                <th class="table-head">aksi</th>
            </tr>
        </thead>
        <tbody id="selectedItem">
            
        </tbody>
        </table>
        <p align="right">
            <input type="submit" value="simpan">
            <a href="{{url('pembelian')}}">
                <button type="button">batal</button>
            </a>
        </p>
        
    </form>
    <h2>Cari berdasarkan Tanggal</h2>
    <form action="{{url('doSearchPembelian')}}" method="post">
        {!! csrf_field() !!}
        <input type="text" name="search" class="searchid datepicker" placeholder="input tanggal"  required>
        <input type="submit" value="cari">   
    </form>
    @if(isset($_REQUEST['search']) != "")
    <a href="{{url('pembelian')}}">
        <button class="btn-back">kembali ke semua hasil</button>
    </a>
    @endif
    <div id="page-target">
    <h2>Data Pembelian</h2>
    <a href="{{url('pembelianRecap')}}">
        <button type="button">Rekap Data</button>
    </a>
    <a href="{{url('pembelianArchive')}}">
        <button type="button">Lihat Data Lama</button>
    </a>
    <table border="1" class="table-data">
    <thead>
        <tr>
            <th class="table-head">id</th>
            <th>Nomor Nota</th>
            <!-- <th>Tanggal/Jam</th> -->
            <!-- <th>Id supplier</th> -->
            <th>Nama Supplier</th> 
            <!-- <th>tanggal/jam estimasi</th> -->
            <th>Tanggal Barang Datang</th>
            <th>rincian pembelian</th>
            <th class="table-head-status">status</th>
            <th class="table-head-action">aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $id = ""; $name = "";
            $search = isset($_REQUEST['search'])?$_REQUEST['search']:"";
            if(is_numeric($search) && $search!=""){
                $id = $search;
            }
            else {
                $name = $search;
            }
        ?>
        @foreach($pembelianData as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->no_nota}}</td>
                <!-- <td>{{$data->datetime_transaction}}</td> -->
                <td>{{$data->Supplier()->first()->supplier_name}}</td>
                <td>{{$data->datetime_estimate}}</td>
                <td>
                    <button type="button" class="pembelianDetail" value="{{$data->id}}">lihat rincian</button>
                </td>
                @if($data->status == 1)
   <td>Aktif</td>
@else
   <td>Tidak Aktif</td>
@endif
                <?php
                    $id = $data->id;
                    $status = $data->status;
                ?>
                <td>
                    <div class="click">
                        <button type="button" onclick="confirmStatus('{{$id}}','{{$status}}','Pembelian')">Ganti Status</button>
                        <a href="{{url("updatePembelian?id=$id")}}">
                            <button type="button">Ubah</button>
                        </a>
                        <button type="button" onclick="confirmDelete('{{$data->id}}','Pembelian')">Hapus</button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    @if(isset($_REQUEST['search']) == "")
    <div class="div-paging-button">
        @for($i = 1; $i <= $pembelianData->lastPage(); $i++)
            <button class="paging-button" onclick="doPaging({{$i}})">{{$i}}</button>
        @endfor
    </div>
    @endif
    @include('layouts.popup')
    @include('layouts.popupSupplier')
    @include('layouts.popupDetail')
    @include('layouts.popupConfirm')
    @include('layouts.errorMessage')
@endsection