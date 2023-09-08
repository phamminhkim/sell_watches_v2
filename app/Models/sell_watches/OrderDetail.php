<?php

namespace App\Models\sell_watches;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        "order_id",
        "product_id",
        "quantity",
        "price",
        "total_price",
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
