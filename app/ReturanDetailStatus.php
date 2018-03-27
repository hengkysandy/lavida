<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturanDetailStatus extends Model
{
    protected $table = 'returan_detail_status';

    protected $fillable = [
        'id_returan_detail','qty_waste','qty_kembali',
        'datetime_transaction','status'
    ];
}
