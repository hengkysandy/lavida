@extends('layouts.master')

@section('content')
    <h2>Dasbor Barang</h2>
    <table border="1" class="table-data">
        <thead>
            <tr>
                <th class="table-head">kode barang</th>
                <th>merek barang</th>
                <th>SKU barang</th>
                <th>Nama barang</th>
                <th>kategori barang</th>
                <th>kuantitas Barang</th>
                <th>kuantitas Minimum</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangData as $data)
                <tr>
                    <td>{{$data->item_code}}</td>
                    <td>{{$data->item_brand}}</td>
                    <td>{{$data->item_sku}}</td>
                    <td>{{$data->item_name}}</td>
                    <td>{{$data->Category()->first()->name}}</td>
                    <td>{{$data->item_qty}}</td>
                    <td>{{$data->item_min_qty}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
