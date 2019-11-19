<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    public static function loginPageImage()
    {
        return Settings::where('name', 'login_page_image')->first();
    }
}