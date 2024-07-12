<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Room extends Model
{
    use Notifiable;

    // protected $primaryKey = '';

    protected $fillable = [
       'number_room', 'facility', 'class', 'capacity', 'status', 'price', 'image_room'
    ];

    protected $attributes = [
        'status' => 0
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
