<?php

namespace App\Models\sell_watches;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ShoppingCard extends Model
{
    protected $fillable = [
        "user_id",
        "product_id",
        "quantity",
        "total_price"
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
