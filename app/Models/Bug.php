<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'que',
        'perque',
        'estat',
        'projecte_id',
        'historia_id',
    ];
}
