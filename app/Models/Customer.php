<?php

namespace App\Models;

use App\Enum\CallStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['user', 'call'];
    // protected $appends = ['is_called'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function call() {
        return $this->hasOne(Call::class);
    }


    // helpers ------------------------
    public static function fetchAll()
    {
        return self::all();
    }

    // public function getCallStatusAttribute()
    // {
        
    // }

    // getters ------------------------
    // public function getStatusAttribute($value)
    // {
    //     return [
    //         CallStatus::QUEUED->value => ['tr' => 'Sırada', 'enum' => CallStatus::QUEUED->value, 'class' => 'p-2 bg-white border border-dashed rounded text-center font-bold', 'icon' => 'pi pi-clock text-xs pr-1'],
    //         CallStatus::POSITIVE->value => ['tr' => 'Görüşme Sağlandı', 'enum' => CallStatus::POSITIVE->value, 'class' => 'p-2 bg-white text-green-500 border border-lime-500 border-dashed  rounded text-center font-bold', 'icon' => 'pi pi-check text-xs pr-1'],
    //         CallStatus::UNANSWERED->value => ['tr' => 'Ulaşılamadı', 'enum' => CallStatus::UNANSWERED->value, 'class' => 'p-2 bg-white text-yellow-500 border border-yellow-500 border-dashed  rounded text-center font-bold', 'icon' => 'pi pi-exclamation-circle text-xs pr-1'],
    //         CallStatus::BUSY->value => ['tr' => 'Meşgul', 'enum' => CallStatus::BUSY->value, 'class' => 'p-2 bg-white text-red-600 border border-red-600 border-dashed  rounded text-center font-bold', 'icon' => 'pi pi-times text-xs pr-1'],
    //     ][$value];
    // }

    // public function getIsCalledAttribute()
    // {
    //     return $this->status != CallStatus::QUEUED->value;
    // }

    // public function getNoteAttribute($value)
    // {
    //     return [
    //         'full' => $value,
    //         'sliced' => substr($value, 0, 20) . '...',
    //     ];
    // }

    // public function getSourceAttribute($value)
    // {
    //     return ucwords($value);
    // }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function getSurnameAttribute($value)
    {
        return ucwords($value);
    }

    // setters ------------------------
    // public function setStatusAttribute($value)
    // {
    //     $this->attributes['status'] = strtoupper($value);
    // }
    
    // public function setSourceAttribute($value)
    // {
    //     $this->attributes['source'] = strtolower($value);
    // }

}
