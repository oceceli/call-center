<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'img_url',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function customers() {
        return $this->hasMany(Customer::class);
    }


    public static function removeOldPic(Self $user)
    {
        Storage::disk('public')->delete(str_replace('/storage/', '', $user->img_url));
    }


    public function getImgUrlAttribute($value) {
        if($value)
            return '/storage/' . $value;
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = ucwords($value);
    }


    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            self::removeOldPic($obj);
        });
        // static::updating(function($obj) {
        //     if(request()->file()) {
        //         Storage::disk('public')->delete(str_replace('/storage/', '', $obj->img_url));
        //     }
        // });
    }


}
