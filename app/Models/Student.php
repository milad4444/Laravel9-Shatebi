<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function enzebati()
    {
        return $this->hasMany('App\Enzebati');
    }
}
