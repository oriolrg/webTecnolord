<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preguntes extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'preguntes_fallades';
     // Camps assignables en massa
     protected $fillable = [
        'pregunta',
        'resposta_correcta',
        'tema',
        'num_fallos'
    ];
}