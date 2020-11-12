<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projecte;
use App\Models\Categoria;
use App\Models\ProjecteCategoria;
use App\Models\ProjectePublic;
use Carbon\Carbon;
use Auth;

class AdministraProjectesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('administra.projectes');
    }
    /**
     * Obté tots els projectes
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getProjectes()
    {
        $projectes = Projecte::orderBy('finished_at', 'asc')->orderBy('created_at', 'desc')->get();
        foreach ($projectes as $key => $value) {
            $value->user_id  = $value->usuari->name;
        }

        return $projectes;
    }
    /**
     * Obté tots els projectes
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getProjectesDoing()
    {
        $projectes = Projecte::where('finished_at','=', null)->orderBy('created_at', 'desc')->get();
        foreach ($projectes as $key => $value) {
            $value->user_id  = $value->usuari->name;
        }

        return $projectes;
    }
    /**
     * Crea un nou Projecte
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function nouProjecte(Request $request)
    {
        $projecte = Projecte::create([
            'name' => $request->name,
            'descripcio' => $request->descripcio,
            'user_id' => $request->user_id,
        ]);
        foreach ($request->tags as $key => $value) {
            //creo o actualitzo noves categories
            $this->novaCategoria($value, $projecte->id);
        }
        return $this->getProjectes();
    }
    /**
     * Actualitza Projecte
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function actualitzaProjecte(Request $request)
    {
        $projecte = Projecte::where('id', $request->id)->first();
        $projecte->name = $request->name;
        $projecte->descripcio = $request->descripcio;
        $projecte->save();

        foreach ($request->tags as $key => $value) {
            //creo o actualitzo noves categories
            $this->novaCategoria($value, $projecte->id);
        }
        return $this->getProjectes();
    }
    /**
     * crea i actualitza categories
     *
     * @param $value nom categoria, $projecte_id
     * @return void
     */
    public function novaCategoria($value, $projecte_id)
    {
        //TODO controlar que no es dupliquin les categories
        $categoriaId = Categoria::where('name',$value)->first();
        //Si encara no existeix la categoria
        if (!$categoriaId) {
            $categoria = Categoria::create([
                'name' => $value,
            ]);
            ProjecteCategoria::create([
                'categoria_id' => $categoria->id,
                'projecte_id' => $projecte_id,
            ]);
        //Si ja existeix la categoria
        }else{
            if(!ProjecteCategoria::where('categoria_id', $categoriaId->id)->where('projecte_id', $projecte_id)->first()){
                ProjecteCategoria::create([
                    'categoria_id' => $categoriaId->id,
                    'projecte_id' => $projecte_id,
                ]);
            }
        }
    }
    /**
     * Marca Projecte com a finalitzat
     *
     * 
     */
    public function finalitzaProjecte(Request $request)
    {
        $projecte = Projecte::where('id', $request->params)->first();
        if($projecte->finished_at==null){
            $projecte->finished_at = Carbon::now();
            $projecte->save();
            $projecte = ProjectePublic::create([
                'name' => $projecte->name,
                'descripcio' => $projecte->descripcio,
                'client' => $projecte->user_id,
                'img_portada' => null,
                'img_interna_1' => null,
                'img_interna_2' => null,
                'img_interna_3' => null,
                'data_finalitzacio' => null,
                'publicat' => 0,
            ]);
        }else{
            $projecte->finished_at = null;
            $projecte->save();
        }
        return $this->getProjectes();
    }
    /**
     * Eliminar Projecte
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function eliminarProjecte(Request $request)
    {
        $projecte = Projecte::where('id', $request->id)->delete();
        ProjecteCategoria::where('projecte_id', $request->id)->delete();
        return $this->getProjectes();
    }
}
