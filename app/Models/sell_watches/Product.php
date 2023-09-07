<?php

namespace App\Models\sell_watches;

use Illuminate\Database\Eloquent\Model;
use App\User;


class Product extends Model
{
    protected $fillable = [
        "code",
        "name",
        "price",
        "image_path",
        "quantity",
        "brand_id",
        "category_id",
        "color_id",
        "note",
        "gender",
        "origin",
        "function",
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
