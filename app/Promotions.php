<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Promotions extends Model
{
    use Notifiable;

    protected $table = 'promotions';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'description',
        'enable',
        'status',
        'price',
        'start_date',
        'end_date'
    ];

    public function rooms()
    {
        //return $this->belongsTo(User::class);
    }
}
