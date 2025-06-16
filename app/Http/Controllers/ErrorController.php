<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Error;
use App\Models\Pregunta;
use App\Models\Categoria;
use App\Models\Resposta;
use Auth;
use Barryvdh\DomPDF\Facade as PDF;

class ErrorController extends Controller
{
    public function index(){
        //return $this->getErrorsPregunta();
        return \view('errors')        
            ->with('preguntes', $this->getErrorsPregunta())
            ->with('categories', $this->getErrorsCategoria())
            ->with('tema', 'General');
    }
    public function insertError(Request $request)
    {
        //$error = Error::where('id_pregunta', $pregunta->id)->get();
        $id_User = 1;
        $preguntes = new Pregunta();
        $pregunta = $preguntes::find($request->input( 'question' ));
        $error = new Error();
        $errorTest = $error->where('id_pregunta', $pregunta->id)->first();
        if($errorTest){
            $error = $errorTest;
            $error->id_pregunta = $pregunta->id;
            $error->id_categoria = $pregunta->category;
            $error->n_errors += 1;
            $error->id_User = $id_User;
        }else{
            //$pregunta = $request->input( 'question' );
            $error->id_pregunta = $pregunta->id;
            $error->id_categoria = $pregunta->category;
            $error->n_errors = 2;
            $error->id_User = $id_User;
        }
            
        
        $error->save();
        return $pregunta->id;
    }
    public function insertOk(Request $request)
    {
        //$error = Error::where('id_pregunta', $pregunta->id)->get();
        $id_User = Auth::id();
        $preguntes = new Pregunta();
        $pregunta = $preguntes::find($request->input( 'question' ));
        $error = new Error();
        $errorTest = $error->where('id_User', $id_User)->where('id_pregunta', $pregunta->id)->first();
        if($errorTest){
            $error = $errorTest;
            $error->id_pregunta = $pregunta->id;
            $error->id_categoria = $pregunta->category;
            $error->n_errors -= 1;
            $error->id_User = $id_User;
        }
            
        
        $error->save();
        return $pregunta->id;
    }
    public function imprimirError(){
        $errors = $this->getErrorsPregunta();
        //return $errors;
        $pdf = PDF::setOptions([
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('imprimirpdf', array('data' =>$errors));
        return $pdf->download('preguntesfallades.pdf');
    }
    public function getErrorsPregunta()
    {
        
        //$error = Error::where('id_pregunta', $pregunta->id)->get();
        $id_User = Auth::id();
        $preguntes = new Pregunta();
        $categories = new Categoria();
        $errors = new Error();
        $question = new Collection;
        $respostes = new Resposta();
        foreach ($errors->where('id_User', $id_User)->get() as $error) {
            $pregunta = $preguntes->find($error->id_pregunta);
            $question->push([$pregunta->questiontext,$categories->find($error->id_categoria)->name, $preguntes->find($pregunta->id)->respostaOk[0]]);
            //echo $question;
        }
        return $question;
    }
    public function getErrorsCategoria()
    {
        //$error = Error::where('id_pregunta', $pregunta->id)->get();
        $id_User = Auth::id();
        $categories = new Categoria();
        $error = new Error();
        $question = new Collection;
        $errors = $error->where('id_User', $id_User)->select('id_pregunta','id_categoria', 'n_errors', 'id_User')->groupBy('id_categoria')->get();
        //return $errors;
        foreach ($errors as $error) {
            $pregunta = $categories->find($error->id_categoria);
            $question->push($pregunta);
            //echo $preguntes->respostes();
        }
        return $question;
    }
}
