<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'user_id',
        'item_id',
        'price',
    ];

    public function user()
    {
     return $this->belongsTo('App\Models\User');
    }

    public function Item()
    {
     return $this->belongsTo('App\Models\Item');
    }
}
