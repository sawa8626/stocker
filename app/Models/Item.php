<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function details()
    {
        return $this->hasMany('App\Models\ItemDetail');
    }
}
