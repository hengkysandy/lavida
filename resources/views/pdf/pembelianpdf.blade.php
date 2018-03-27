<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h2>Arsip Data Pembelian</h2>
    
	<table border="1">
	<tr align="center">
		<th>Nomor</th>
		<th>Nomor Nota</th>
		<th>nama supplier</th>
		<th>Tanggal</th>
		<th>Status</th>

		<th>ID Barang</th>
		<th>Nama Barang</th>
		<th>Kuantitas Pembelian</th>
	</tr>
	@foreach($pembelianData as $key => $data)
	<tr align="center">
    <?php 
    	$pembelianDetailData = App\PembelianDetail::where('id_pembelian',$data->id)->get();
     ?>
		<td rowspan="{{count($pembelianDetailData)}}">{{$key+1}}</td>
		<td rowspan="{{count($pembelianDetailData)}}">{{$data->no_nota}}</td>
		<td rowspan="{{count($pembelianDetailData)}}">{{$data->Supplier()->first()->supplier_name}}</td>
		<td rowspan="{{count($pembelianDetailData)}}">{{date('d-m-Y', strtotime($data->datetime_estimate))}}</td>
		@if($data->status == 1)
			<td rowspan="{{count($pembelianDetailData)}}">Aktif</td>
		@else
		   <td rowspan="{{count($pembelianDetailData)}}">Tidak Aktif</td>
		@endif
		

	    <td>{{$pembelianDetailData[0]->item_id}}</td>
    	<td>{{$pembelianDetailData[0]->item_name}}</td>
    	<td>{{$pembelianDetailData[0]->purchase_qty}}</td>
	</tr>

		@foreach($pembelianDetailData as $key2 => $detail)
			@if($key2+1 != count($pembelianDetailData))
			<tr align="center">
				<td>{{$pembelianDetailData[$key2+1]->item_id}}</td>
		    	<td>{{$pembelianDetailData[$key2+1]->item_name}}</td>
		    	<td>{{$pembelianDetailData[$key2+1]->purchase_qty}}</td>
			</tr>
	    	@endif
		@endforeach
	
	@endforeach
    </table>
</body>
</html>