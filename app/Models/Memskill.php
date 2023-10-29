<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Memskill extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'memskill';

    protected $fillable = [
        'memCode',
        'skillId',
        'levelNumber',
        'timeSkillUp',
        'updated_at',
        'created_at'
    ];
}
