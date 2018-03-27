<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WasteList extends Model
{
    protected $table = 'waste_list';

    protected $fillable = [
        'id_returan','item_id','item_name',
        'supplier_id','qty_waste',
        'datetime_transaction','status'
    ];

    public function Returan()
    {
        return $this->belongsTo(Returan::class,'id','id_returan');
    }

    public function Item()
    {
        return $this->belongsTo(Item::class,'item_code','item_code');
    }
}
