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
        return $this->belongsTo('App\User','user_id','emp_id');
    }
    public function assets_location()
    {
        return $this->belongsTo('App\AssetsLocation','lokasi_id','location_id');
    }

    public function bagiPihak()
    {
        return $this->belongsTo('App\User','user_emp_id','emp_id');
    }
    public function lokasi()
    {
        return $this->belongsTo('App\Sph_kod_lokasi','lokasi_id','kod');
    }
    public function assets()
    {
        return $this->belongsTo('App\Assets','asset_id','asset_id');
    }
    
    public function sph_kod_unit()
    {
        return $this->belongsTo('App\Sph_kod_lokasi','unit_id','kod');
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
    
    public function complain_action()
    {
        return $this->hasMany('App\ComplainAction','complain_id','complain_id');
    }

}
