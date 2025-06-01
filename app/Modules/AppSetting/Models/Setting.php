<?php

namespace App\Modules\AppSetting\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'name',
        'logo_picture',
        'banner_picture',
    ];

    public static function getSettings()
    {
        return self::first(); // or self::find(1) if you're using a fixed ID
    }


}
