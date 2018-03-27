<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
	protected $table = 'pembelian_detail';

    protected $fillable = [
        'id_pembelian','item_id','item_name',
        'supplier_id','purchase_qty',
        'datetime_transaction','status'
    ];

    public function Item()
    {
        return $this->belongsTo(Item::class,'item_id','id');
    }

    public function Pembelian()
    {
        return $this->belongsTo(Pembelian::class,'id','id_pembelian');
    }

}
