@extends('layouts.master')

@section('content')
    <h2>Catatan Sistem</h2>
    <hr>
    <h2>Cari berdasarkan Id Pengguna</h2>
    <input type="text" name="search" id="searchLog" class="searchid" placeholder="input kata yang mengandung" value="user id : " onfocus="value='user id : '" onclick="value='user id : '"  required>
    <div class="scroll-log">
        <table class="table-data" border="1">
        <thead>
            <tr>
                <th style="width: 50px">id pengguna</th>
                <th>aktivitas pengguna</th>
                <th>tanggal/jam</th>
            </tr>
        </thead>
        <tbody id="load-data-log">
        @foreach($logData as $log)
            <tr style="border-bottom: 1px solid;height: 30px;">
                <td>{{$log->userid}}</td>
                <td>{{$log->name}}</td>
                <td>{{$log->created_at}}</td>
            </tr>
        @endforeach
        </tbody>    
        </table>
    </div>
@endsection