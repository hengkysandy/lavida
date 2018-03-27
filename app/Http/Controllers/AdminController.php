<?php

namespace App\Http\Controllers;

use App\Item;
use App\Log;
use App\Pembelian;
use App\PembelianDetail;
use App\Penjualan;
use App\PenjualanDetail;
use App\Notification;
use App\ReturanDetail;
use App\ReturanDetailStatus;
use App\Supplier;
use App\Customer;
use App\Returan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function master()
    {
//        alter table add column laravel
//        Schema::table('penjualans', function (Blueprint $table) {
//            $table->string('remark_returan')->nullable();
//        });

        return view('master');
    }

    

    public function detailBarang(Request $request)
    {
        $barangData = Item::join('suppliers','suppliers.id','=','items.supplier_id')
            ->where('items.id','=',$request->id)
            ->get([
                'items.item_code as item_code',
                'items.item_brand as item_brand',
                'items.item_name as item_name',
                'items.item_sku as item_sku',
                'items.item_category as item_category',
                'items.item_qty as item_qty',
                'items.item_min_qty as item_min_qty',
                'items.status as status',
                'suppliers.supplier_name as supplier_name',
            ]);

        $responsePenjualan = [];
        $penjualanData = PenjualanDetail::join('items','items.id','=','penjualan_detail.item_id')
            ->where('penjualan_detail.item_id',$request->id)
            ->get([
                'penjualan_detail.id_penjualan as id_penjualan',
                'penjualan_detail.id as id_detail_penjualan',
                'items.item_name as item_name',
                'penjualan_detail.selling_qty as selling_qty',
                'items.created_at as created_at',
                'items.item_code as item_code',
            ]);
        
        foreach($penjualanData as $r){
            $r['returanDetail'] = ReturanDetail::where('id_detail_penjualan',$r->id_detail_penjualan)->first();
            if($r['returanDetail'] != null){
                $r['ReturanDetailStatus'] = ReturanDetailStatus::where('id_returan_detail',$r['returanDetail']->id)->first();
            }

            $responsePenjualan[] = $r;
        }
        $responsePenjualan;


        $penjualanDataSum = PenjualanDetail::join('items','items.id','=','penjualan_detail.item_id')
            ->where('penjualan_detail.item_id',$request->id)
            ->get()->sum('selling_qty');


        $pembelianData = PembelianDetail::join('items','items.id','=','pembelian_detail.item_id')
            ->where('pembelian_detail.item_id',$request->id)
            ->get([  
                'pembelian_detail.created_at as created_at',
                'pembelian_detail.id_pembelian as id_pembelian',
                'items.item_name as item_name',
                'items.item_code as item_code',
                'pembelian_detail.purchase_qty as purchase_qty',
            ]);

        $pembelianDataSum = PembelianDetail::join('items','items.id','=','pembelian_detail.item_id')
            ->where('pembelian_detail.item_id',$request->id)
            ->get()->sum('purchase_qty');

        return view('detailBarang')
            ->with('barangData',$barangData)
            ->with('pembelianData',$pembelianData)
            ->with('responsePenjualan',$responsePenjualan)
            ->with('pembelianDataSum',$pembelianDataSum)
            ->with('penjualanDataSum',$penjualanDataSum);

    }

    public function log()
    {
        $logData = Log::orderBy('created_at','DESC')->get();

        return view('log')
            ->with('logData',$logData);
    }

    public function doSearchLog(Request $request){
        $logData = DB::select('select * from logs WHERE substring(name,11,1) = ? order by created_at DESC',[$request->search]);

        return view('log')
            ->with('logData',$logData);
    }

    public function stockcard()
    {
        $barangData = Item::orderBy('status','desc')->paginate(10);

        return view('stockcard')
            ->with('barangData',$barangData);
    }

    public function dashboard()
    {
        $barangData = Item::whereRaw('items.item_qty < items.item_min_qty')->get();
        // $barangData = DB::select('select i.item_code, i.item_brand, i.item_sku, i.item_name, c.name, s.supplier_name, i.item_qty, i.item_min_qty from items i, categories c, suppliers s where i.item_category = c.id and i.supplier_id = s.id and item_min_qty > item_qty and i.status != 0');

        return view('dashboard')
            ->with('barangData',$barangData);
    }

    public function loadCode($menu,$code)
    {
        $currTable = '\App\\'.$menu;
        $attName = "";

        $attName = $menu.'_code';
        if($menu == "Pembelian" || $menu == "Penjualan") $attName = 'no_nota';
        else if($menu == "Category") $attName = 'name';

        $response = $currTable::where($attName,$code)->get();
        return response()->json(count($response));
    }

    public function loadCategoryNameUpdate($id,$name)
    {
        $currTable = '\App\\Category';
        $attName = "name";

        $response = $currTable::where('id','!=',$id)
                            ->where($attName,$name)
                            ->get();
        return response()->json(count($response));
    }

    public function loadSku($sku)
    {
        $response = Item::where('item_sku',$sku)->get();
        return response()->json(count($response));
    }

    public function doReadNotif(Request $request)
    {
        $currNotif = Notification::find($request->id);
        $currNotif->read = "true";
        $currNotif->save();

        return redirect('dashboard');
    }

}
