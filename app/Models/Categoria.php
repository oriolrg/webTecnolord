<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mdl_question_categories';
    protected $fillable = [
 
       'id',
 
       'name',
 
    ];
}
