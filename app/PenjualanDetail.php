<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $table = 'penjualan_detail';

    protected $fillable = [
        'id_penjualan','item_id','item_name','supplier_id',
        'selling_qty','selling_qty_temp','datetime_transaction','status'
    ];

    public function Item()
    {
        return $this->belongsTo(Item::class,'item_id','id');
    }

    public function Penjualan()
    {
        return $this->belongsTo(Penjualan::class,'id','id_penjualan');
    }

    public function ReturanDetail()
    {
        return $this->hasMany(ReturanDetail::class,'id_detail_penjualan','id');
    }

    
}
