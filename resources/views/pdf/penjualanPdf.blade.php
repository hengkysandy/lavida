<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h2>Arsip Data Penjualan</h2>
    <?php
    	$dataArrayReturan = [];
    	$responseReturanDetail = [];

    	$returan_detail_status = [];
        $penjualan_detail = []
    ?>
	<table border="1">
	<tr align="center">
		<th>Nomor</th>
		<th>Nomor Nota</th>
		<th>nama customer</th>
		<th>Tanggal</th>
		<th>Telah diretur</th>

		<th>ID Barang</th>
		<th>Nama Barang</th>
		<th>Kuantitas Penjualan</th>
	</tr>
	@foreach($penjualanData as $key => $data)
	<tr align="center">
    <?php 
    	$PenjualanDetailData = App\PenjualanDetail::where('id_penjualan',$data->id)->get();

     ?>
		<td rowspan="{{count($PenjualanDetailData)}}">{{$key+1}}</td>
		<td rowspan="{{count($PenjualanDetailData)}}">{{$data->no_nota}}</td>
		<td rowspan="{{count($PenjualanDetailData)}}">{{$data->Customer()->first()->customer_name}}</td>
		<td rowspan="{{count($PenjualanDetailData)}}">{{date('d-m-Y', strtotime($data->datetime_estimate))}}</td>
		@if($data->remark_returan == "yes")
			<td rowspan="{{count($PenjualanDetailData)}}">Iya</td>
		@else
		   <td rowspan="{{count($PenjualanDetailData)}}">Tidak</td>
		@endif
		

	    <td>{{$PenjualanDetailData[0]->item_id}}</td>
    	<td>{{$PenjualanDetailData[0]->item_name}}</td>
    	<td>{{$PenjualanDetailData[0]->selling_qty}}</td>
	</tr>

		@foreach($PenjualanDetailData as $key2 => $detail)
		 <?php 
    		$currReturanId = App\ReturanDetail::where('id_detail_penjualan',$detail->id)->first();
    		if(count($currReturanId) != 0){
	    		if(!in_array($currReturanId->id_returan, $dataArrayReturan)){
	    			$dataArrayReturan[] = $currReturanId->id_returan;
	    		}
    		}
    		
	    		
	     ?>
			@if($key2+1 != count($PenjualanDetailData))
			<tr align="center">
				<td>{{$PenjualanDetailData[$key2+1]->item_id}}</td>
		    	<td>{{$PenjualanDetailData[$key2+1]->item_name}}</td>
		    	<td>{{$PenjualanDetailData[$key2+1]->selling_qty}}</td>
			</tr>
	    	@endif
		@endforeach

	
	@endforeach
    </table>
    @if(!empty($dataArrayReturan))
    <?php
    	$returanData = App\Returan::whereIn('returans.id',
    	explode( ",", implode(",",$dataArrayReturan) ) )->get();
    ?>
    <br> <br> <br> <br>
    <h2>Data Returan yang bersangkutan</h2>
    <table border="1">
        <tr align="center">
            <th>nomor</th>
            <th>nomor retur</th>
            <th>tanggal</th>
            <th>status</th>

            <th>nama barang</th>
            <th>jumlah jual</th>
            <th>jumlah retur</th>
            <th>kuantitas rugi</th>
            <th>kuantitas kembali</th>
        </tr>
        @foreach($returanData as $rkey => $rdata)

        <?php
	        $returanDetailData= App\ReturanDetail::where('id_returan',$rdata->id)->get();
	        foreach($returanDetailData as $rd){
	        $r1 = App\ReturanDetailStatus::where('id_returan_detail',$rd->id)->first();
	        $r2 = App\PenjualanDetail::find($rd->id_detail_penjualan);

	            $returan_detail_status[] = $r1;
        		$penjualan_detail[] = $r2;
	        }
        ?>

        <tr align="center">
            <td rowspan="{{count($returanDetailData)}}">{{$rkey+1}}</td>
            <td rowspan="{{count($returanDetailData)}}">{{$rdata->no_retur}}</td>
            <td rowspan="{{count($returanDetailData)}}">{{date('d-m-Y', strtotime($rdata->datetime_estimate))}}</td>
            
            @if($rdata->status == 1)
			   <td rowspan="{{count($returanDetailData)}}">Aktif</td>
			@else
			   <td rowspan="{{count($returanDetailData)}}">Tidak Aktif</td>
			@endif

			<td>{{$returanDetailData[0]->item_name}}</td>
	    	<td>{{$penjualan_detail[0]->selling_qty}}</td>
			<td>{{$returanDetailData[0]->qty_retur}}</td>
	    	<td>{{$returan_detail_status[0]->qty_waste}}</td>
	    	<td>{{$returan_detail_status[0]->qty_kembali}}</td>

	    	@foreach($returanDetailData as $kkk => $rdrd)
		 
				@if($kkk+1 != count($returanDetailData))
				<tr align="center">
					<td>{{$returanDetailData[$kkk+1]->item_name}}</td>
			    	<td>{{$penjualan_detail[$kkk+1]->selling_qty}}</td>
					<td>{{$returanDetailData[$kkk+1]->qty_retur}}</td>
			    	<td>{{$returan_detail_status[$kkk+1]->qty_waste}}</td>
			    	<td>{{$returan_detail_status[$kkk+1]->qty_kembali}}</td>
				</tr>
		    	@endif
		@endforeach
		<?php
			$returan_detail_status = [];
    		$penjualan_detail = [];
		?>

            
        </tr>
        @endforeach
    </table>

    @endif
</body>
</html>