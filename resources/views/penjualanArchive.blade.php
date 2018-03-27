@extends('layouts.master')

@section('content')
    <h2>Data Lama Penjualan</h2>
    @if(count($penjualanData) == 0)
        <p>Tidak ada data lama</p>
        @if(isset($_REQUEST['searchFrom']) != "")
            <a href="{{url('penjualanArchive')}}">
                <button class="btn-back">kembali ke semua hasil</button>
            </a>
        @endif
    @else
        <?php 
            if(!isset($from)) $from = "";
            if(!isset($to)) $to = "";
        ?>
        <h2>Tanggal Penjualan</h2>
        <form action="{{url('doSearchArchivePenjualan')}}" onsubmit="return validateDateBetween()" method="post">
            {!! csrf_field() !!}
            <input type="text" name="searchFrom" class="searchid datepicker" value="{{$from}}" placeholder="dari"  required>
            <input type="text" name="searchTo" class="searchid datepicker" value="{{$to}}" placeholder="sampai"  required>
            <input type="submit" value="cari">
            <button type="button" style="float: right;" onclick="confirmArchive('Penjualan')">Arsip Data dibawah ini</button>  
        </form>
        @if(isset($_REQUEST['searchFrom']) != "")
            <a href="{{url('penjualanArchive')}}">
                <button class="btn-back">kembali ke semua hasil</button>
            </a>
        @endif
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
    @include('layouts.popupConfirm')
    
@endsection
