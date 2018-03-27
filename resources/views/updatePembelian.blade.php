@extends('layouts.master')

@section('content')
    <div id="menu-update-pembelian"></div>
    <h2>ubah data pembelian</h2>
    <form action="{{url('doUpdatePembelian')}}" onsubmit="return validateInsertPembelian()" method="post">
        {{csrf_field()}}
        <table id="table-pembelian-supplier">
            <!-- <tr>
                <td>Tanggal PO</td>
                <td><input type="text" name="getDateTimeNow" class="datetimepicker" value="{{$currData->datetime_transaction}}"  required/></td>
            </tr> -->
            <tr>
                <td>Tanggal Barang Datang</td>
                <td><input type="text" name="estimate" class="datetimepicker" value="{{$currData->datetime_estimate}}"  required/></td>
            </tr>
                    <input type="hidden" name= "id" id="currPembelianId" value="{{$currData->id}}">
            <tr id="selectedSupplier">
                <td>nama supplier</td>
                <td>
                    <input type="hidden" name="supplierId" id="currSupplierId" value="{{$currData->supplier_id}}">
                    {{$currData->Supplier()->first()->supplier_name}}
                    <i class="fa fa-times-circle fa-lg remove-item" onclick="removeSupplier()" aria-hidden="true"></i>
                </td>
            </tr>
        </table>
        <button type="button" id="btnAddBarang" onclick="addBarang()">Tambah Barang</button>
        <div class="table-data">
        <table border="1" class="table-data">
        <thead>
            <tr>
                <th style="width: 100px;">kode barang</th>
                <th>nama barang</th>
                <th>kuantitas barang</th>
                <th>jumlah beli</th>
                <th style="width: 100px;">aksi</th>    
            </tr>
        </thead>
        <tbody id="selectedItem">
            @foreach($pembelianDetailData as $dataDt)
            <tr>
                <td>{{$dataDt->item_code}}
                    <input type="hidden" name="cekBarang{{$dataDt->item_id}}" id="itemId" value="{{$dataDt->item_id}}">
                    <input type="hidden" name="id" id="currPembelianId" value="{{$currData->id}}">
                </td>
                <td>{{$dataDt->item_name}}
                    <input type="hidden" name="namaBarang{{$dataDt->item_id}}" value="{{$dataDt->item_name}}">
                </td>
                <td>{{$dataDt->Item()->first()->item_qty - $dataDt->purchase_qty}}
                </td>
                <td><input type='number' min='1' name="qtyBeli{{$dataDt->item_id}}" value="{{$dataDt->purchase_qty}}" class='qtyBeli'  required></td>
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
            <a href="{{url('pembelian')}}">
                <button type="button">batal</button>
            </a>
        </p>
    </form>
    @include('layouts.popup')
    @include('layouts.popupSupplier')
@endsection