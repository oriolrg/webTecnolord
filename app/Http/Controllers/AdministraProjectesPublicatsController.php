<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectePublic;
use Carbon\Carbon;
use Auth;

class AdministraProjectesPublicatsController extends Controller
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
        return view('administra.projectesPublicats');
    }
    /**
     * Obté tots els projectes
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getProjectes()
    {
        $projectes = ProjectePublic::get();
        foreach ($projectes as $key => $value) {
            $value->user_id  = $value->usuari->name;
        }

        return $projectes;
    }
    /**
     * Preparar nou projecte per publicar a web publica
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function nouProjectePublicar(Request $request)
    {
        $projectes = ProjectePublic::where('id', $request->id)->first();
        $projectes->publicat = 1;
        $projectes->save();
        return $this->getProjectesDone();
    }
    /**
     * Obté tots els projectes finalitzats
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getProjectesDone()
    {
        $projectes = ProjectePublic::orderBy('created_at', 'desc')->get();

        return $projectes;
    }
    /**
     * Crea un nou Projecte
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function amagarProjecte(Request $request)
    {
        $projectes = ProjectePublic::where('id', $request->id)->first();
        $projectes->publicat = 0;
        $projectes->save();
        return $this->getProjectesDone();
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
        return $this->getProjectes();
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
        return $this->getProjectes();
    }
}
