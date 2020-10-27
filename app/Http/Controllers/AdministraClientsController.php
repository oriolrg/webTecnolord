<?php

namespace App\Http\Controllers;

use App\Models\User as AppUser;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class AdministraClientsController extends Controller
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
        $users = User::where('admin', 0)->orderBy('created_at', 'desc')->get();
        return view('administra.clients')->with('users', $users);
    }
    /**
     * Obtenir CLient.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getClient(Request $request)
    {
        $users = User::where('id', $request->id)->get();
        return $users;
    }
    /**
     * Obte tots els clients
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getClients()
    {
        $users = User::where('admin', 0)->orderBy('created_at', 'desc')->get();
        return $users;
    }
    /**
     * Crear client
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function nouClient(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telefon' => $request->telefon,
            'poblacio' => $request->poblacio,
            'password' => Hash::make($request->contrassenya),
        ]);
        return $this->getClients();
    }
    /**
     * Actualitza client
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function actualitzaClient(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telefon = $request->telefon;
        $user->poblacio = $request->poblacio;
        $user->save();
        return $this->getClients();
    }
    /**
     * Eliminar client
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function eliminarClient(Request $request)
    {
        $users = User::where('id', $request->id)->delete();
        return $this->getClients();
    }
}
