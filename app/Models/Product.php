<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['product_name','category_id','photo_path','description','price','status'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function rating(){
        return $this->hasMany(Rating::class);
    }

 
}
