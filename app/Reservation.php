<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reservation extends Model
{
    use Notifiable;

    protected $primaryKey = 'code_reservation';

    protected $fillable = [
        'code_reservation', 'user_id', 'room_id', 'time_booking', 'checkin_time', 'checkout_time', 'payment', 'time_spend'
    ];

    protected $attributes = [
        'status_payment' => 'unpaid'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
