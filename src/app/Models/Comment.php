<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 'sender_id', 'item_id'
    ];

    public function sender(){
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function item(){
        return $this->belongsTo(Item::class, 'item_id');
    }
}
