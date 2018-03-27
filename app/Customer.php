<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'customer_code','customer_name','pic_name','pic_contact',
        'pic_email','pic_phone','customer_location',
        'customer_description','status'
    ];

    public function Penjualan()
    {
        return $this->hasMany(Penjualan::class,'customer_code','customer_code');
    }
}
