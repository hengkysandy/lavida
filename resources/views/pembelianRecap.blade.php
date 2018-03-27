@extends('layouts.master')

@section('content')
    <h2>Rekap Pembelian</h2>
    <h2>Tanggal Barang Datang</h2>
    <form action="{{url('doRecapPembelian')}}" onsubmit="return validateDateBetween()" method="post">
        {!! csrf_field() !!}
        <input type="text" name="searchFrom" class="searchid datepicker" placeholder="dari"  required>
        <input type="text" name="searchTo" class="searchid datepicker" placeholder="sampai"  required>
        <input type="submit" value="cari">   
    </form>
    @if(isset($pembelianData))
        <table border="1" class="table-data">
        <thead>
            <tr>
                <th class="table-head">id</th>
                <th>Nomor Nota</th>
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
    
@endsection
