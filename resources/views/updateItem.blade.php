@extends('layouts.master')

@section('content')
    <h2>ubah data Barang</h2>
    <form action="{{url('doUpdatetItem')}}" method="post">
        {{csrf_field()}}
        <table>
            <input type="hidden" name="id" value="{{$currData->id}}">
            <tr>
                <td colspan="2"><span class="field">* data wajib : Kode Barang, Nama Barang,  SKU Barang, minimal kuantitas, supplier</span></td>
            </tr>
            <tr>
                <td>kode barang</td>
                <td><input type="text" name="itemCode" value="{{$currData->item_code}}"></td>
            </tr>
            <tr>
                <td>SKU barang</td>
                <td><input type="text" name="itemSku" value="{{$currData->item_sku}}"></td>
            </tr>
            <tr>
                <td>merek barang</td>
                <td><input type="text" name="itemBrand" value="{{$currData->item_brand}}"></td>
            </tr>
            <tr>
                <td>Nama Barang</td>
                <td><input type="text" name="name" value="{{$currData->item_name}}"  required></td>
            </tr>
            <tr>
                <td>kategori barang</td>
                <td>
                    <select name="category" id="">
                    @foreach($cateData as $cate)
                        @if($currData->item_category != $cate->id)
                            <option value="{{$cate->id}}">{{$cate->name}}</option>
                        @else
                            <option value="{{$cate->id}}" selected="selected">{{$cate->name}}</option>
                        @endif
                    @endforeach
                </select>
                </td>
            </tr>
            <tr>
                <td>minimal kuantitas barang</td>
                <td><input type="number" name="minQty" min="1" value="{{$currData->item_min_qty}}" placeholder="hanya angka"  required></td>
            </tr>
            <tr align="center">
                <td colspan="2">
                    <input type="submit" value="perbarui">
                    <a href="{{url('barang')}}">
                        <button type="button">batal</button>
                    </a>
                </td>
            </tr>
        </table>
    </form>
@endsection