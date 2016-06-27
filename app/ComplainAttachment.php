<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainAttachment extends Model
{
    protected $table = 'complain_attachments';
    protected $primaryKey = 'attachment_id';

    protected $fillable = [
        'attachment_filename',
    ];


    public function attachable()
    {
        return $this->morphTo();
    }
}
