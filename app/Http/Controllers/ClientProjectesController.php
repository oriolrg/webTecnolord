<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projecte;
use Carbon\Carbon;
use Auth;

class ClientProjectesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = $request->user();
            // also can set other variables here as well
            // let the request continue through the stack
            return $next($request);
        });
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('clients.projectes');
    }
    /**
     * Obté tots els projectes
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getProjectes()
    {
        $projectes = Projecte::where('user_id', $this->user->id)->orderBy('finished_at', 'asc')->orderBy('created_at', 'desc')->get();
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
        $projectes = Projecte::where('user_id', $this->user->id)->orderBy('finished_at', 'desc')->get();
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
    /*
    public function nouProjecte(Request $request)
    {
        Projecte::create([
            'name' => $request->name,
            'descripcio' => $request->descripcio,
            'user_id' => $request->user_id,
        ]);
        return $this->getProjectes();
    }*/
    /**
     * Actualitza Projecte
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /*
    public function actualitzaProjecte(Request $request)
    {
        $projecte = Projecte::where('id', $request->id)->first();
        $projecte->name = $request->name;
        $projecte->descripcio = $request->descripcio;
        $projecte->save();
        return $this->getProjectes();
    }*/
    /**
     * Marca Projecte com a finalitzat
     *
     * 
     */
    /*
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
    }*/
    /**
     * Eliminar Projecte
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /*
    public function eliminarProjecte(Request $request)
    {
        $projecte = Projecte::where('id', $request->id)->delete();
        return $this->getProjectes();
    }*/
}
