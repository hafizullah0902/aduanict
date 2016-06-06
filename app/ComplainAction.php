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

    public function user()
    {
//        return $this->belongTo('App\(Nama Model),(foreign Key),(Primary key) )
        return $this->belongsTo('App\User','action_by','emp_id');
    }
}
