<?php

namespace App\Models\sell_watches;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Color extends Model
{
    protected $fillable = [
        "hex_code",
        "name",
        "note"
    ];
}
