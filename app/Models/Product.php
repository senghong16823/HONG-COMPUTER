<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'price', 'stock', 
        'cpu', 'ram', 'storage', 'image', 'description'
    ];

    // ទំនាក់ទំនង៖ កុំព្យូទ័រមួយ គឺស្ថិតនៅក្នុងប្រភេទ (Category) មួយ
    public function category() 
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
