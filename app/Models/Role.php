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
            ['tr' => 'Kullanıcıları görebilir', 'value' => 'view users'],
            ['tr' => 'Kullanıcı ekleyebilir, düzenleyebilir ve silebilir', 'value' => 'edit users'],
            
            ['tr' => 'Müşterileri görebilir', 'value' => 'view customers'],
            ['tr' => 'Müşteri ekleyebilir, düzenleyebilir ve silebilir', 'value' => 'edit customers'],
            
            ['tr' => 'Rolleri görebilir', 'value' => 'view roles'],
            ['tr' => 'Rol ekleyebilir, düzenleyebilir ve silebilir', 'value' => 'edit roles'],

            ['tr' => 'Anasayfayı görebilir', 'value' => 'view dashboard'],
            // ['tr' => 'Anasayfada işlem yapabilir', 'value' => 'edit dashboard'],
        ];
    }

    // ???? mutator çalışmıyo enteresan
    // public function setNameAttribute($value) {
    //     $this->attributes['name'] = strtolower($value);
    // }
    
    // public function getNameAttribute($value) {
    //     return ucwords($value);
    // }

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