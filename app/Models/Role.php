<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole 
{
    protected $casts = [
        'created_at' => 'datetime:d.m.Y',
    ];

    protected $with = ['permissions'];


    // single source of truth of the available permissions
    public static function getAvailablePerms()
    {
        return [
            ['tr' => 'Kullanıcıları görebilir', 'value' => 'show users'],
            ['tr' => 'Kullanıcıları düzenleyebilir, silebilir', 'value' => 'edit users'],
        ];
    }
}