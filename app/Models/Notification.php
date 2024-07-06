<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected  $fillable = ['user_id', 'message', 'status',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y, H:i');
    }
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y, H:i');
    }
}
