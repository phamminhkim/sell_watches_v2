<?php

namespace App\Models\sell_watches;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Reaction extends Model
{
    protected $fillable = [
        "reactionable_id",
        "reactionable_type",
        "user_id",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactionable()
    {
        return $this->morphTo();
    }
}
