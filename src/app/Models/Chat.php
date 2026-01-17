<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'message',
        'img',
        'sender_flag',
        'unread_flag'
    ];

    public function orders(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
