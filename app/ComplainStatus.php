<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainStatus extends Model
{
    public function complain()
    {
        return $this->hasMany('App\Complain');
    }
}
