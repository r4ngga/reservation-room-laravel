<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Event extends Model
{
    use Notifiable;

    protected $table = 'events';
    protected $guarded = [];

    public function promotions()
    {
        return $this->belongsTo(Promotions::class);
    }
}
