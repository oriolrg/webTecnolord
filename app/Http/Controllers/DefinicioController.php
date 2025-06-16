<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pregunta;
use App\Models\Resposta;
use App\Models\Categoria;
use App\Models\Error;
use App\Models\Definicio;
use Auth;


class DefinicioController extends Controller
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
        $definicions = new Definicio();
        return \view('diccionari')
            ->with('categories', $this->getCategoria())
            ->with('definicions', $definicions->orderBy('paraula', 'asc')->get());
    }
    public function indexCrearDefinicio(){
        return \view('crearDefinicio')
            ->with('categories', $this->getCategoria());
    }
    public function indexEditarDefinicio($id){
        $definicions = new Definicio();
        $definicio = $definicions->where('id', $id)->first();
        return view('crearDefinicio')
            ->with('categories', $this->getCategoria())
            ->with('editdefinicio', $definicio);
    }
    public function guardarDefinicio(Request $request){
        $definicio = new Definicio();
        $definicio->paraula = $request->textParaula;
        $definicio->definicio = $request->textDefinicio;
        $definicio->categoria = $request->textCategoria;

        $definicio->save();
        return \view('diccionari')
            ->with('categories', $this->getCategoria())
            ->with('definicions', $definicio->get());
        return $request;
    }
    public function editguardarDefinicio(Request $request){
        $definicions = new Definicio();
        $definicio = $definicions->where('id', $request->id)->first();
        $definicio->paraula = $request->textParaula;
        $definicio->definicio = $request->textDefinicio;
        $definicio->categoria = $request->textCategoria;

        $definicio->update();
        return \view('diccionari')
            ->with('categories', $this->getCategoria())
            ->with('definicions', $definicio->get());
    }
    public function getCategoria()
    {
        $categoria = new Categoria();
        return $categoria->where('contextid', '=', 1)->get();
        //return $preguntes->find(361)->respostes;
    }
    public function consultaDefinicio($text){
        $definicions = new Definicio();
        $definicio = $definicions->where("paraula","LIKE","%{$text}%")->get();
        return response()->json($definicio);
    }
}
