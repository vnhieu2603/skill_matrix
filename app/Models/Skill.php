<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Skill extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'skill';

    protected $fillable = [
        'Id',
        'Name',
        'Position'
    ];

    protected $guarded = [];
}
