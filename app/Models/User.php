<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

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

    // protected $with = [
    //     'roles:id,name',
    // ];

    protected $appends = [
        'called_customers_count',
    ];

    public function customers() {
        return $this->hasMany(Customer::class);
    }

    // kullanıcı adminse sorgusuz geçiş ver
    public function permittedTo(String $permission)
    {
        return $this->hasPermissionTo($permission) || $this->isAdmin();
    }
    
    public function notPermittedTo(String $permission)
    {
        return ! $this->permittedTo($permission);
    }

    public function isAdmin()
    {
        return $this->hasRole(Role::$untouchables);
    }
    
    public function isNotAdmin()
    {
        return ! $this->isAdmin();
    }

    public static function adminCount()
    {
        return self::whereHas('roles', function($query) {
            return $query->where('name', 'admin');
        })->count();
    }

    public function isLastAdmin()
    {
        return $this->isAdmin() && self::adminCount() === 1;
    }

    // public function scopeTheOnesWhoMadeAnyCall($query)
    // {
    //     return $query->whereHas('customers', function($query) {
    //         return $query->onlyCalled();
    //     });
    // }
    
    public function getCalledCustomersCountAttribute() {
        return $this->customers()->whereHas('call', function($query) {
            return $query->where(['status' => 'UNANSWERED']);
        })->count();
        // return $this->customers()->onlyCalled()->count();
    }

    public function mainRole() 
    {
        return $this->roles()->exists() ? $this->getRoleNames()->first() : 'Rol atanmadı';
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
