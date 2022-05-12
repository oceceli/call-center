<?php

namespace App\Models;

use App\Enum\CallStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer() 
    {
        return $this->belongsTo(Customer::class);
    }

    public function getStatusAttribute($value)
    {
        return [
            CallStatus::QUEUED->value => ['tr' => 'Sırada', 'enum' => CallStatus::QUEUED->value, 'class' => 'p-2 bg-white border border-dashed text-xs rounded text-center font-bold', 'icon' => 'pi pi-clock text-xs pr-1'],
            CallStatus::POSITIVE->value => ['tr' => 'Görüşme Sağlandı', 'enum' => CallStatus::POSITIVE->value, 'class' => 'p-2 bg-white text-green-500 border border-lime-500 border-dashed text-xs rounded text-center font-bold', 'icon' => 'pi pi-check text-xs pr-1'],
            CallStatus::UNANSWERED->value => ['tr' => 'Ulaşılamadı', 'enum' => CallStatus::UNANSWERED->value, 'class' => 'p-2 bg-white text-yellow-500 border border-yellow-500 border-dashed text-xs rounded text-center font-bold', 'icon' => 'pi pi-exclamation-circle text-xs pr-1'],
            CallStatus::BUSY->value => ['tr' => 'Meşgul', 'enum' => CallStatus::BUSY->value, 'class' => 'p-2 bg-white text-red-600 border border-red-600 border-dashed text-xs rounded text-center font-bold', 'icon' => 'pi pi-times text-xs pr-1'],
        ][$value];
    }

    public function getNoteAttribute($value)
    {
        return $value ? [
            'full' => $value,
            'sliced' => substr($value, 0, 20) . '...',
        ] : '-';
    }

    public function getSourceAttribute($value)
    {
        return ucwords($value);
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
