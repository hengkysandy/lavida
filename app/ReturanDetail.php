<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturanDetail extends Model
{
	protected $table = 'returan_detail';

    protected $fillable = [
        'id_returan','id_detail_penjualan','customer_id','item_id',
        'item_name','supplier_id','qty_retur','datetime_transaction','status'
    ];

    public function Returan()
    {
        return $this->belongsTo(Returan::class,'id','id_returan');
    }

    public function Penjualan()
    {
        return $this->belongsTo(Penjualan::class,'id_penjualan','id');
    }

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }
}
