<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Log;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function customer()
    {
        $customerData = Customer::orderBy('status','desc')->paginate(10);

        return view('customer')
            ->with('customerData',$customerData);
    }

    public function doSearchCustomer(Request $request){
        $customerData = Customer::where('customer_code', 'like', '%' .$request->search. '%')
            ->orWhere('customer_name', 'like', '%' .$request->search. '%')
            ->orderBy('status','desc')
            ->get();

        return view('customer')
            ->with('customerData',$customerData);
    }

    public function doInsertCustomer(Request $request)
    {
        $data = $request->all();

        // $random_code = "CU" . mt_rand(10000, 99999);
        $getCustomerLatestCode = Customer::orderBy('id','DESC')->first()->customer_code;
        $generateCode = 'CU'.(string)((int)substr($getCustomerLatestCode,2)+1);


        Customer::create([
            // 'customer_code' => $data['customerCode'],
            'customer_code' => $generateCode,
            'customer_name' => $data['customerName'],
            'pic_name' => $data['picName'],
            'pic_contact' => $data['contact'],
            // 'pic_email' => $data['email'],
            'pic_email' => '',
            'pic_phone' => '',
            'customer_location' => $data['location'],
            'customer_description' => $data['description'],
            'status' => '1'
        ]);

        $insertedCustomer = Customer::all()->last();

        $logName = 'user id : '.auth()->user()->id.
            ' telah menambahkan customer baru dengan id : '
            .$insertedCustomer->id;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('customer')->withErrors(['Sukses!!','berhasil menambahkan customer baru']);
    }

    public function updateCustomer(Request $request)
    {
        $currData = Customer::find($request->id);

        return view('updateCustomer')
            ->with('currData',$currData);
    }

    public function doUpdateCustomer(Request $request)
    {
        $data = $request->all();

        $currData = Customer::find($data['id']);

        // $currData->customer_code = $data['customerCode'];
        $currData->customer_name = $data['customerName'];
        $currData->pic_name = $data['picName'];
        $currData->pic_contact = $data['contact'];
        // $currData->pic_email = $data['email'];
        $currData->pic_phone = '';
        $currData->customer_location = $data['location'];
        $currData->customer_description = $data['description'];
        
        
        $currData->save();

        $logName = 'user id : '.auth()->user()->id.
            ' telah memperbarui data barang pada id : '
            .$data['id'];

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('/customer')->withErrors(['Sukses!!','berhasil mengupdate data customer']);
    }

    public function doChangeStatus(Request $request)
    {
        $status = "";

        $currData = Customer::find($request->id);

        if($currData->status == "1"){
            $status = "0";
        }else{
            $status = "1";
        }

        $currData->status = $status;
        $currData->save();

        $logName = 'user id : '.auth()->user()->id.
            ' telah mengganti status customer pada id : '
            .$request->id.' menjadi '.$status;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('customer')->withErrors(['Sukses!!','berhasil mengganti status data customer']);
    }

    public function customerAjax($id)
    {
        $data = Customer::find($id);
        return $data;
    }

    public function doDeleteCustomer(Request $request)
    {
        $currData = Customer::find($request->id);
        $currData->status = "0";
        $currData->save();

        $logName = 'user id : '.auth()->user()->id.
            ' telah menghapus data customer pada id : '
            .$request->id;

        Log::create([
    'userid' => auth()->user()->id,
            'name' => $logName
        ]);

        return redirect('customer')->withErrors(['Sukses!!','berhasil menghapus data customer']);
    }
}
