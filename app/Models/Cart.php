<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','prod_id','total_price','prod_qty','prod_image','prod_size', ];

    public function user(){
        return $this->belongsTo(User::class);
    }



}
