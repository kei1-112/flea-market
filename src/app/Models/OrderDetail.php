<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'item_id'];

    public function orders(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function item(){
        return $this->belongsTo(Order::class, 'item_id');
    }
}
