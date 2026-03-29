<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Event extends Model
{
    use Notifiable;

    protected $table = 'events';
    protected $guarded = [];

    protected $fillable = [
        'name',
        'description',
        'enable',
        'status',
        'implement_with_promotion',
        'start_date',
        'created_at',
        'updated_at',
        'deleted_at',
        'end_date',
    ];

    public function promotions()
    {
        return $this->belongsTo(Promotions::class);
    }
}
