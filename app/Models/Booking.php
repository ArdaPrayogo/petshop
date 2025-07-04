<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = ['id'];
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
