@extends('layouts.master')

@section('content')
<?php
    use Carbon\Carbon;
    $datetime_today = Carbon::now();
?>
    <h2>Transaksi Returan Penjualan</h2>
    <button id="pilihReturan" type="button">Tambah Returan</button>
    <form action="{{url('tahaplanjutreturan')}}" onsubmit="return validateInsertReturan()" method="post">
        {{csrf_field()}}
        <table>
            <tr>
                <td>Tanggal Returan</td>
                <td><input type="text" name="datetime_returan" value="{{$datetime_today}}" class="datetimepicker"  required/></td>
            </tr>
            <!-- <tr>
                <td>No Transaksi Penjualan</td>
                <td>
                    <select id="novalue">
                        
                    </select>
                    <button type="button" id="addBtn">add</button>
                </td>
            </tr> -->
            <tr>
                <td>Transaksi Penjualan</td>
                <td>
                    <span id="currno"></span>
                    <input type="hidden" name="selected_no"/>
                </td>
                <!-- <td>
                    <span id="currno"></span>
                    <input type="hidden" name="selected_no"/>
                </td> -->
            </tr>
            <tr align="center">
                <td colspan="2"><input type="submit" value="Masukkan"></td>
            </tr>
        </table>
    </form>
    @include('layouts.errorMessage')
    <h2>Cari berdasarkan Tanggal</h2>
    <form action="{{url('doSearchReturan')}}" method="post">
        {!! csrf_field() !!}
        <input type="text" name="search" class="searchid datepicker" placeholder="input tanggal"  required>
        <input type="submit" value="cari">   
    </form>
    @if(isset($_REQUEST['search']) != "")
    <a href="{{url('transaksireturan')}}">
        <button class="btn-back">kembali ke semua hasil</button>
    </a>
    @endif
    <h2>Data Returan</h2>
    <table border="1" class="table-data">
        <thead>
        <tr>
            <th class="table-head">id</th>
            <th>nomor retur</th>
            <th>tanggal/jam retur</th>
            <th>rincian</th>
            <th class="table-head-status">status</th>
            <th class="table-head-action">aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($returanData as $data)
        <tr>
            <td>{{$data->id}}</td>
            <td>{{$data->no_retur}}</td>
            <td>{{$data->datetime_return}}</td>
            <td>
                <button type="button" class="returanDetail" value="{{$data->id}}">lihat rincian</button>
            </td>
            @if($data->status == 1)
   <td>Aktif</td>
@else
   <td>Tidak Aktif</td>
@endif
            <td>
                <div class="click">
                    <button type="button" onclick="confirmStatus('{{$data->id}}','{{$data->status}}','Returan')">Ganti Status</button>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @if(isset($_REQUEST['search']) == "")
    <div class="div-paging-button">
        @for($i = 1; $i <= $returanData->lastPage(); $i++)
            <button class="paging-button" onclick="doPaging({{$i}})">{{$i}}</button>
        @endfor
    </div>
    @endif
    @include('layouts.popupDetail')
    @include('layouts.popupConfirm')
    @include('layouts.popupPenjualan')
    @include('layouts.errorMessage')
@endsection