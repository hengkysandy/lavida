@extends('layouts.master')

@section('content')
    <h2>Tambah Kategori</h2>
    <form action="{{url('doInsertCategory')}}" onsubmit="return validateCategory()" method="post">
        {{csrf_field()}}
        <table>
            <tr id="selectedSupplier"></tr>
            <tr>
                <td>nama kategori</td>
                <td><input type="text" name="name" placeholder="input nama kategori"  required></td>
                <td><input type="submit" value="simpan" style="float: right;"></td>
            </tr>
        </table>
    </form>

    <h2>Cari berdasarkan id atau nama</h2>
    <form action="{{url('doSearchCategory')}}" method="post">
        {!! csrf_field() !!}
        <input type="text" name="search" class="searchid" placeholder="input id atau nama"  required>
        <input type="submit" value="cari">   
    </form>
    @if(isset($_REQUEST['search']) != "")
    <a href="{{url('kategori')}}">
        <button class="btn-back">kembali ke semua hasil</button>
    </a>
    @endif

    <div id="page-target">
    <h2>Data Kategori</h2>
    <table border="1" class="table-data">
        <thead>
        <tr>
            <th class="table-head">id</th>
            <th>nama kategori</th>
            <th class="table-head-action">aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cateData as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->name}}</td>
                <td>
                    <div class="click">
                        <a href="{{url("updateCategory?id=$data->id")}}">
                            <button type="button">Ubah</button>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    @if(isset($_REQUEST['search']) == "")
    <div class="div-paging-button">
        @for($i = 1; $i <= $cateData->lastPage(); $i++)
            <button class="paging-button" onclick="doPaging({{$i}})">{{$i}}</button>
        @endfor
    </div>
    @endif
    @include('layouts.errorMessage')
@endsection
