<?php

namespace App\Models\sell_watches;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Review extends Model
{
    protected $fillable = [
        "product_id",
        "user_id",
        "comment",
        "rating",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactions()
    {
        return $this->morphMany(Reaction::class, "reactionable");
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
