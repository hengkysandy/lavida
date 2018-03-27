<?php

namespace App\Http\Controllers;

use App\Item;
use App\Log;
use App\Pembelian;
use App\Penjualan;
use App\Supplier;
use App\Notification;
use App\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// use Illuminate\Support\Facades\Route;



class BarangController extends Controller
{
    public function kategori()
    {
        $cateData = Category::paginate(10);

        // return $currentPath= Route::getFacadeRoot()->current()->uri();

        return view('kategori')
            ->with('cateData',$cateData);

    }

    public function doInsertCategory(Request $request)
    {
        Category::create([
            'name' => $request->name
        ]);

        $insertedCate = Category::all()->last();

        $logName = 'user id : '.auth()->user()->id.
            ' telah menambahkan kategori baru dengan id : '
            .$insertedCate->id;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('kategori')->withErrors(['Sukses!!','berhasil menambahkan kategori baru']);
    }

    public function doSearchCategory(Request $request)
    {
        $cateData = Category::where('id', 'like', '%' .$request->search. '%')
            ->orWhere('name', 'like', '%' .$request->search. '%')
            ->get();


        
        return view('kategori')
            ->with('cateData',$cateData);
    }

    public function updateCategory(Request $request)
    {
        $currData = Category::find($request->id);

        return view('updateKategori')
            ->with('currData',$currData);
    }

    public function doUpdateCategory(Request $request)
    {
        $currData = Category::find($request->id);
        
        // $currData->item_code = $data['itemCode'];
        // $currData->item_sku = $data['itemSku'];
        $currData->name = $request->name;
        $currData->save();

        $logName = 'user id : '.auth()->user()->id.
            ' telah memperbarui data kategori pada id : '
            .$request->id;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('kategori')->withErrors(['Sukses!!','berhasil mengupdate data kategori']);
    }


    public function barang()
    {

//        $barangData = Item::join('suppliers','suppliers.supplier_id','=','items.supplier_id')
//            ->get([
//                'items.item_code as item_code',
//                'items.item_brand as item_brand',
//                'items.item_name as item_name',
//                'items.item_sku as item_sku',
//                'items.item_category as item_category',
//                'items.item_qty as item_qty',
//                'items.item_min_qty as item_min_qty',
//                'items.status as status',
//                'suppliers.supplier_name as supplier_name',
//            ]);

        $cateData = Category::all();
            
        $barangData = Item::orderBy('status','desc')->paginate(10);

        return view('item')
            ->with('barangData',$barangData)
            ->with('cateData',$cateData);
    }

    public function doSearchBarang(Request $request){
        $supplierData = Supplier::all();

//        $barangData = Item::join('suppliers','suppliers.supplier_id','=','items.supplier_id')
//            ->where('item_code',$request->id)
//            ->get([
//                'items.item_code as item_code',
//                'items.item_brand as item_brand',
//                'items.item_name as item_name',
//                'items.item_sku as item_sku',
//                'items.item_category as item_category',
//                'items.item_qty as item_qty',
//                'items.item_min_qty as item_min_qty',
//                'items.status as status',
//                'suppliers.supplier_name as supplier_name',
//            ]);

        $barangData = Item::where('item_code', 'like', '%' .$request->search. '%')
            ->orWhere('item_name', 'like', '%' .$request->search. '%')
            ->get();

        $cateData = Category::all();
        
        return view('item')
            ->with('supplierData',$supplierData)
            ->with('barangData',$barangData)
            ->with('cateData',$cateData);
    }

