<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'category_id', 'brand', 'model', 'license_plate', 
        'year', 'price_per_day', 'status', 'image_path', 'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
