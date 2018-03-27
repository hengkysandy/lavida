<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Returan extends Model
{
    protected $fillable = [
    'no_retur','datetime_transaction','datetime_return','status'
    ];

    public function ReturanDetail()
    {
        return $this->hasMany(ReturanDetail::class,'id_returan','id');
    }

    public function WasteList()
    {
        return $this->hasMany(WasteList::class,'id_returan','id');
    }
}