    public function doInsertItem(Request $request)
    {
        $data = $request->all();

        $randomNumber = mt_rand(10000, 99999);
        // $sku_code = "SK" . $randomNumber;

        // $random_code = "BA" . mt_rand(10000, 99999);

        Item::create([
            'item_code' => $data['itemCode'],
            'item_brand' => $data['itemBrand'],
            'item_sku' => $data['itemSku'],
            'item_name' => $data['name'],
            'item_category' => $data['category'],
            // 'supplier_id' => $data['supplierId'],
            'supplier_id' => NULL,
            'item_qty' => $data['qty'],
            'item_min_qty' => $data['minQty'],
            'status' => '1'
        ]);

        $insertedItem = Item::all()->last();

        $logName = 'user id : '.auth()->user()->id.
            ' telah menambahkan barang baru dengan id : '
            .$insertedItem->id;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        if($insertedItem->item_qty < $insertedItem->item_min_qty){
            Notification::create([
                'item_id' => $insertedItem->id,
                'description' => 'barang dengan id : '.$insertedItem->id.' di bawah stock minimum',
                'read' => 'false'
            ]);
        }

        return redirect('barang')->withErrors(['Sukses!!','berhasil menambahkan barang baru']);
    }

    public function updateItem(Request $request)
    {
        $currData = Item::find($request->id);
        $supplierData = Supplier::all();
        $cateData = Category::all();

        return view('updateItem')
            ->with('currData',$currData)
            ->with('supplierData',$supplierData)
            ->with('cateData',$cateData);
    }



    public function doUpdatetItem(Request $request)
    {
        $data = $request->all();

        $currData = Item::find($data['id']);
        
        $currData->item_code = $data['itemCode'];
        $currData->item_sku = $data['itemSku'];
        $currData->item_brand = $data['itemBrand'];
        $currData->item_name = $data['name'];
        $currData->item_category = $data['category'];
        // $currData->supplier_id = $data['supplierId'];
        $currData->item_min_qty = $data['minQty'];
        $currData->save();

        $logName = 'user id : '.auth()->user()->id.
            ' telah memperbarui data barang pada id : '
            .$data['id'];

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        if($currData->item_qty < $currData->item_min_qty){
            $cekNotif = Notification::where('item_id',$currData->id)
                    ->where('read','false')
                    ->get();
            if(count($cekNotif) == 0){
                Notification::create([
                    'item_id' => $currData->id,
                    'description' => 'barang dengan id : '.$currData->id.' di bawah stock minimum',
                    'read' => 'false'
                ]);
            }
        }

        return redirect('barang')->withErrors(['Sukses!!','berhasil mengupdate data barang']);
    }

    public function doChangeStatus(Request $request)
    {
        $status = "";

        $currData = Item::find($request->id);

        if($currData->status == "1"){
            $status = "0";
        }else{
            $status = "1";
        }

        if($status == "0" && $currData->item_qty != 0){
            return redirect('barang')
                ->withErrors(['Error!!','tidak bisa mengnonaktifkan barang karena kuantitas barang masih ada']);
        }

        $currData->status = $status;
        $currData->save();

        $logName = 'user id : '.auth()->user()->id.
            ' telah mengganti status barang pada id : '
            .$request->id.' menjadi '.$status;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('barang')->withErrors(['Sukses!!','berhasil mengganti status data barang']);
        
    }

    public function doDeleteBarang(Request $request)
    {
        $currData = Item::find($request->id);
        if($currData->item_qty != 0){
            return redirect('barang')->withErrors(['Error!!','Stock Barang masih ada']);
        }else{
            $currData->status = "0";
            $currData->save();

            $logName = 'user id : '.auth()->user()->id.
            ' telah menghapus data barang pada id : '
            .$request->id;

            Log::create([
        'userid' => auth()->user()->id,
                'name' => $logName
            ]);

            return redirect('barang')->withErrors(['Sukses!!','berhasil menghapus data barang']);
        }

        
    }

    public function loadSupplierAjax(){
        $data = Supplier::where('status',1)->get();
        return $data;
    }

    public function loadSupplierAjaxSearch($name){
        $itemData = "";
        
        if($name == "kosong"){
            $itemData = Supplier::all();
        }else{
            $itemData = DB::select('select * from suppliers where (supplier_code like ? or supplier_name like ?) and status = ?',['%' .$name. '%','%' .$name. '%',1]);
        }
        
        return json_encode($itemData);
    }
}
