<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainAction extends Model
{
    protected $table = 'complain_actions';
    protected $primaryKey = 'id';


    public function complain_status()
    {
        return $this->belongsTo('App\Complain');
    }

}
