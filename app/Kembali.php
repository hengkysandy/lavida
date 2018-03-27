<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kembali extends Model
{
    protected $table = 'kembalis';

    protected $fillable = [
        'id_returan_detail','item_id','item_name',
        'supplier_id','qty_kembali',
        'datetime_transaction','status'
    ];
}
