<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bug;

class ClientBugsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('clients.bugs');
    }
    /**
     * Obté tots els Bug
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getBugs(Request $request)
    {
        $bug = Bug::where('projecte_id', $request->id)->orderBy('created_at', 'desc')->get();
        return $bug;
    }
    /**
     * Crea un nou Bug
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function noubug(Request $request)
    {
        Bug::create([
            'name' => $request->name,
            'que' => $request->que,
            'perque' => $request->perque,
            'projecte_id' => $request->id,
        ]);
        $bug = Bug::where('projecte_id', $request->id)->orderBy('created_at', 'desc')->get();
        return $bug;
    }
    /**
     * Actualitza Bug
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function actualitzaBug(Request $request)
    {
        $bug = Bug::where('id', $request->id)->first();
        $bug->name = $request->name;
        $bug->que = $request->que;
        $bug->perque = $request->perque;
        $bug->save();
        return $this->getBugs($request);
    }
    /**
     * Actualitza l'estat de l'Bug
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function actualitzaEstatBug(Request $request)
    {
        $bug = Bug::where('id', $request->id)->first();
        $bug->estat = $request->estat;
        $bug->save();
        $bug = Bug::where('projecte_id', $request->projecte_id)->orderBy('created_at', 'desc')->get();
        return $bug;
    }
    /**
     * Eliminar Bug
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function eliminarBug(Request $request)
    {
        $bug = Bug::where('id', $request->id)->delete();
        $bug = Bug::where('projecte_id', $request->projecte_id)->orderBy('created_at', 'desc')->get();
        return $bug;
    }
}
