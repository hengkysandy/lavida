@extends('layouts.master')

@section('content')
    <h2>Data Lama Pembelian</h2>
    @if(count($pembelianData) == 0)
        <p>Tidak ada data lama</p>
        @if(isset($_REQUEST['searchFrom']) != "")
            <a href="{{url('pembelianArchive')}}">
                <button class="btn-back">kembali ke semua hasil</button>
            </a>
        @endif
    @else
        <?php 
            if(!isset($from)) $from = "";
            if(!isset($to)) $to = "";
        ?>
        <h2>Tanggal Barang Datang</h2>
        <form action="{{url('doSearchArchivePembelian')}}" onsubmit="return validateDateBetween()" method="post">
            {!! csrf_field() !!}
            <input type="text" name="searchFrom" class="searchid datepicker" value="{{$from}}" placeholder="dari"  required>
            <input type="text" name="searchTo" class="searchid datepicker" value="{{$to}}" placeholder="sampai"  required>
            <input type="submit" value="cari">
            <button type="button" style="float: right;" onclick="confirmArchive('Pembelian')">Arsip Data dibawah ini</button>
        </form>
        @if(isset($_REQUEST['searchFrom']) != "")
            <a href="{{url('pembelianArchive')}}">
                <button class="btn-back">kembali ke semua hasil</button>
            </a>
        @endif

            <table border="1" class="table-data">
            <thead>
                <tr>
                    <th class="table-head">id</th>
                    <th>Nomor Nota</th>
                    <th>Id supplier</th>
                    <th>nama supplier</th>
                    <th>Tanggal Barang Datang</th>
                    <th>rincian pembelian</th>
                    <th class="table-head-status">status</th>
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
                        <td>{{$data->supplier_id}}</td>
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
                    </tr>
                @endforeach
                </tbody>
            </table>
    @endif
    
    @include('layouts.popupDetail') 
    @include('layouts.popupConfirm')
    
@endsection
