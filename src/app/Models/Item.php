<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'sold_flag',
        'item_img',
        'item_name',
        'brand_name',
        'price',
        'item_description',
        'item_condition'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'sender_id');
    }

    public function mylists(){
        return $this->hasMany(MyList::class, 'user_id');
    }

    public function item_categories()
    {
        return $this->hasMany(ItemCategories::class, 'item_id');
    }

    public function order_details()
    {
        return $this->hasOne(OrderDetail::class, 'item_id');
    }
}
