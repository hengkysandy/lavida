@extends('layouts.master')

@section('content')
    <a href="{{url('stockcard')}}">
        <button class="btn-back">kembali ke semua hasil</button>
    </a>
    <h2>rincian barang</h2>
    <table border="1" class="table-data">
    <thead>
        <tr>
            <th class="table-head">kode barang</th>
            <th>Nama barang</th>
            <th>kuantitas Barang</th>
            <th>kuantitas Minimum</th>
            <th class="table-head-status">status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barangData as $data)
            <tr>
                <td>{{$data->item_code}}</td>
                <td>{{$data->item_name}}</td>
                <td>{{$data->item_qty}}</td>
                <td>{{$data->item_min_qty}}</td>
                @if($data->status == 1)
   <td>Aktif</td>
@else
   <td>Tidak Aktif</td>
@endif
            </tr>
        @endforeach
    </tbody>
    </table>

    <h2>Data Pembelian</h2>
    <table border="1" class="table-data">
        <thead>
        <tr>
            <th class="table-head">id pembelian</th>
            <th>Kode barang</th>
            <th>Nama barang</th>
            <th>kuantitas pembelian</th>
            <th>tanggal/jam pembelian</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pembelianData as $data)
            <tr>
                <td>{{$data->id_pembelian}}</td>
                <td>{{$data->item_code}}</td>
                <td>{{$data->item_name}}</td>
                <td>{{$data->purchase_qty}}</td>
                <td>{{$data->created_at}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>Data Penjualan</h2>
    <table border="1" class="table-data">
        <thead>
        <tr>
            <th class="table-head">id penjualan</th>
            <th>Kode barang</th>
            <th>Nama barang</th>
            <th>kuantitas penjualan</th>
            <th>tanggal/jam penjualan</th>
            <th>kuantitas Retur</th>
            <th>kuantitas layak</th>
            <th>kuantitas kerugian</th>
        </tr>
        </thead>
        <tbody>
        @foreach($responsePenjualan as $index => $data)
            <tr>
                <td>{{$data->id_penjualan}}</td>
                <td>{{$data->item_code}}</td>
                <td>{{$data->item_name}}</td>
                <td>{{$data->selling_qty}}</td>
                <td>{{$data->created_at}}</td>
                @if($data['returanDetail'] != null)
                    <td>{{$data['returanDetail']->qty_retur}}</td>
                    <td>{{$data['ReturanDetailStatus']->qty_kembali}}</td>
                    <td>{{$data['ReturanDetailStatus']->qty_waste}}</td>
                @else
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                @endif
                
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection