<?php

namespace App\Models\sell_watches;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ReviewReport extends Model
{
    protected $fillable = [
        "review_id",
        "user_id",
        "comment",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
