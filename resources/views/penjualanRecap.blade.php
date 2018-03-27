@extends('layouts.master')

@section('content')
    <h2>Rekap Penjualan</h2>
    <h2>Tanggal Penjualan</h2>
    <form action="{{url('doRecapPenjualan')}}" onsubmit="return validateDateBetween()" method="post">
        {!! csrf_field() !!}
        <input type="text" name="searchFrom" class="searchid datepicker" placeholder="dari"  required>
        <input type="text" name="searchTo" class="searchid datepicker" placeholder="sampai"  required>
        <input type="submit" value="cari">   
    </form>
    @if(isset($penjualanData))
        <table border="1" class="table-data">
        <thead>
            <tr>
                <th class="table-head">id</th>
                <th>Nomor Nota</th>
                <th>Id customer</th>
                <th>nama customer</th>
                <th>Tanggal Penjualan</th>
                <th>rincian penjualan</th>
                <th>telah di retur</th>
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
            @foreach($penjualanData as $data)
                <tr>
                    <td>{{$data->id}}</td>
                    <td>{{$data->no_nota}}</td>
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
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    @include('layouts.popupDetail') 
    
@endsection
