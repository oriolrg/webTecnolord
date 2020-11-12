<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectePublic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'descripcio',
        'client',
        'img_portada',
        'img_interna_1',
        'img_interna_2',
        'img_interna_3',
        'data_finalitzacio',
        'publicat',
    ];
}
