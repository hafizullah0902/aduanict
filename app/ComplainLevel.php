<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainLevel extends Model
{
    public function complain()
    {
        return $this->hasMany('App\Complain');
    }
}
