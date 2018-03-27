<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $fillable = [
        'no_nota','supplier_id','datetime_transaction',
        'datetime_estimate','status'
    ];

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

    public function PembelianDetail()
    {
        return $this->hasMany(PembelianDetail::class,'id_pembelian','id');
    }

}
