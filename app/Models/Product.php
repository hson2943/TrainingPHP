<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $timestamp = false;

    protected $fillable = [
        'name', 'prices', 'description', 'category_id', 'brand_id', 'thumbnail'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->BelongsTo(Category::class);
    }

    public function brand()
    {
        return $this->BelongsTo(Brand::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }
}
