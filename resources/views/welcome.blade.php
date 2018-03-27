@extends('layouts.master')

@section('content')

    <div class="wrapper-welcome">
        <div class="info">
            <h2>STTS Consultancy</h2>
            <p>Nama Developer : hengky sandy</p>
            <p>Email Developer : hengky@sttsconsultancy.com</p>
            <p>No Tlp Developer : 0857-7211-5258</p>
        </div>
        <div class="login">
            <h2>user login</h2>
            <form action="{{url('doLogin')}}" method="post">
                {{csrf_field()}}
                <input type="text" name="email" placeholder="email"> <br>
                <input type="password" name="password" placeholder="password"> <br>
                <input type="submit" value="login">
            </form>
        <table>
            @foreach($errors->all() as $err)
                <tr>
                    <td>
                        <span style="color: red; font-size: 20px">
                            {{$err}}
                        </span>
                    </td>
                </tr>
            @endforeach
        </table>
        </div>
    </div>
@endsection