<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Item;
use App\Log;
use App\Penjualan;
use App\PenjualanDetail;
use App\Notification;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PenjualanController extends Controller
{
    public function penjualan()
    {
        $penjualanData = Penjualan::orderBy('status','desc')->orderBy('datetime_transaction','DESC')->paginate(10);
        $totalItem = count(Item::all());
        // $penjualanDataJoin = [];
        // foreach ($penjualanData as $data) {
        //     $penjualanDataJoin[] = [
        //         'penjualan' => $data,
        //         'customer' => $data->Customer()->first(),
        //     ];
        // }

        // return json_encode($penjualanDataJoin);

        return view('penjualan')
            ->with('penjualanData',$penjualanData)
            ->with('totalItem',$totalItem);
    }

    public function loadItemAjax($id){
        if($id == 0){
            $itemData = Item::where('status',1)->get();
        }else{
            $itemData = Item::where('supplier_id',$id)->get();
        }
        return json_encode($itemData);
    }

    public function loadItemAjaxSearch($name,$id)
    {
        $itemData = "";
        if($id == 0){
            //bagian penjualan
            if($name == "kosong"){
                $itemData = Item::all();
            }else{
                $itemData = DB::select('select * from items where 
                    (item_code like ? or item_name like ?) and status = ?',['%' .$name. '%','%' .$name. '%',1]);
            }
        }else{
            //bagian pembelian
            if($name == "kosong"){
                $itemData = Item::where('supplier_id',$id)->get();
            }else{
                $itemData = DB::select('select * from items where supplier_id = ? and 
                         (item_code like ? or item_name like ?) and status = ?',[$id,'%' .$name. '%','%' .$name. '%',1]);
            }
        }
        
        
        return json_encode($itemData);
    }


    public function doSearchPenjualan(Request $request){
        $customerData = Customer::all();

        // $penjualanData = Penjualan::where('no_nota', 'like', '%' .$request->search. '%')
        //     ->orderBy('status','desc')
        //     ->get();

        $penjualanData = Penjualan::whereDate('datetime_estimate','=', $request->search)
            ->orderBy('status','desc')
            ->get();

        $totalItem = count(Item::all());

        return view('penjualan')
            ->with('customerData',$customerData)
            ->with('penjualanData',$penjualanData)
            ->with('totalItem',$totalItem);
    }

    public function doSearchPenjualanNota(Request $request)
    {
        $customerData = Customer::all();

        $penjualanData = Penjualan::where('no_nota', 'like', '%' .$request->search. '%')
            ->orderBy('status','desc')
            ->get();

        $totalItem = count(Item::all());

        return view('penjualan')
            ->with('customerData',$customerData)
            ->with('penjualanData',$penjualanData)
            ->with('totalItem',$totalItem);
    }

    public function doChangePenjualanStatus(Request $request)
    {
        $status = "";

        $currData = Penjualan::find($request->id);

        if($currData->status == "1"){
            $status = "0";
        }else{
            $status = "1";
        }

        $currData->status = $status;
        $currData->save();

        $logName = 'user id : '.auth()->user()->id.
            ' telah menggati status data penjualan pada id : '
            .$request->id.' menjadi '.$status;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('penjualan')->withErrors(['Sukses!!','berhasil mengganti status data penjualan']);
    }

    public function updatePenjualan(Request $request)
    {
        $currData = Penjualan::find($request->id);

        $penjualanDetailData = PenjualanDetail::where('id_penjualan',$request->id)->get();

        $totalItem = count(Item::all());

        return view('updatePenjualan')
            ->with('currData',$currData)
            ->with('penjualanDetailData',$penjualanDetailData)
            ->with('totalItem',$totalItem);
    }

    public function doUpdatePenjualan(Request $request)
    {
        $data = $request->all();
        $getDateTimeNow = Carbon::now()->toDateTimeString();
        $getItemLatestId = Item::orderBy('id','DESC')->first()->id;

        $currData = Penjualan::find($request->id);

        $currData->customer_id = $data['customerId'];
        $currData->datetime_estimate = str_replace('/','-',$data['estimate']).':00';
        $currData->save();
        
        $detailData = PenjualanDetail::where('id_penjualan',$request->id);

        foreach ($detailData->get() as $d) {
            //masukkan kembali semua kuantitas yang dibeli
            $currItem = Item::find($d->item_id);
            $currItem->item_qty += $d->selling_qty;
            $currItem->save();
        }

        $detailData->delete();

        for ($i=0; $i <= $getItemLatestId; $i++) { 
            if(isset($data['cekBarang'.$i])){
                $findSupplierId = Item::find($data['cekBarang'.$i])->supplier_id;
                PenjualanDetail::create([
                    'id_penjualan' => $data['id'],
                    'item_id' => $data['cekBarang'.$i],
                    'item_name' => $data['namaBarang'.$i],
                    'supplier_id' => $findSupplierId,
                    'selling_qty' => $data['qtyBeli'.$i],
                    'selling_qty_temp' => $data['qtyBeli'.$i],
                    'datetime_transaction' => $getDateTimeNow,
                    'status' => '1'
                ]);

                $currItemNew = Item::find($data['cekBarang'.$i]);
                $currItemNew->item_qty -= $data['qtyBeli'.$i];
                $currItemNew->save();

                if($currItemNew->item_qty < $currItemNew->item_min_qty){
                    $cekNotif = Notification::where('item_id',$currItemNew->id)
                            ->where('read','false')
                            ->get();
                    if(count($cekNotif) == 0){
                        Notification::create([
                            'item_id' => $currItemNew->id,
                            'description' => 'barang dengan id : '.$currItemNew->id.' di bawah stock minimum',
                            'read' => 'false'
                        ]);
                    }
                }
            }
        }

        $logName = 'user id : '.auth()->user()->id.
                    ' telah mengupdate data penjualan pada id : '
                    .$request->id;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('penjualan')->withErrors(['Sukses!!','berhasil mengupdate data penjualan']);
    }

    public function doInsertPenjualan(Request $request)
    {
        $data = $request->all();
        $getDateTimeNow = Carbon::now()->toDateTimeString();
        // $getDateTimeNow = $data['getDateTimeNow'];
        $random_code = "PJ" . mt_rand(10000, 99999);
        $getItemLatestId = Item::orderBy('id','DESC')->first()->id;


        for ($i=0; $i <= $getItemLatestId; $i++) { 
            if(isset($data['cekBarang'.$i])){
                //cek inputan kuantitas
                $currItem = Item::find($data['cekBarang'.$i]);
                if($data['qtyBeli'.$i] > $currItem->item_qty){
                    return redirect('penjualan')->withErrors(['Error!!','inputan kuantitas melebihi stock']);
                }
            }
        }


        // $location = "";
        // if($request->has(['cbx'])){ //jika check di centang
        //     $currCustLocation = Customer::find($data['customerId']);
        //     $location =  $currCustLocation->customer_location;
        // }else{
        //     $location = $data['location'];
        // }

        Penjualan::create([
            'no_nota' => $data['noNota'],
            'customer_id' => $data['customerId'],
            'datetime_transaction' => $getDateTimeNow,
            'datetime_estimate' => str_replace('/','-',$data['estimate']).':00',
            'status' => '1',
            'remark_returan' => 'no',
        ]);

        $getPenjualanLatestId = Penjualan::orderBy('id','DESC')->first()->id;
        
        for ($i=0; $i <= $getItemLatestId; $i++) { 
            if(isset($data['cekBarang'.$i])){

                $findSupplierId = Item::find($data['cekBarang'.$i])->supplier_id;

                PenjualanDetail::create([
                    'id_penjualan' => $getPenjualanLatestId,
                    'item_id' => $data['cekBarang'.$i],
                    'item_name' => $data['namaBarang'.$i],
                    'supplier_id' => $findSupplierId,
                    'selling_qty' => $data['qtyBeli'.$i],
                    'selling_qty_temp' => $data['qtyBeli'.$i],
                    'datetime_transaction' => $getDateTimeNow,
                    'status' => '1'
                ]);

                $currItem = Item::find($data['cekBarang'.$i]);
                $currItem->item_qty -= $data['qtyBeli'.$i];
                $currItem->save();

                $logName = 'user id : '.auth()->user()->id.
                    ' telah menjual barang dengan id : '
                    .$data['cekBarang'.$i].' sebanyak '.$data['qtyBeli'.$i];

                Log::create([
    'userid' => auth()->user()->id,
                    'name' => $logName
                ]);

                if($currItem->item_qty < $currItem->item_min_qty){
                    $cekNotif = Notification::where('item_id',$currItem->id)
                            ->where('read','false')
                            ->get();
                    if(count($cekNotif) == 0){
                        Notification::create([
                            'item_id' => $currItem->id,
                            'description' => 'barang dengan id : '.$currItem->id.' di bawah stock minimum',
                            'read' => 'false'
                        ]);
                    }
                }

            }
        }
        
        return redirect('penjualan')->withErrors(['Sukses!!','berhasil menambahkan data penjualan baru']);
    }

    public function penjualanDetailAjax($id){
        $data = PenjualanDetail::join('items','items.id','=','penjualan_detail.item_id')
        ->where('id_penjualan',$id)->get();
        return $data;
    }

    public function doDeletePenjualan(Request $request){
        $currData = Penjualan::find($request->id);
        $currData->status = "0";
        $currData->save();

        $logName = 'user id : '.auth()->user()->id.
            ' telah menghapus data penjualan pada id : '
            .$request->id;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('penjualan')->withErrors(['Sukses!!','berhasil menghapus data penjualan']);
    }

    public function loadCustomerAjax(){
        $data = Customer::where('status',1)->get();
        return json_encode($data);
    }

    public function loadCustomerAjaxSearch($name){
        $customerData = "";
        
        if($name == "kosong"){
            $customerData = Customer::all();
        }else{
            $customerData = DB::select('select * from customers where customer_code like ? or customer_name like ?',['%' .$name. '%','%' .$name. '%']);
        }
        
        return json_encode($customerData);
    }

    public function loadPenjualanDetailAjax($id)
    {
        $penjualanDetailData = PenjualanDetail::where('id_penjualan',$id)->get();
        return $penjualanDetailData;
    }

    public function penjualanRecap()
    {
       return view('penjualanRecap');
    }

    public function doRecapPenjualan(Request $request)
    {
        $penjualanData = Penjualan::whereDate('datetime_estimate','>=', $request->searchFrom)
                ->whereDate('datetime_estimate','<=', $request->searchTo)
                ->get();

        return view('penjualanRecap')
            ->with('penjualanData',$penjualanData);
    }

    public function penjualanArchive()
    {
        $penjualanData = Penjualan::whereDate('datetime_estimate','<=', Carbon::now()->subMonths(4))->get();
        return view('penjualanArchive')
            ->with('penjualanData',$penjualanData);
    }

    public function doSearchArchivePenjualan(Request $request)
    {
        $from = $request->searchFrom;
        $to = $request->searchTo;

        $penjualanData = Penjualan::whereDate('datetime_estimate','>=', $from)
                ->whereDate('datetime_estimate','<=', $to)
                ->whereDate('datetime_estimate','<=', Carbon::now()->subMonths(4))
                ->get();

        return view('penjualanArchive')
            ->with('penjualanData',$penjualanData)
            ->with('from',$from)
            ->with('to',$to);
    }
}
