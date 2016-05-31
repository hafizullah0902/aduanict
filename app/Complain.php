<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $table = 'complains';
    protected $primaryKey = 'complain_id';
    
    
//    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function bagiPihak()
    {
        return $this->belongsTo('App\User','user_emp_id','emp_id');
    }

    public function complain_level()
    {
        return $this->belongsTo('App\ComplainLevel');
    }

    public function complain_source()
    {
        return $this->belongsTo('App\ComplainSource','complain_source_id','source_id');
    }

    public function complain_category()
    {
        return $this->belongsTo('App\ComplainCategory','complain_category_id','category_id');
    }

    public function action_user()
    {
        return $this->belongsTo('App\User');
    }

    public function verify_user()
    {
        return $this->belongsTo('App\User');
    }

    public function complain_status()
    {
        return $this->belongsTo('App\User');
    }

    public function attachments()
    {
        return $this->morphMany('App\ComplainAttachment', 'attachable');
    }

}
