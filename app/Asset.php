<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $connection='oracle2';
    protected $table = 'smict_master';
    protected $primaryKey = 'ict_no';
    public function assets_name()
    {
        return $this->belongsTo('App\User','ict_no','asset_id');
    }
}
