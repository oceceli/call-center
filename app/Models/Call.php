<?php

namespace App\Models;

use App\Enum\CallStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['human_readable_date'];

    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    public function customer() 
    {
        return $this->belongsTo(Customer::class);
    }

    public function getHumanReadableDateAttribute()
    {
        return Carbon::parse($this->updated_at)->diffForHumans();
    }

    public function scopeQueuedCalls($query)
    {
        return $query->whereNull('status');
    }

    public function scopeTotalCalls($query)
    {
        return $query->whereNotNull('status');
    }

    public function scopeUnsuccessfulCalls($query)
    {
        return $query
            ->where('status', CallStatus::UNANSWERED)
            ->orWhere('status', CallStatus::BUSY->value);
    }

    public function scopeSuccessfulCalls($query)
    {
        return $query->where('status', CallStatus::POSITIVE->value);
    }

    public function scopeBetweenDates($query, $from, $to)
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }

    // public function scopeSinceDaysAgo($query, $days)
    // {
    //     $to = Carbon::now();
    //     $from = $to->copy()->subDays($days);
    //     return $query->whereBetween('created_at', [$from, $to]);
    // }

    public function getStatusAttribute($value)
    {
        return [
            // CallStatus::QUEUED->value => ['tr' => 'Sırada', 'enum' => CallStatus::QUEUED->value, 'class' => 'p-2 bg-white border border-dashed text-xs rounded text-center font-bold', 'icon' => 'pi pi-clock text-xs pr-1'],
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
        ] : '';
        // ] : ['full' => '-', 'sliced' => '-'];
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
