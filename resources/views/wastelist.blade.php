@extends('layouts.master')

@section('content')
    <id id="menu-wastelist"></id>
    <h2>Daftar Kerugian</h2>
    <h2>Cari berdasarkan tanggal</h2>
    <form action="{{url('doSearchWaste')}}" method="post">
        {!! csrf_field() !!}
        <input type="text" name="search" class="searchid datepicker" placeholder="input tanggal"  required>
        <input type="submit" value="cari">   
    </form>
    @if(isset($_REQUEST['search']) != "")
    <a href="{{url('wastelist')}}">
        <button class="btn-back">kembali ke semua hasil</button>
    </a>
    @endif
    <table border="1" class="table-data">
        <thead>
        <tr>
            <th class="table-head">id</th>
            <th>nomor retur</th>
            <th>tanggal/jam retur</th>
            <th>rincian kerugian</th>
            <th class="table-head-status">status</th>
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
@endsection