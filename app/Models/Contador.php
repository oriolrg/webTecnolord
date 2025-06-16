<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contador extends Model
{
    use HasFactory;
    protected $table = 'contador_visites';
    protected $fillable = ['ip', 'n_visites'];
}
