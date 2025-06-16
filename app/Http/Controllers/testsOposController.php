<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Pregunta;
use App\Models\Resposta;
use App\Models\Categoria;
use App\Models\Error;
use Auth;


class testsOposController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return \view('questionari')        
            ->with('preguntes', $this->getQuestion())
            ->with('categories', $this->getCategoria())
            ->with('tema', 'General');
    }
    public function indexCategoria($categoria, $name){
        return \view('questionari')
            ->with('preguntes', $this->getPreguntesCategoria($categoria))
            ->with('categories', $this->getCategoria())
            ->with('tema', $name);
        
    }
    public function indexFallades(){
    //return  $this->getCategoria();
        //return $this->getCategoria();
        return \view('questionari')        
            ->with('preguntes', $this->getQuestionFallades())
            ->with('categories', $this->getCategoria())
            ->with('tema', 'Preguntes fallades');
    }
    public function indexCrearPregunta(){
        return view('crearPregunta')
            ->with('categories', $this->getCategoria());
    }
    public function guardarPregunta(Request $request){
        $preguntes = new Pregunta();
        $preguntes->category = $request->textCategoria;
        $preguntes->questiontext = $request->textPregunta;
        $preguntes->timestamps = false;
        $preguntes->save();
        $i = 0;
        foreach ($request->resposta as $key => $resposta) {
            $respostes = new Resposta();
            $respostes->answer = $resposta;
            $respostes->fraction = $request->puntuacio[$i];
            $respostes->question = $preguntes->id;
            $respostes->timestamps = false;
            $i += 1;
            $respostes->save();
        }
        return \view('questionari')        
            ->with('preguntes', $this->getQuestion())
            ->with('categories', $this->getCategoria())
            ->with('tema', 'General');
    }
    public function getQuestion()
    {
        $preguntes = new Pregunta();
        $respostes = new Resposta();
        //$preguntes = $preguntes->get();
        //return $preguntes->respostes()->select('question', 'answer', 'fraction')->get();
        //return $respostes->find(1)->respostes;
        $question = new Collection;
        foreach ($preguntes->inRandomOrder()->take(80)->get() as $pregunta) {
            $pregunta['respostes'] = $preguntes->find($pregunta->id)->respostes;
            $question->push($pregunta);
            //echo $preguntes->respostes();
        }
        return $question;
        //return $preguntes->find(361)->respostes;
    }
    public function getQuestionFallades()
    {
        $fallades = new Error();
        //return $fallades->get();
        $preguntes = new Pregunta();
        $respostes = new Resposta();
        //$preguntes = $preguntes->get();
        //return $preguntes->respostes()->select('question', 'answer', 'fraction')->get();
        //return $respostes->find(1)->respostes;
        $question = new Collection;
        $id_User = Auth::id();
        foreach ($fallades->where('n_errors', '>=', 1)->inRandomOrder()->take(50)->get() as $pregunta) {
            $pregunta = $preguntes->find($pregunta->id_pregunta);
            $pregunta['respostes'] = $preguntes->find($pregunta->id)->respostes;
            $question->push($pregunta);
            //echo $preguntes->respostes();
        }
        return $question;
        //return $preguntes->find(361)->respostes;
    }
    public function getCategoria()
    {
        $categoria = new Categoria();
        return $categoria->where('contextid', '=', 1)->get();
        //return $preguntes->find(361)->respostes;
    }
    public function getPreguntesCategoria($categoria)
    {
        $preguntes = new Pregunta();
        $question = new Collection;
        foreach ($preguntes->where('category', $categoria)->inRandomOrder()->take(50)->get() as $pregunta) {
            $pregunta['respostes'] = $preguntes->find($pregunta->id)->respostes;
            $question->push($pregunta);
            //echo $preguntes->respostes();
        }
        return $question;
        return $preguntes->where('category', $categoria)->inRandomOrder()->get();
        //return $preguntes->find(361)->respostes;
    }
    public function editPregunta($id){
        $preguntes = new Pregunta();
        $pregunta = $preguntes->where('id', $id)->first();
        $pregunta['respostes'] = $preguntes->find($id)->respostes;
        return view('edit')->with('data', $pregunta);
    }
    public function guardareditaPregunta(Request $request){
        $preguntes = Pregunta::find($request->id);
        $preguntes->timestamps = false;
        $preguntes->generalfeedback = '';
        $preguntes->questiontext = $request->textPregunta;
        $preguntes->update();
        $respostes = Resposta::where('question', $request->id)->get();
        foreach ($respostes as $key => $resposta) {
            $resposta->timestamps = false;
            $resposta->answer = $request->resposta[$resposta->id];
            $resposta->fraction = $request->puntuacio[$resposta->id];
            $resposta->update();
        }
        return back();
    }
    public function eliminarPregunta($id){
        Pregunta::find($id)->delete();
        return \view('questionari')        
            ->with('preguntes', $this->getQuestion())
            ->with('categories', $this->getCategoria())
            ->with('tema', 'General');
    }
}
