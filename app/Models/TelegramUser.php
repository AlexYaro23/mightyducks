<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    protected $fillable = [
        'tg_id',
        'first_name',
        'last_name',
        'username'
    ];
}
