<?php

namespace App\Models\sell_watches;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Image extends Model
{
    protected $fillable = [
        "imageable_id",
        "imageable_type",
        "path",
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}
