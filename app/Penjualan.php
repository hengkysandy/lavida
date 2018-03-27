<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'no_nota','customer_id','datetime_transaction',
        'datetime_estimate','status','remark_returan'
    ];

    public function Customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function PenjualanDetail()
    {
        return $this->hasMany(PenjualanDetail::class,'id_penjualan','id');
    }

    public function ReturanDetail()
    {
        return $this->hasMany(ReturanDetail::class);
    }

}
