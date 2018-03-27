@extends('layouts.master')

@section('content')
    <div id="menu-update-penjualan"></div>
    <h2>ubah data penjualan</h2>
    <form action="{{url('doUpdatePenjualan')}}" onsubmit="return validateInsertPenjualan()" method="post">
        {{csrf_field()}}
        <input type="hidden" name="totalItem" value="{{$totalItem}}">
        <table id="table-penjualan-customer">
            <input type="hidden" name= "id" id="currPenjualanId" value="{{$currData->id}}">
            <!-- <tr>
                <td>Tanggal SO</td>
                <td><input type="text" name="getDateTimeNow" class="datetimepicker" value="{{$currData->datetime_transaction}}"  required/></td>
            </tr> -->
            <tr>
                <td>Tanggal Penjualan</td>
                <td><input type="text" name="estimate" class="datetimepicker" value="{{$currData->datetime_estimate}}"  required/></td>
            </tr>
            <tr id="selectedCustomer">
                <td>nama customer</td>
                <td>
                    <input type="hidden" name="customerId" id="customerId" value="{{$currData->customer_id}}">
                    {{$currData->Customer()->first()->customer_name}}
                    <i class="fa fa-times-circle fa-lg remove-item" onclick="removeCustomer()" aria-hidden="true"></i>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td colspan="2">
                    <button type="button" id="btnAddBarang" onclick="addBarang()">Tambah Barang</button>
                </td>
            </tr>
        </table>
        <div class="table-update-penjualan">
            <table border="1" class="table-data">
            <thead>
                <tr>
                    <th style="width: 100px;">id barang</th>
                    <th>Nama Barang</th>
                    <th>kuantitas Barang</th>
                    <th>Jumlah Jual</th>
                    <th style="width: 100px;">aksi</th>
                </tr>
            </thead>
            <tbody id="selectedItem">
                @foreach($penjualanDetailData as $dataDt)
                <tr>
                    <td>{{$dataDt->item_id}}
                        <input type="hidden" name="cekBarang{{$dataDt->item_id}}" id="itemId" value="{{$dataDt->item_id}}">
                    </td>
                    <td>{{$dataDt->item_name}}
                        <input type="hidden" name="namaBarang{{$dataDt->item_id}}" value="{{$dataDt->item_name}}">
                    </td>
                    <td class="totalQty{{$dataDt->item_id}}">{{$dataDt->Item()->first()->item_qty}}
                    </td>
                    <td><input type='number' min='1' name="qtyBeli{{$dataDt->item_id}}" value="{{$dataDt->selling_qty}}" class='qtyBeli'  required></td>
                    <td>
                       <i class="fa fa-times-circle fa-2x remove-item" aria-hidden="true"></i>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        <p align="right">
            <input type="submit" value="perbarui">
            <a href="{{url('penjualan')}}">
                <button type="button">batal</button>
            </a>
        </p>
    </form>
    </form>
    @include('layouts.popup')
    @include('layouts.popupCustomer')
@endsection