<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'mls_id',
        'name',
        'link'
    ];

    public $timestamps = false;

    public function player()
    {
        return $this->hasOne('App\Models\Player');
    }
}
