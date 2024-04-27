<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','prod_list','total_amount','status','track_time','destination'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('D, d M Y H:i');
    }
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('D, d M Y H:i');
    }

    public function users(){
        return $this->belongsTo(User::class);
    }

}
