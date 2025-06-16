<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Resposta;

class Pregunta extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mdl_question';
    protected $fillable = [
 
       'category',
 
       'questiontext',
 
       'quantitat',

       'user_id',
 
    ];
    protected $primaryKey = 'id';
    public function respostes(){
        return $this->hasMany('App\Models\Resposta', 'question')->inRandomOrder();
    }
    public function respostaOk(){
        return $this->hasMany('App\Models\Resposta', 'question')->where('fraction', 1.0000000)->select('answer');
    }
    public function pregunta()
        {
            $preguntes = DB::table('mdl_question_answers')
                ->rightJoin('mdl_question', 'mdl_question_answers.question', '=', 'mdl_question.id')
                ->select('mdl_question.*', 'mdl_question_answers.*')
                ->get();
            //$preguntes = DB::table('mdl_question')->select('mdl_question.*')->get();
            return $preguntes;
        }
}
