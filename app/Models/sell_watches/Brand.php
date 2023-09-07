<?php

namespace App\Models\sell_watches;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Brand extends Model
{
    protected $fillable = [
        "name",
        "code",
        "note"
    ];
}
