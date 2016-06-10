<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainAttachment extends Model
{
    protected $table = 'complain_attachments';
    protected $primaryKey = 'attachment_id';


    public function attachable()
    {
        return $this->morphTo();
    }
}
