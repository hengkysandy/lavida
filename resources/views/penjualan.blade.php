@extends('layouts.master')

@section('content')
<?php
    use Carbon\Carbon;
    $datetime_today = Carbon::now();
    $datetime_tommorow = Carbon::now()->addDay(1);
?>
<div id="menu-penjualan"></div>
    <h2>Tambah Penjualan</h2>
    <button id="pilihCustomer" type="button">Pilih customer</button>
    <form action="{{url('doInsertPenjualan')}}" onsubmit="return validateInsertPenjualan()" method="post">
        {{csrf_field()}}
        <table class="customer-table">
            <tr id="selectedCustomer">
            <td>nama customer</td>
            <td id="selectedCustomer1">:</td>
            </tr>
            <tr>
                <td>Nomor Nota</td>
                <td><input type="text" name="noNota"  required/></td>
            </tr>
            <!-- <tr>
                <td>Tanggal SO</td>
                <td><input type="text" name="getDateTimeNow" class="datetimepicker" value="{{$datetime_today}}"  required/></td>
            </tr>
            <tr>
                <td>Tanggal Estimasi</td>
                <td><input type="text" name="estimate" class="datetimepicker" value="{{$datetime_tommorow}}"  required/></td>
            </tr> -->
            <tr>
                <td>Tanggal Penjualan</td>
                <td><input type="text" name="estimate" class="datetimepicker" value="{{$datetime_today}}"  required/></td>
            </tr>
            <tr id="buttonAddBarang"></tr>
        </table>

        <table border="1" class="table-data">
        <thead>
            <tr>
                <th class="table-head">id barang</th>
                <th>kode barang</th>
                <th>nama barang</th>
                <th>kuantitas barang</th>
                <th>jumlah jual</th>
                <th class="table-head">aksi</th>
            </tr>
        </thead>
        <tbody id="selectedItem">
            
        </tbody>
        </table>

        <p align="right">
            <input type="submit" value="simpan">
            <a href="{{url('penjualan')}}">
                <button type="button">batal</button>
            </a>
        </p>
        <input type="hidden" name="totalItem" value="{{$totalItem}}">
    </form>
    
    <div class="penjualan-search">
        <div class="left">
            <h2>Cari berdasarkan Tanggal</h2>
            <form action="{{url('doSearchPenjualan')}}" method="post">
                {!! csrf_field() !!}
                <input type="text" name="search" class="searchid datepicker" placeholder="input tanggal"  required>
                <input type="submit" value="cari">   
            </form>
        </div>
        <div class="right">
            <h2>Cari berdasarkan Nomor Nota</h2>
            <form action="{{url('doSearchPenjualanNota')}}" method="post">
                {!! csrf_field() !!}
                <input type="text" name="search" class="searchid" placeholder="input nomor nota"  required>
                <input type="submit" value="cari">   
            </form>
        </div>
    </div>
    
    
    @if(isset($_REQUEST['search']) != "")
    <a href="{{url('penjualan')}}">
        <button class="btn-back">kembali ke semua hasil</button>
    </a>
    @endif
    <div id="page-target">
    <h2>Data Penjualan</h2>
    <a href="{{url('penjualanRecap')}}">
        <button type="button">Rekap Data</button>
    </a>
    <a href="{{url('penjualanArchive')}}">
        <button type="button">Lihat Data Lama</button>
    </a>
    <table border="1" class="table-data">
    <thead>
        <tr>
            <th class="table-head">id</th>
            <th>Nomor Nota</th>
            <!-- <th>Tanggal/Jam</th> -->
            <th>Id customer</th>
            <th>nama customer</th>
            <!-- <th>tanggal/jam estimasi</th> -->
            <th>Tanggal Penjualan</th>
            <th>rincian penjualan</th>
            <th>telah di retur</th>
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
        @foreach($penjualanData as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->no_nota}}</td>
                <!-- <td>{{$data->datetime_transaction}}</td> -->
                <td>{{$data->customer_id}}</td>
                <td>{{$data->Customer()->first()->customer_name}}</td>
                <td>{{$data->datetime_estimate}}</td>
                <td>
                    <button type="button" class="penjualanDetail" value="{{$data->id}}">lihat rincian</button>
                </td>
                @if($data->remark_returan == "yes")
                   <td>ya</td>
                @else
                   <td>tidak</td>
                @endif
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
                        <button type="button" onclick="confirmStatus('{{$id}}','{{$status}}','Penjualan')">Ganti Status</button>
                        @if($data->remark_returan == "no")
                        <a href="{{url("updatePenjualan?id=$id")}}">
                            <button type="button">Ubah</button>
                        </a>
                        @endif
                        <button type="button" onclick="confirmDelete('{{$data->id}}','Penjualan')">Hapus</button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    @if(isset($_REQUEST['search']) == "")
    <div class="div-paging-button">
        @for($i = 1; $i <= $penjualanData->lastPage(); $i++)
            <button class="paging-button" onclick="doPaging({{$i}})">{{$i}}</button>
        @endfor
    </div>
    @endif
    @include('layouts.popup')
    @include('layouts.popupDetail')
    @include('layouts.popupConfirm')
    @include('layouts.errorMessage')
    @include('layouts.popupCustomer')
@endsection