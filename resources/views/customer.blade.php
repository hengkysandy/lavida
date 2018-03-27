@extends('layouts.master')

@section('content')
    <div id="menu-customer"></div>
    <button id="tambahCustomer">Tambah customer</button>
    <div id="fade" class="blackoverlay"></div>
    <div id="light" class="whitecontent">
        <p class="req-field">
            <span class="field">
                * data wajib : kode customer, nama customer, Telpon PIC, Alamat
            </span>
        </p>
        <form class="popupForm" action="{{url('doInsertCustomer')}}" onsubmit="return validateData('customer')" method="post">
        {{csrf_field()}}
        <table>
            <!-- <tr>
                <td>kode customer</td>
                <td><input type="text" name="customerCode"  required></td>
            </tr> -->
            <tr>
                <td>nama customer</td>
                <td><input type="text" name="customerName"  required></td>
            </tr>
            <tr>
                <td>nama pic</td>
                <td><input type="text" name="picName"></td>
            </tr>
            <tr>
                <td>telepon pic</td>
                <td><input type="number" class="no-spin" name="contact" placeholder="hanya angka"  required></td>
            </tr>
            <!-- <tr>
                <td>email pic</td>
                <td><input type="text" name="email"></td>
            </tr> -->
            <tr>
                <td>lokasi customer</td>
                <td> <textarea name="location" id="" cols="21" rows="3"  required></textarea> </td>
            </tr>
            <tr>
                <td>deskripsi</td>
                <td> <textarea name="description" id="" cols="21" rows="3"></textarea> </td>
            </tr>
            <tr align="center">
                <td colspan="2">
                    <input type="submit" value="simpan">
                    <button type="button" onclick="popupOff()">batal</button>
                </td>
            </tr>
        </table>
    </form>
    </div>
    
    <h2>Cari berdasarkan kode or nama</h2>
    <form action="{{url('doSearchCustomer')}}" method="post">
        {!! csrf_field() !!}
        <input type="text" name="search" class="searchid" placeholder="input kode atau nama"  required>
        <input type="submit" value="cari">   
    </form>
    @if(isset($_REQUEST['search']) != "")
    <a href="{{url('customer')}}">
        <button class="btn-back">kembali ke semua hasil</button>
    </a>
    @endif
    <div id="page-target">
    <h2>customer Data</h2>
    <table border="1" class="table-data">
    <thead>
        <tr>
            <th class="table-head">id</th>
            <th>kode customer</th>
            <th>nama customer</th>
            <th>rincian customer</th>
            <th class="table-head-status">status</th>
            <th class="table-head-action">aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customerData as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->customer_code}}</td>
                <td>{{$data->customer_name}}</td>
                <td>
                    <button type="button" class="customerDetail" value="{{$data->id}}">lihat rincian </button>
                </td>
                @if($data->status == 1)
   <td>Aktif</td>
@else
   <td>Tidak Aktif</td>
@endif
                <td>
                    <div class="click">
                        <button type="button" onclick="confirmStatus('{{$data->id}}','{{$data->status}}','Customer')">Ganti Status</button>
                        <a href="{{url("updateCustomer?id=$data->id")}}">
                            <button type="button">Ubah</button>
                        </a>
                        <button type="button" onclick="confirmDelete('{{$data->id}}','Customer')">Hapus</button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>
    </div>
    @if(isset($_REQUEST['search']) == "")
    <div class="div-paging-button">
        @for($i = 1; $i <= $customerData->lastPage(); $i++)
            <button class="paging-button" onclick="doPaging({{$i}})">{{$i}}</button>
        @endfor
    </div>
    @endif
    @include('layouts.popupDetail')
    @include('layouts.popupConfirm')
    @include('layouts.errorMessage')
@endsection
