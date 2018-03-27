@extends('layouts.master')

@section('content')
    <h2>Tambah Kategori</h2>
    <form action="{{url('doUpdateCategory')}}" onsubmit="return validateUpdateCategory()" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$currData->id}}">
        <table>
            <tr>
                <td>nama kategori</td>
                <td><input type="text" name="name" value="{{$currData->name}}"  required></td>
            </tr>
            <tr>
                <tr align="center">
                <td colspan="2">
                    <input type="submit" value="perbarui">
                    <a href="{{url('kategori')}}">
                        <button type="button">batal</button>
                    </a>
                </td>
            </tr>
            </tr>
        </table>
    </form>
@endsection
