<?php

namespace App\Models\sell_watches;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Order extends Model
{
    protected $fillable = [
        "user_id",
        "product_id",
        "quantity",
        "total_price",
        "order_date",
        "shipping_address",
        "payment_method",
        "status",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
