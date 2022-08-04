<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meteo extends Model
{
    use HasFactory;
    
    protected $table = 'meteo';
    protected $primaryKey = 'id';
    protected $fillable = [
      'temperatura',
      'temperatura_sensacio',
      'humitat',
      'direccio_vent',
      'velocitat_vent',
      'rafega_vent',
      'pressio',
      'precipRate',
      'precipTotal',
      'punt_rosada',
      'radiacio_solar',
      'uv',
      'data',
      'cardener',
      'valls',
      'llosa',
      'capacitatllosa',
    ];
    public $timestamps = false;
}