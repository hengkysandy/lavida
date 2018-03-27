<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Penjualan;
use App\PenjualanDetail;
use App\Returan;
use App\ReturanDetail;
use App\ReturanDetailStatus;
use App\Kembali;
use App\Item;
use App\Customer;
use App\WasteList;
use App\Log;
use App\Supplier;

use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TransaksiController extends Controller
{
    public function transaksireturan()
    {
        // $currPenjualanDt = PenjualanDetail::where('id_penjualan',4)->get();
        // return $a = $currPenjualanDt->where('item_id',1)->first();//harus int, kalo string '1' gk bs
        // return $a->item_name;

        // $penjualanData = Penjualan::join('customers','customers.id','=','penjualans.id')->where('remark_returan','no')->get();
        // return $penjualanData = Penjualan::where('remark_returan','no')->get();
        // $returanData = Returan::get();
        // $returanDataJoin = [];
        // foreach ($returanData as $data) {
        //     $dataDetail = [];
        //     foreach ($data->WasteList()->get() as $detail) {
        //         $dataDetail[] = $detail->Item()->get();
        //     }
        //     $returanDataJoin[] = [
        //         'returan' => $data,
        //         'detail' => $data->WasteList()->get(),
        //         'returanDetail' => $data->ReturanDetail()->get(),
        //         'itemdetail' => $dataDetail,
        //     ];
        // }

        $returanData = Returan::orderBy('status','desc')->orderBy('datetime_transaction','DESC')->paginate(10);
        // $returanData = DB::select('select * from returans r join returan_detail rd on r.id = rd.id_returan');


        return view('transaksireturan')
            ->with('returanData',$returanData);
    }

    public function doUpdateReturan(Request $request)
    {
        $data = $request->all();

        for ($i=0; $i < $data['jumlahItem']; $i++) { //validasi cek stock yang di input
            if(isset($data['currSellingQty'.$i])){
                if($data['currSellingQty'.$i] < ($data['qtyRusak'.$i] + $data['qtyLayak'.$i]) || $data['currSellingQty'.$i] > ($data['qtyRusak'.$i] + $data['qtyLayak'.$i])){
                    return redirect('transaksireturan')
                        ->withErrors(['Error!!','gagal update, inputan kuantitas tidak sesuai']);
                }
            }
        }

        $currReturan = Returan::find($request->id_returan);
        $currReturan->datetime_transaction = $data['datetime_returan'];
        $currReturan->save();

        $deleteWaste = WasteList::where('id_returan',$request->id_returan)->delete();

        for ($i=0; $i < $data['jumlahItem']; $i++) {

            if($data['qtyRusak'.$i] != 0){
                //masukan ke waste list
                WasteList::create([
                    'id_returan' => $request->id_returan,
                    'item_code' => $data['itemCode'.$i],
                    'item_broken_qty' => $data['qtyRusak'.$i]
                ]);
            }

            if($data['qtyLayak'.$i] != 0){
                $currItem = Item::find($data['itemCode'.$i]);
                $currItem->item_qty += $data['qtyLayak'.$i];
                $currItem->save();
            }
        }

        $logName = 'user id : '.auth()->user()->id.
            ' telah mengubah data returan dengan id : '
            .$request->id_returan;


        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('transaksireturan')->withErrors(['Sukses!!','berhasil mengupdate data returan']);
    }

    public function doSearchReturan(Request $request){
        // $returanData = Returan::where('id',$request->id)
        //     ->get();
        // $returanDataJoin = [];
        // foreach ($returanData as $data) {
        //     $dataDetail = [];
        //     foreach ($data->WasteList()->get() as $detail) {
        //         $dataDetail[] = $detail->Item()->get();
        //     }
        //     $returanDataJoin[] = [
        //         'returan' => $data,
        //         'detail' => $data->WasteList()->get(),
        //         'itemdetail' => $dataDetail,
        //     ];
        // }

        // $returanData = Returan::where('no_retur', 'like', '%' .$request->search. '%')->get();
        $returanData = Returan::whereDate('datetime_return','=', $request->search)
                ->orderBy('status','desc')
                ->get();

        return view('transaksireturan')
            ->with('returanData',$returanData);
    }

    public function doSearchWaste(Request $request)
    {
        // $response = [];
        // $returanData = Returan::where('no_retur', 'like', '%' .$request->search. '%')->orderBy('datetime_transaction','DESC')->get();
        // foreach($returanData as $r){
        //     $r['returan_detail'] = $r->ReturanDetail()->get();
        //     $tempSupplier = [];
        //     $tempPenjualan = [];
        //     $tempPenjualanDetail = [];
        //     foreach($r['returan_detail'] as $rd){
        //         $tempSupplier[] = Supplier::find($rd->supplier_id);
        //         $tempPenjualanDetail[] = PenjualanDetail::find($rd->id_detail_penjualan);
        //         $r['supplier'] = $tempSupplier;
        //         $r['penjualan_detail'] = $tempPenjualanDetail;
        //     }
        //     foreach($r['penjualan_detail'] as $p){
        //         $tempPenjualan[] = Penjualan::find($p->id_penjualan);
        //         $r['penjualan'] = $tempPenjualan;
        //     }

        //     $response[] = $r;
        // }

        // return view('wastelist')
        //     ->with('response',$response);

        // $returanData = Returan::where('no_retur', 'like', '%' .$request->search. '%')->get();

        $returanData = Returan::whereDate('datetime_return','=', $request->search)
                ->orderBy('status','desc')
                ->get();

        return view('wastelist')
            ->with('returanData',$returanData);
    }

    public function updateReturan(Request $request){
        $penjualanData = ReturanDetail::join('penjualans','penjualans.id','=','returan_detail.id_penjualan')
            ->join('customers','customers.customer_code','=','penjualans.customer_code')
            ->where('returan_detail.id_returan','=',$request->id)
            ->get();

        return view('updateReturan')
            ->with('penjualanData',$penjualanData);
    }

    public function tahaplanjutreturan(Request $request)
    {
        $data = $request->all();

        $penjualanData = Penjualan::whereIn('penjualans.id',explode(",",$data['selected_no']))
            ->get();
        $penjualanDataJoin = [];
        foreach ($penjualanData as $data) {
            $dataDetail = [];
            foreach ($data->PenjualanDetail()->get() as $detail) {
                $dataDetail[] = $detail->Item()->get();
            }
            $penjualanDataJoin[] = [
                'penjualan' => $data,
                'customer' => $data->Customer()->first(),
                'detail' => $data->penjualanDetail()->get(),
                'itemdetail' => $dataDetail,
            ];
        }

        // return json_encode($penjualanDataJoin);

        return view('tahaplanjutreturan')
            ->with('penjualanDataJoin',$penjualanDataJoin)
            ->with('datetime_returan',$request->datetime_returan);
    }

    public function doInsertReturan(Request $request){
        // return PenjualanDetail::where('id_penjualan',1)->sum('selling_qty');
        $data = $request->all();
        $getDateTimeNow = Carbon::now()->toDateTimeString();
        $random_code = "RT" . mt_rand(10000, 99999);

        for ($i=0; $i < $data['jumlahItem']; $i++) { //validasi cek stock yang di input
            if(isset($data['currSellingQty'.$i])){
                if($data['currSellingQty'.$i] < ($data['qtyRusak'.$i] + $data['qtyLayak'.$i])){
                    return redirect('transaksireturan')
                        ->withErrors(['Error!!','gagal insert, inputan kuantitas melebihi kuantitas penjualan']);
                }
            }
        }

        Returan::create([
            'no_retur' => $random_code,
            'datetime_transaction' => $getDateTimeNow,
            'datetime_return' => $data['datetime_returan'],
            'status' => '1'
        ]);

        $getReturanLatestId = Returan::orderBy('id','DESC')->first()->id;

        $a = 0;

        for ($i=0; $i < $data['jumlahPenjualan']; $i++) {
            $currPenjualanDtOriginal = PenjualanDetail::where('id_penjualan',$data['idPenjualan'.$i])->get();

            for ($j=0; $j < $data['jumlahItemPerPenjualan'.$i]; $j++) {
                $currPenjualanDt = $currPenjualanDtOriginal->where('item_id',(int)$data['itemId'.$a])->first();
                $currCustomerId = Penjualan::find($currPenjualanDtOriginal[0]->id_penjualan);
                // $currCustomerId->remark_returan = "yes";
                // $currCustomerId->save();

                ReturanDetail::create([
                    'id_returan' => $getReturanLatestId,
                    'id_detail_penjualan' => $currPenjualanDt->id,
                    'customer_id' => $currCustomerId->customer_id,
                    'item_id' => $currPenjualanDt->item_id,
                    'item_name' => $currPenjualanDt->item_name,
                    'supplier_id' => $currPenjualanDt->supplier_id,
                    'qty_retur' => ($data['qtyLayak'.$a]+$data['qtyRusak'.$a]),
                    'datetime_transaction' => $getDateTimeNow,
                    'status' => '1'
                ]);

                $getReturanDetailLatestId = ReturanDetail::orderBy('id','DESC')->first()->id;

                if($data['qtyLayak'.$a] != 0){
                    $currItem = Item::find($data['itemId'.$a]);
                    $currItem->item_qty += $data['qtyLayak'.$a];
                    $currItem->save();
                }

                ReturanDetailStatus::create([
                    'id_returan_detail' => $getReturanDetailLatestId,
                    'qty_waste' => $data['qtyRusak'.$a],
                    'qty_kembali' => $data['qtyLayak'.$a],
                    'datetime_transaction' => $getDateTimeNow,
                    'status' => '1'
                ]);


                WasteList::create([
                    'id_returan' => $getReturanDetailLatestId,
                    'item_id' => $currPenjualanDt->item_id,
                    'item_name' => $currPenjualanDt->item_name,
                    'supplier_id' => $currPenjualanDt->supplier_id,
                    'qty_waste' => $data['qtyRusak'.$a],
                    'datetime_transaction' => $getDateTimeNow,
                    'status' => '1'
                ]);

                Kembali::create([
                    'id_returan_detail' => $getReturanDetailLatestId,
                    'item_id' => $currPenjualanDt->item_id,
                    'item_name' => $currPenjualanDt->item_name,
                    'supplier_id' => $currPenjualanDt->supplier_id,
                    'qty_kembali' => $data['qtyLayak'.$a],
                    'datetime_transaction' => $getDateTimeNow,
                    'status' => '1'
                ]);

                $currPenjualanDt->selling_qty_temp -= ($data['qtyLayak'.$a]+$data['qtyRusak'.$a]);
                $currPenjualanDt->save();

                $a+=1;

            }

            if($currPenjualanDtOriginal->sum('selling_qty_temp') == 0){
                $penjualanRemarkReturan = Penjualan::find($currPenjualanDtOriginal[0]->id_penjualan);
                $penjualanRemarkReturan->remark_returan = "yes";
                $penjualanRemarkReturan->save();
            }

        }

        $logName = 'user id : '.auth()->user()->id.
            ' telah menambahkan returan baru dengan id : '
            .$getReturanLatestId;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('transaksireturan')->withErrors(['Sukses!!','berhasil menambahkan data returan baru']);

        // for ($i=0; $i < $data['jumlahItem']; $i++) {

        //     $currPenjualanDt = PenjualanDetail::where('item_id',$data['itemId'.$i])->first();
        //     $currCustomerId = Penjualan::find($currPenjualanDt->id_penjualan);

        //     ReturanDetail::create([
        //         'id_returan' => $getReturanLatestId,
        //         'id_detail_penjualan' => $currPenjualanDt->id,
        //         'customer_id' => $currCustomerId->customer_id,
        //         'item_id' => $currPenjualanDt->item_id,
        //         'item_name' => $currPenjualanDt->item_name,
        //         'supplier_id' => $currPenjualanDt->supplier_id,
        //         'qty_retur' => $currPenjualanDt->selling_qty,
        //         'datetime_transaction' => $getDateTimeNow,
        //         'status' => '1'
        //     ]);

        //     $getReturanDetailLatestId = ReturanDetail::orderBy('id','DESC')->first()->id;
            
        //     $currCustomerId->remark_returan = "yes";
        //     $currCustomerId->save();

        //     if($data['qtyLayak'.$i] != 0){
        //         $currItem = Item::find($data['itemId'.$i]);
        //         $currItem->item_qty += $data['qtyLayak'.$i];
        //         $currItem->save();
        //     }

        //     ReturanDetailStatus::create([
        //         'id_returan_detail' => $getReturanDetailLatestId,
        //         'qty_waste' => $data['qtyRusak'.$i],
        //         'qty_kembali' => $data['qtyLayak'.$i],
        //         'datetime_transaction' => $getDateTimeNow,
        //         'status' => '1'
        //     ]);


        //     WasteList::create([
        //         'id_returan' => $getReturanDetailLatestId,
        //         'item_id' => $currPenjualanDt->item_id,
        //         'item_name' => $currPenjualanDt->item_name,
        //         'supplier_id' => $currPenjualanDt->supplier_id,
        //         'qty_waste' => $data['qtyRusak'.$i],
        //         'datetime_transaction' => $getDateTimeNow,
        //         'status' => '1'
        //     ]);

        //     Kembali::create([
        //         'id_returan_detail' => $getReturanDetailLatestId,
        //         'item_id' => $currPenjualanDt->item_id,
        //         'item_name' => $currPenjualanDt->item_name,
        //         'supplier_id' => $currPenjualanDt->supplier_id,
        //         'qty_kembali' => $data['qtyLayak'.$i],
        //         'datetime_transaction' => $getDateTimeNow,
        //         'status' => '1'
        //     ]);
        // }

        // $logName = 'user id : '.auth()->user()->id.
        //     ' telah menambahkan returan baru dengan id : '
        //     .$getReturanLatestId;

        // Log::create([
    // 'userid' => auth()->user()->id,
        //     'name' => $logName
        // ]);

        // return redirect('transaksireturan')->withErrors(['Sukses!!','berhasil menambahkan data returan baru']);
    }

    public function wastelist()
    {
        // $response = [];
        // $returanData = Returan::orderBy('datetime_transaction','DESC')->get();
        // foreach($returanData as $r){
        //     $r['returan_detail'] = $r->ReturanDetail()->get();
        //     $tempSupplier = [];
        //     $tempPenjualan = [];
        //     $tempPenjualanDetail = [];
        //     foreach($r['returan_detail'] as $rd){
        //         $tempSupplier[] = Supplier::find($rd->supplier_id);
        //         $tempPenjualanDetail[] = PenjualanDetail::find($rd->id_detail_penjualan);
        //         $r['supplier'] = $tempSupplier;
        //         $r['penjualan_detail'] = $tempPenjualanDetail;
        //     }
        //     foreach($r['penjualan_detail'] as $p){
        //         $tempPenjualan[] = Penjualan::find($p->id_penjualan);
        //         $r['penjualan'] = $tempPenjualan;
        //     }

        //     $response[] = $r;
        // }

        // // return json_encode($response);   
        
        // return view('wastelist')
        //     ->with('response',$response);

        $returanData = Returan::orderBy('status','desc')->orderBy('datetime_transaction','DESC')->paginate(10);


        return view('wastelist')
            ->with('returanData',$returanData);
    }

    public function doChangeReturanStatus(Request $request){
        $status = "";

        $currData = Returan::find($request->id);

        if($currData->status == "1"){
            $status = "0";
        }else{
            $status = "1";
        }

        $currData->status = $status;
        $currData->save();

        $logName = 'user id : '.auth()->user()->id.
            ' telah mengubah status returan dengan id : '
            .$request->id.' menjadi '.$status;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('transaksireturan')->withErrors(['Sukses!!','berhasil mengganti status data returan']);
    }

    public function loadPenjualanAjax()
    {
        $response = [];
        $penjualanData = Penjualan::where('remark_returan','no')->get();
        foreach($penjualanData as $p){
            if($p->datetime_transaction >= Carbon::now()->subMonth()){
                $p['customer'] = Customer::find($p->customer_id);
                $response[] = $p;
            }
        }
        return json_encode($response);
    }

    public function loadPenjualanAjaxSearch($name)
    {
        $response = [];

        if($name == "kosong"){
            $penjualanData = Penjualan::where('remark_returan','no')->get();
        }else{
            // $penjualanData = DB::select('select * from penjualans where 
            //         remark_returan = ? and
            //         (no_nota like ? or customer_id like ?)',['no','%' .$name. '%','%' .$name. '%']);

            $penjualanData = Penjualan::where('remark_returan','no')
            ->where('no_nota','like','%' .$name. '%')
            // ->orWhere(,'like','%' .$name. '%')
            ->get();

        }

        foreach($penjualanData as $p){
            $p['customer'] = Customer::find($p->customer_id);
            $response[] = $p;
        }

        return json_encode($response);
    }

    public function returanDetailAjax($id)
    {
        $response = [];
        $returanDetailData= ReturanDetail::where('id_returan',$id)->get();
        foreach($returanDetailData as $rd){
            $rd['customer'] = Customer::find($rd->customer_id);
            $rd['returan_detail_status'] = ReturanDetailStatus::where('id_returan_detail',$rd->id)->first();
            $rd['penjualan_detail'] = PenjualanDetail::find($rd->id_detail_penjualan);
            $rd['item'] = Item::find($rd->item_id);

            $response[] = $rd;
        }
        return json_encode($returanDetailData);
    }

}
