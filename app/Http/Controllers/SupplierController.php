<?php

namespace App\Http\Controllers;

use App\Log;
use App\Supplier;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    public function supplier()
    {
        $supplierData = Supplier::orderBy('status','desc')->paginate(10);

        return view('supplier')
            ->with('supplierData',$supplierData);

    }

    public function doSearchSupplier(Request $request){
        $supplierData = Supplier::where('supplier_code', 'like', '%' .$request->search. '%')
            ->orWhere('supplier_name', 'like', '%' .$request->search. '%')
            ->orderBy('status','desc')
            ->get();

        return view('supplier')
            ->with('supplierData',$supplierData);
    }

    public function doInsertSupplier(Request $request)
    {
        $data = $request->all();

        // $random_code = "SU" . mt_rand(10000, 99999);

        Supplier::create([
            'supplier_code' => $data['supplierCode'],
            'supplier_name' => $data['supplierName'],
            'pic_name' => $data['picName'],
            'pic_contact' => $data['contact'],
            // 'pic_email' => $data['email'],
            'pic_email' => '',
            'pic_phone' => '',
            'supplier_location' => $data['location'],
            'supplier_description' => $data['description'],
            'status' => '1'
        ]);

        $insertedSupplier = Supplier::all()->last();

        $logName = 'user id : '.auth()->user()->id.
            ' telah menambahkan supplier baru dengan id  : '
            .$insertedSupplier->id;

        Log::create([
    'userid' => auth()->user()->id,
            'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('supplier')->withErrors(['Sukses!!','berhasil menambahkan supplier baru']);
    }

    public function updateSupplier(Request $request)
    {
        $currData = Supplier::find($request->id);

        return view('updateSupplier')
            ->with('currData',$currData);
    }

    public function doUpdateSupplier(Request $request)
    {
        $data = $request->all();

        $currData = Supplier::find($data['id']);

        $currData->supplier_code = $data['supplierCode'];
        $currData->supplier_name = $data['supplierName'];
        $currData->pic_name = $data['picName'];
        $currData->pic_contact = $data['contact'];
        // $currData->pic_email = $data['email'];
        $currData->pic_phone = '';
        $currData->supplier_location = $data['location'];
        $currData->supplier_description = $data['description'];
        $currData->save();

        $logName = 'user id : '.auth()->user()->id.
            ' telah memperbarui data supplier pada id : '
            .$data['id'];

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('/supplier')->withErrors(['Sukses!!','berhasil mengupdate data supplier']);
    }

    public function supplierAjax($id)
    {
        $data = Supplier::find($id);
        return $data;
    }

    public function doChangeStatus(Request $request)
    {
        $status = "";

        $currData = Supplier::find($request->id);

        if($currData->status == "1"){
            $status = "0";
        }else{
            $status = "1";
        }

        $currData->status = $status;
        $currData->save();

        $logName = 'user id : '.auth()->user()->id.
            ' telah mengganti status supplier pada id : '
            .$request->id.' menjadi '.$status;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('supplier')->withErrors(['Sukses!!','berhasil mengganti status data supplier']);
    }

    public function doDeleteSupplier(Request $request)
    {
        $currData = Supplier::find($request->id);
        $currData->status = "0";
        $currData->save();

        $logName = 'user id : '.auth()->user()->id.
            ' telah menghapus data supplier pada id : '
            .$request->id;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('supplier')->withErrors(['Sukses!!','berhasil menghapus data supplier']);
    }
}
