@extends('layouts.master')

@section('content')
    <h2>update supplier data</h2>
    <form action="{{url('doUpdateSupplier')}}" onsubmit="return validateData('supplier')" method="post">
        {{csrf_field()}}
        <table>
            <tr>
                <td colspan="2"><span class="field">* data wajib : Kode supplier, nama supplier, Telpon PIC, Alamat</span></td>
            </tr>
            <tr>
                <td>kode supplier</td>
                <td><input type="text" name="supplierCode" value="{{$currData->supplier_code}}"  required></td>
            </tr>
            <tr>
                <td>nama supplier
                    <input type="hidden" name="id" value="{{$currData->id}}">
                </td>
                <td><input type="text" name="supplierName" value="{{$currData->supplier_name}}"  required></td>
            </tr>
            <tr>
                <td>nama pic</td>
                <td><input type="text" name="picName" value="{{$currData->pic_name}}"></td>
            </tr>
            <tr>
                <td>telepon pic</td>
                <td><input type="number" name="contact" class="no-spin" placeholder="hanya angka" value="{{$currData->pic_contact}}"  required></td>
            </tr>
            <tr>
                <td>lokasi supplier</td>
                <td> <textarea name="location" id="" cols="21" rows="3"  required>{{$currData->supplier_location}}</textarea> </td>
            </tr>
            <tr>
                <td>deskripsi</td>
                <td> <textarea name="description" id="" cols="21" rows="3">{{$currData->supplier_description}}</textarea> </td>
            </tr>
            <tr align="center">
                <td colspan="2">
                    <input type="submit" value="perbarui">
                    <a href="{{url('supplier')}}">
                        <button type="button">batal</button>
                    </a>
                </td>
            </tr>
        </table>
    </form>
@endsection