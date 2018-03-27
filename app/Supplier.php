<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'supplier_code','supplier_name','pic_name','pic_contact',
        'pic_email','pic_phone','supplier_location',
        'supplier_description','status'
    ];

    public function Item()
    {
        return $this->hasMany(Item::class);
    }

    public function Pembelian()
    {
        return $this->hasMany(Pembelian::class,'supplier_code','supplier_code');
    }

}
