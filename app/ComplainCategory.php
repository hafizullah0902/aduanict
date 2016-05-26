<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainCategory extends Model
{
    public function complain()
    {
        return $this->hasMany('App\Complain');
    }
}
