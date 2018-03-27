<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Control</title>
    
    <meta property="og:image" content="https://scontent-sit4-1.xx.fbcdn.net/v/t1.0-9/21432827_621075488281045_5464104855163678344_n.jpg?oh=8a962b27ecd67f185fcd40c5eac9137f&oe=5A5DA001" />
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">

    <script src={{asset('js/jquery.js')}}></script>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('asset/font-awesome-4.6.3/css/font-awesome.min.css')}}">

    <!-- datetimepicker jquery css -->
    <link rel="stylesheet" href="{{asset('css/jquery.datetimepicker.css')}}"/>

    <!-- tablesorter jquery-->
    <link rel="stylesheet" href="{{asset('css/theme.default.css')}}">
    <script src={{asset('js/jquery.tablesorter.min.js')}}></script>
    <script>
        $(function(){
            $('.table-data').tablesorter();
        });
    </script>
</head>
<body>
<div class="header">
    <img src="{{asset('asset/LAVIDA.png')}}" alt="">
    @if(auth()->check())
    <?php 
        $notifData = \App\Notification::where('read','false')->get();
    ?>
    <span class="bell">
         <i class="fa fa-bell-o fa-2x" aria-hidden="true"></i> 
    @if(count($notifData) != 0)
         <div class="dropdown-content">
         @foreach($notifData as $data)
         <a href="{{url("doReadNotif?id=$data->id")}}">
            <div class="drop-content">
                <p>{{$data->description}}</p>
                <hr>
            </div>
         </a>
         @endforeach
         </div>
    </span>
    <span class="exclamation"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i> </span>
    @endif
    <span class="welcome-text">
        Selamat Datang, {{auth()->user()->name}} | <a class="log-out" href="{{url('logout')}}"> <i class="fa fa-sign-out" aria-hidden="true"></i>Keluar</a>
    </span>
    @endif
</div>
<div class="container-nav-content">
    @if(auth()->check())
        @include('layouts.navigation')
    @endif
    @if(auth()->check())
        <div class="content">
            @yield('content')
        </div>
    @else
        @yield('content')
    @endif
    @include('layouts.customErrMessage')
    @include('layouts.popupDelete')
</div>
<script src={{asset('js/jquery.datetimepicker.full.js')}}></script>
<script type="text/javascript" src="{{asset('js/myscript.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.masked.min.js')}}"></script>
</body>
</html>