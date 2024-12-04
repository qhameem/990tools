<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //use HasFactory;

    // Add this property
    protected $fillable = ['name', 'url', 'tag', 'description', 'category_id'];

    public function category()
    {

        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }
}