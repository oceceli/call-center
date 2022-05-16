<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole 
{
    protected $casts = [
        'created_at' => 'datetime:d.m.Y',
        'updated_at' => 'datetime:d.m.Y | H:i',
    ];

    protected $with = ['permissions'];

    // adminler silinmemeli ve tüm yetkilere sahip olmalılar
    public static $untouchables = [
        'admin', 'super admin',
    ];

    public static function allExceptUntouchables()
    {
        // admin - super admin
        return self::all()->except(['1', '2']);
    }

    // single source of truth of the available permissions
    public static function getAvailablePerms()
    {
        return [
            ['tr' => 'Kullanıcıları görebilir', 'value' => 'show users'],
            ['tr' => 'Kullanıcıları düzenleyebilir, silebilir', 'value' => 'edit users'],
        ];
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = strtolower($value);
    }
    
    public function getNameAttribute($value) {
        return ucwords($value);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            if(in_array(strtolower($obj->name), self::$untouchables))
                return false;
        });
        // static::updating(function($obj) {
        //     if(in_array(strtolower($obj->name), self::$untouchables))
        //         return false;
        // });
    }
}