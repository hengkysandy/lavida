@extends('layouts.master')

@section('content')
    <h2>Cari berdasarkan kode barang atau nama barang</h2>
    <form action="{{url('stockcard')}}" method="GET">
        {!! csrf_field() !!}
        <input type="text" name="search" class="searchid" placeholder="input kode atau nama barang"  required>
        <input type="submit" value="cari">   
    </form>
    @if(isset($_REQUEST['search']) != "")
    <a href="{{url('stockcard')}}">
        <button class="btn-back">kembali ke semua hasil</button>
    </a>
    @endif
    <div id="page-target">
    <h2>kartu stok</h2>
    <table border="1" class="table-data">
    <thead>
        <tr>
            <th class="table-head">kode barang</th>
            <th>Nama barang</th>
            <!-- <th>nama supplier</th> -->
            <th>kuantitas Barang</th>
            <th>kuantitas Minimum</th>
            <th class="table-head-status">status</th>
            <th>rincian</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $search = isset($_REQUEST['search'])?$_REQUEST['search']:"";
        ?>
        @foreach($barangData as $data)
        @if($search !="")
            @if(str_contains($data->item_code,$search) || str_contains($data->item_name,$search))
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
                <td>
                    <a href="{{url("detailBarang?id=$data->item_code")}}">
                        <button type="button" class="customerPic" value="{{$data->id}}">lihat</button>
                    </a>
                </td>
            </tr>
            @endif
        @else
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
                <td>
                    <a href="{{url("detailBarang?id=$data->id")}}">
                        <button type="button" class="customerPic" value="{{$data->id}}">lihat</button>
                    </a>
                </td>
            </tr>
        @endif
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
@endsection