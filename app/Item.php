<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'item_code','item_brand','item_sku','item_name',
        'item_category','supplier_id','item_qty',
        'item_min_qty','status'
    ];

    public function Category()
    {
        return $this->belongsTo(Category::class,'item_category','id');
    }

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

    public function Pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }

    public function Penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    public function PembelianDetail()
    {
        return $this->hasMany(PembelianDetail::class,'item_code','item_code');
    }

    public function PenjualanDetail()
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function WasteList()
    {
        return $this->hasMany(WasteList::class);
    }


}
