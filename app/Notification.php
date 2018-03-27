<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'item_id','description','read'
    ];

    public function Item()
    {
        return $this->belongsTo(Item::class,'item_id','id');
    }
}
