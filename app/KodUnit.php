<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KodUnit extends Model
{
    protected $connection='oracle2';
    protected $table = 'spsm_kod_unit';
    protected $primaryKey = 'kod';

    public function ketua_unit()
    {
        return $this->belongsTo('App\Complain','kod','unit_id');
    }
}
