<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method',
        'destination_post_num',
        'destination_address',
        'destination_building',
    ];

    public function users(){
        return $this->belongsTo(User::class, purchaser_id);
    }

    public function orders_detail(){
        return $this->hasMany(OrderDetail::class, order_id);
    }
}
