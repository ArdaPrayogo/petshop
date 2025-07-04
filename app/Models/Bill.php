<?php

namespace App\Models;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $guarded = ['id'];
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
