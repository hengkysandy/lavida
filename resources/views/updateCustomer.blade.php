@extends('layouts.master')

@section('content')
    <h2>update customer data</h2>
    <form action="{{url('doUpdateCustomer')}}" onsubmit="return validateData('updateCustomer')" method="post">
        {{csrf_field()}}
        <table>
        <input type="hidden" name="id" value="{{$currData->id}}">
            <tr>
                <td colspan="2"><span class="field">* data wajib : kode customer, nama customer, Telpon PIC, Alamat</span></td>
            </tr>
            <tr>
                <td>nama customer</td>
                <td><input type="text" name="customerName" value="{{$currData->customer_name}}"  required></td>
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
                <td>lokasi customer</td>
                <td> <textarea name="location" id="" cols="21" rows="3"  required>{{$currData->customer_location}}</textarea> </td>
            </tr>
            <tr>
                <td>deskripsi</td>
                <td> <textarea name="description" id="" cols="21" rows="3">{{$currData->customer_description}}</textarea> </td>
            </tr>
            <tr align="center">
                <td colspan="2">
                    <input type="submit" value="perbarui">
                    <a href="{{url('customer')}}">
                        <button type="button">batal</button>
                    </a>
                </td>
            </tr>
        </table>
    </form>
@endsection