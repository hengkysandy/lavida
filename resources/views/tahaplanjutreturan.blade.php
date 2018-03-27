@extends('layouts.master')

@section('content')
    <h2>Data Penjualan</h2>
    <p>tanggal returan : {{$datetime_returan}}</p>
    <form action="{{url('doInsertReturan')}}" method="post">
        {{csrf_field()}}
    <table border="1" class="table-data">
        <thead>
        <tr>
            <th class="table-head">id penjualan</th>
            <th>nama customer</th>
            <th style="width: 600px;">rincian penjualan</th>
            <th>tanggal/jam transaksi</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $a = 0;
            ?>
            @foreach($penjualanDataJoin as $data)
                <tr>
                    <td>{{$data['penjualan']->id}}</td>
                    <input type="hidden" name= "idPenjualan{{$a}}" value="{{$data['penjualan']->id}}">
                    <td>{{$data['customer']->customer_name}}</td>
                    <td>
                        <?php
                        $j = 0;
                        ?>
                        @foreach($data['itemdetail'] as $detail)
                            ({{$detail[0]->item_code}})
                            {{$detail[0]->item_name}} <span> : </span>
                            <input type="hidden" name= "itemId{{$i}}" value="{{$detail[0]->id}}">
                            <input type="hidden" name="currSellingQty{{$i}}" value="{{$data['detail'][$j]->selling_qty_temp}}">
                            {{$data['detail'][$j]->selling_qty_temp}} pcs ->
                            layak : <input type="number" min="0" value="0" name="qtyLayak{{$i}}" class="qtyBeli">
                            rusak : <input type="number" min="0" value="0" name="qtyRusak{{$i}}" class="qtyBeli">
                            <?php
                            $j+=1;
                            $i+=1;
                            ?>
                            <br>
                        @endforeach
                        <input type="hidden" name="jumlahItemPerPenjualan{{$a}}" value="{{count($data['itemdetail'])}}">
                    </td>
                    <td>{{$data['penjualan']->datetime_transaction}}</td>
                    <?php
                    $id = $data['penjualan']->id;
                    $a+=1;
                    ?>
                </tr>
            @endforeach
            <input type="hidden" name= "jumlahPenjualan" value="{{count($penjualanDataJoin)}}">
            <input type="hidden" name= "jumlahItem" value="{{$i}}">
            <input type="hidden" name= "datetime_returan" value="{{$datetime_returan}}">
        </tbody>
    </table>
        <input type="submit" value="simpan" style="float:right;"/>
        <a href="{{url('transaksireturan')}}">
            <button type="button">batal</button>
        </a>
    </form>

@endsection