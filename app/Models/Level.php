<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class Level extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'level';

    protected $fillable = [
        'levelNumber',
        'description',
        'color'
    ];
}
