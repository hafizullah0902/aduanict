<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainAttachment extends Model
{
    public function complain()
    {
        return $this->hasMany('App\Complain');
    }
}
