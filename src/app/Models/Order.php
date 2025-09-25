<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchaser_id',
        'payment_method',
        'destination_post_number',
        'destination_address',
        'destination_building'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'purchaser_id');
    }

    public function order_details(){
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
