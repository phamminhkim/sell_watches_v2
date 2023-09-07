<?php

namespace App\Models\sell_watches;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Category extends Model
{
    protected $fillable = [
        "name",
        "code",
        "note",
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
