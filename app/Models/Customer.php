<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User() {
        return $this->belongsTo(User::class);
    }


    
    public static function fetchAll()
    {
        return self::all();
    }


    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtoupper($value);
    }
    
    public function setSourceAttribute($value)
    {
        $this->attributes['source'] = strtolower($value);
    }

}
