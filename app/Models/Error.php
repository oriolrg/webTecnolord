<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    protected $connection = 'mysql3';
    protected $table = 'errors';
    protected $fillable = [
 
       'id_pregunta',
 
       'id_categoria',
 
       'n_errors',

       'id_User',
 
    ];
}
