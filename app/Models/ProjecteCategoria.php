<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjecteCategoria extends Model
{
    use HasFactory;
    protected $fillable = [
        'projecte_id',
        'categoria_id',
    ];
    public $timestamps = false;
}
