<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Religions extends Model
{
    use Notifiable;

    protected $table = 'religions';
    protected $guarded = [];

    public function users()
    {
        //return $this->belongsTo(User::class);
    }
}
