<?php

namespace App\Http\Controllers;

use App\Item;
use App\Log;
use App\Pembelian;
use App\PembelianDetail;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PembelianController extends Controller
{
    public function pembelian()
    {
       $pembelianData = Pembelian::orderBy('status','desc')->orderBy('datetime_transaction','DESC')->paginate(10);
       // $pembelianDataJoin = [];
       // foreach ($pembelianData as $data) {
       //     $pembelianDataJoin[] = [
       //         'pembelian' => $data,
       //         'supplier' => $data->Supplier()->first(),
       //         // 'detail' => $data->PembelianDetail()->get(),
       //     ];
       // }
        // return json_encode($pembelianData->Supplier()->first()->supplier_name);


        return view('pembelian')
            ->with('pembelianData',$pembelianData);
    }

    public function doSearchPembelian(Request $request){

        $supplierData = Supplier::all();

        // $pembelianData = Pembelian::where('no_nota', 'like', '%' .$request->search. '%')
        //         ->orderBy('status','desc')
        //         ->get();

        $pembelianData = Pembelian::whereDate('datetime_estimate','=', $request->search)
                ->orderBy('status','desc')
                ->get();

        return view('pembelian')
            ->with('supplierData',$supplierData)
            ->with('pembelianData',$pembelianData);
    }

    public function updatePembelian(Request $request)
    {
        $currData = Pembelian::find($request->id);

        $pembelianDetailData = PembelianDetail::join('items','items.id','=','pembelian_detail.item_id')->where('id_pembelian',$request->id)->get();

        return view('updatePembelian')
            ->with('pembelianDetailData',$pembelianDetailData)
            ->with('currData',$currData);
    }

    public function doUpdatePembelian(Request $request)
    {
        $data = $request->all();

        $currData = Pembelian::find($request->id);

        $getDateTimeNow = Carbon::now()->toDateTimeString();

        $currData->supplier_id = $data['supplierId'];
        $currData->datetime_estimate = str_replace('/','-',$data['estimate']).':00';
        // $currData->datetime_transaction = str_replace('/','-',$data['getDateTimeNow']).':00';
        // $currData->no_nota = $data['noNota'];
        $currData->save();

        $detailData = PembelianDetail::where('id_pembelian',$request->id);

        foreach ($detailData->get() as $d) {
            //masukkan kembali semua kuantitas yang dibeli
            $currItem = Item::find($d->item_id);
            $currItem->item_qty -= $d->purchase_qty;
            $currItem->save();
        }

        $detailData->delete();

        $getItemLatestId = Item::orderBy('id','DESC')->first()->id;

        for ($i=0; $i <= $getItemLatestId; $i++) { 
            if(isset($data['cekBarang'.$i])){
                // dd($data);
                PembelianDetail::create([
                    'id_pembelian' => $data['id'],
                    'item_id' => $data['cekBarang'.$i],
                    'item_name' => $data['namaBarang'.$i],
                    'supplier_id' => $data['supplierId'],
                    // 'supplier_id' => NULL,
                    'purchase_qty' => $data['qtyBeli'.$i],
                    'datetime_transaction' => $getDateTimeNow,
                    'status' => '1',
                ]);

                $currItemNew = Item::find($data['cekBarang'.$i]);
                $currItemNew->item_qty += $data['qtyBeli'.$i];
                $currItemNew->save();
            }
        }

        $logName = 'user id : '.auth()->user()->id.
                    ' telah mengupdate data pembelian pada id : '
                    .$request->id;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('pembelian')->withErrors(['Sukses!!','berhasil mengupdate data pembelian']);
    }

    public function doChangePembelianStatus(Request $request)
    {
        $status = "";

        $currData = Pembelian::find($request->id);

        if($currData->status == "1"){
            $status = "0";
        }else{
            $status = "1";
        }

        $currData->status = $status;
        $currData->save();

        $logName = 'user id : '.auth()->user()->id.
            ' telah mengganti status data pembelian pada id : '
            .$request->id.' menjadi '.$status;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('pembelian')->withErrors(['Sukses!!','berhasil mengganti status data pembelian']);
    }

    public function doInsertPembelian(Request $request)
    {
        $data = $request->all();
        $getDateTimeNow = Carbon::now()->toDateTimeString();
        // $getDateTimeNow = $data['getDateTimeNow'];
        $random_code = "PB" . mt_rand(10000, 99999);
        $getItemLatestId = Item::orderBy('id','DESC')->first()->id;

        Pembelian::create([
            // 'no_nota' => $data['noNota'],
            'no_nota' => $random_code,
            'supplier_id' => $data['supplierId'],
            // 'supplier_id' => NULL,
            'datetime_transaction' => $getDateTimeNow, //not used
            'datetime_estimate' => str_replace('/','-',$data['estimate']).':00', //tgl brg dtg
            'status' => '1',
        ]);

        $getPembelianLatestId = Pembelian::orderBy('id','DESC')->first()->id;
        
        for ($i=0; $i <= $getItemLatestId; $i++) { 
            if(isset($data['cekBarang'.$i])){
                PembelianDetail::create([
                    'id_pembelian' => $getPembelianLatestId,
                    'item_id' => $data['cekBarang'.$i],
                    'item_name' => $data['namaBarang'.$i],
                    'supplier_id' => $data['supplierId'],
                    // 'supplier_id' => NULL,
                    'purchase_qty' => $data['qtyBeli'.$i],
                    'datetime_transaction' => $getDateTimeNow,
                    'status' => '1',
                ]);


                $currItem = Item::find($data['cekBarang'.$i]);
                $currItem->item_qty += $data['qtyBeli'.$i];
                $currItem->save();

                $logName = 'user id : '.auth()->user()->id.
                    ' telah membeli barang pada id : '
                    .$data['cekBarang'.$i].' sebanyak '.$data['qtyBeli'.$i];

                Log::create([
    'userid' => auth()->user()->id,
                    'name' => $logName
                ]);
            }
        }
        return redirect('pembelian')->withErrors(['Sukses!!','berhasil menambahkan data pembelian baru']);
    }

    public function pembelianDetailAjax($id){
        $data = PembelianDetail::join('items','items.id','=','pembelian_detail.item_id')
        ->where('id_pembelian',$id)->get();
        return $data;
    }

    public function doDeletePembelian(Request $request){
        $currData = Pembelian::find($request->id);
        $currData->status = "0";
        $currData->save();

        $logName = 'user id : '.auth()->user()->id.
            ' telah menghapus data pembelian pada id : '
            .$request->id;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('pembelian')->withErrors(['Sukses!!','berhasil menghapus data pembelian']);
    }

    public function loadPembelianDetailAjax($id)
    {
        $pembelianDetailData = PembelianDetail::where('id_pembelian',$id)->get();
        return $pembelianDetailData;
    }

    public function pembelianRecap()
    {
       return view('pembelianRecap');
    }

    public function doRecapPembelian(Request $request)
    {
        //$pembelianData = Pembelian::whereBetween('datetime_estimate', [$request->searchFrom, $request->searchTo])->get();

        $pembelianData = Pembelian::whereDate('datetime_estimate','>=', $request->searchFrom)
                ->whereDate('datetime_estimate','<=', $request->searchTo)
                ->get();

        return view('pembelianRecap')
            ->with('pembelianData',$pembelianData);
    }

    public function pembelianArchive()
    {
        $pembelianData = pembelian::whereDate('datetime_estimate','<=', Carbon::now()->subMonths(4))->get();
        return view('pembelianArchive')
            ->with('pembelianData',$pembelianData);
    }

    public function doSearchArchivePembelian(Request $request)
    {
        $from = $request->searchFrom;
        $to = $request->searchTo;

        $pembelianData = Pembelian::whereDate('datetime_estimate','>=', $from)
                ->whereDate('datetime_estimate','<=', $to)
                ->whereDate('datetime_estimate','<=', Carbon::now()->subMonths(4))
                ->get();


        return view('pembelianArchive')
            ->with('pembelianData',$pembelianData)
            ->with('from',$from)
            ->with('to',$to);
    }
}
