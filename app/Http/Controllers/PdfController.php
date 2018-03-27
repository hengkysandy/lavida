<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pembelian;
use App\Penjualan;
use App\PenjualanDetail;
use App\Returan;
use App\ReturanDetail;
use App\Log;

use PDF;
use Carbon\Carbon;
use Session;

class PdfController extends Controller
{
    public function PembelianPdf($from,$to)
    {
    	if($from == "kosong"){
            $pembelianData = pembelian::whereDate('datetime_estimate','<=', Carbon::now()->subMonths(4))->get();
    	}else{
    		$pembelianData = Pembelian::whereDate('datetime_estimate','>=', $from)
	                ->whereDate('datetime_estimate','<=', $to)
	                ->whereDate('datetime_estimate','<=', Carbon::now()->subMonths(4))
	                ->get();
    	}

    	$pdf = PDF::loadView('pdf.pembelianpdf',[ 'pembelianData' => $pembelianData]);


    	return $pdf->download('arsip_pembelian_'.date('d-m-Y', strtotime(Carbon::now())).'.pdf');
    }

    public function deletePembelianArchive($from,$to)
    {
    	if($from == "kosong"){
            $pembelianData = pembelian::whereDate('datetime_estimate','<=', Carbon::now()->subMonths(4))->get();
    	}else{
    		$pembelianData = Pembelian::whereDate('datetime_estimate','>=', $from)
	                ->whereDate('datetime_estimate','<=', $to)
	                ->whereDate('datetime_estimate','<=', Carbon::now()->subMonths(4))
	                ->get();
    	}

    	foreach ($pembelianData as $key => $data) {
    		Pembelian::find($data->id)->delete();
    	}

    	$logName = 'user id : '.auth()->user()->id.
                    ' telah mengarsip data pembelian';

                Log::create([
    'userid' => auth()->user()->id,
                    'name' => $logName
                ]);
            

    	return redirect('pembelian')->withErrors(['Sukses!!','berhasil mengarsip data pembelian']);
    }

    public function PenjualanPdf($from,$to)
    {
    	if($from == "kosong"){
            $penjualanData = Penjualan::whereDate('datetime_estimate','<=', Carbon::now()->subMonths(4))->get();
    	}else{
    		$penjualanData = Penjualan::whereDate('datetime_estimate','>=', $from)
	                ->whereDate('datetime_estimate','<=', $to)
	                ->whereDate('datetime_estimate','<=', Carbon::now()->subMonths(4))
	                ->get();
    	}

    	$pdf = PDF::loadView('pdf.penjualanPdf',[ 'penjualanData' => $penjualanData]);


    	return $pdf->download('arsip_penjualan_'.date('d-m-Y', strtotime(Carbon::now())).'.pdf');
    }

    public function deletePenjualanArchive($from,$to)
    {
    	// $bego = 0;
    	// for ($i=0; $i < 1000000; $i++) { 
    	// 	$bego+=2;
    	// }
    	if($from == "kosong"){
            $penjualanData = Penjualan::whereDate('datetime_estimate','<=', Carbon::now()->subMonths(4))->get();
    	}else{
    		$penjualanData = Penjualan::whereDate('datetime_estimate','>=', $from)
	                ->whereDate('datetime_estimate','<=', $to)
	                ->whereDate('datetime_estimate','<=', Carbon::now()->subMonths(4))
	                ->get();
    	}

    	$dataArrayReturan = [];

    	foreach ($penjualanData as $key => $data) {

    		$PenjualanDetailData = PenjualanDetail::where('id_penjualan',$data->id)->get();

    		foreach ($PenjualanDetailData as $key2 => $value2) {
    			$currReturanId = ReturanDetail::where('id_detail_penjualan',$value2->id)->first();
	    		if(count($currReturanId) != 0){
		    		if(!in_array($currReturanId->id_returan, $dataArrayReturan)){
		    			$dataArrayReturan[] = $currReturanId->id_returan;
		    		}
	    		}

    		}

    		if(!empty($dataArrayReturan)){
    			$returanData = Returan::whereIn('returans.id',
    		explode( ",", implode(",",$dataArrayReturan) ) )->get();

    			foreach ($returanData as $key3 => $value3) {
    				Returan::find($value3->id)->delete();
    			}
    		}
    		

    		Penjualan::find($data->id)->delete();
    	}

    	$logName = 'user id : '.auth()->user()->id.
                    ' telah mengarsip data penjualan';

                Log::create([
    'userid' => auth()->user()->id,
                    'name' => $logName
                ]);
            

    	return redirect('penjualan')->withErrors(['Sukses!!','berhasil mengarsip data penjualan']);
    }
}
