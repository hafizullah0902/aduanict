<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    public function assets_name()
    {
        return $this->belongsTo('App\User','ict_no','asset_id');
    }
}
