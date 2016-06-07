<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KodUnit extends Model
{
    protected $table = 'spsm_kod_unit';
    protected $primaryKey = 'kod_id';

    public function ketua_unit()
    {
        return $this->belongsTo('App\User','emp_id_ketua','emp_id');
    }
}
