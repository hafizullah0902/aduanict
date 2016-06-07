<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetsLocation extends Model
{
    protected $table = 'assets_locations';
    protected $primaryKey = 'location_id';

    public function branch()
    {
        return $this->belongsTo('App\Branch','branch_id','id');
    }
}
