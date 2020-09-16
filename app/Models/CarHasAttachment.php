<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarHasAttachment extends Model
{
    protected $table = 'car_has_attachments';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
