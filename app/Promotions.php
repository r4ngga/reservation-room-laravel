<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Promotions extends Model
{
    use Notifiable;

    protected $table = 'promotions';
    protected $guarded = [];

    public function rooms()
    {
        //return $this->belongsTo(User::class);
    }
}
