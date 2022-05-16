<?php

namespace App\Models;

use App\Enum\CallStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['user', 'call'];
    // protected $appends = ['is_called'];

    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function call() {
        return $this->hasOne(Call::class);
    }

    // aranan müşteriler
    public function scopeOnlyCalled($query) {
        return $query->whereHas('call', function($query) {
            return $query->whereNotNull('status');
        });
    }

    public static function fetchAll()
    {
        return self::all();
    }

    public function getSourceAttribute($value)
    {
        return ucwords($value);
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function getSurnameAttribute($value)
    {
        return ucwords($value);
    }
    
    public function setSourceAttribute($value)
    {
        $this->attributes['source'] = strtolower($value);
    }

    // public function getCallStatusAttribute()
    // {
    //     if($this->call()->exists()) {
    //         return $this->call->status;
    //     } else {
    //         return ['tr' => 'Sırada', 'enum' => CallStatus::QUEUED->value, 'class' => 'p-2 bg-white border border-dashed rounded text-center font-bold', 'icon' => 'pi pi-clock text-xs pr-1'];
    //     }
    // }
}
