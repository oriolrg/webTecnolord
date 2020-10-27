<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historia;

class ClientHistoriesController extends Controller
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
        return view('clients.histories');
    }
    /**
     * Obté tots els Histories
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getHistories(Request $request)
    {
        $historia = Historia::where('projecte_id', $request->id)->orderBy('estat', 'asc')->orderBy('created_at', 'desc')->get();
        return $historia;
    }
    /**
     * Crea un nou Histories
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function nouHistoria(Request $request)
    {
        Historia::create([
            'name' => $request->name,
            'como' => $request->como,
            'quiero' => $request->quiero,
            'para' => $request->para,
            'projecte_id' => $request->id,
        ]);
        $historia = Historia::where('projecte_id', $request->id)->orderBy('estat', 'asc')->orderBy('created_at', 'desc')->get();
        return $historia;
    }
    /**
     * Actualitza Historia
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function actualitzaHistoria(Request $request)
    {
        $historia = Historia::where('id', $request->id)->first();
        $historia->name = $request->name;
        $historia->como = $request->como;
        $historia->quiero = $request->quiero;
        $historia->para = $request->para;
        $historia->save();
        return $this->getHistories($request);
    }
    /**
     * Actualitza l'estat de l'Historia
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function actualitzaEstatHistoria(Request $request)
    {
        $historia = Historia::where('id', $request->id)->first();
        $historia->estat = $request->estat;
        $historia->save();
        $historia = Historia::where('projecte_id', $request->projecte_id)->orderBy('estat', 'asc')->orderBy('created_at', 'desc')->get();
        return $historia;
    }
    /**
     * Eliminar Projecte
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function eliminarHistoria(Request $request)
    {
        $historia = Historia::where('id', $request->id)->delete();
        $historia = Historia::where('projecte_id', $request->projecte_id)->orderBy('estat', 'asc')->orderBy('created_at', 'desc')->get();
        return $historia;
    }
}
