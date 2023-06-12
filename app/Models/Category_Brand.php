<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_Brand extends Model
{
    use HasFactory;
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getTable()
    {
        return 'category_brands';
    }

    public function brand()
    {
        return $this->BelongsTo(Brand::class);
    }
}
