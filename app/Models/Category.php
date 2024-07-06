<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['category_name','small_size', 'medium_size', 'large_size', 'status'];

    public function products(){
        return $this->hasMany(Product::class, 'category_id');
    }
}
