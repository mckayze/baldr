<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    public static function current()
    {
        return Theme::where('active', true)->first()->path;
    }
}