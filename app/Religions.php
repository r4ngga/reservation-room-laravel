<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Religions extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'religions';
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class, 'religion_id', 'id');
    }
}
