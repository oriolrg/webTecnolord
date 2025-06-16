<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    protected $connection = 'mysql2';   
        protected $table = 'mdl_question_answers';
        protected $fillable = [
    
        'question',
    
        'answer',
    
        'fraction',
    
    ];
    public function pregunta()
    {
        return $this->belongsTo('App\Pregunta', 'id');
    }
}
