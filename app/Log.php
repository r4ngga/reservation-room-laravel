<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Log extends Model
{
    use Notifiable;

    protected $table = 'logs';

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'role',
        'data_old',
        'data_new',
        'log_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

}
