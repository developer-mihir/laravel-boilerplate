<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'added_by');
    }

    public function attachments()
    {
        return $this->hasMany(CarHasAttachment::class, 'car_id', 'id');
    }
}
