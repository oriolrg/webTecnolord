<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\MeteoController;
use App\Models\ProjectePublic;
use App\Models\Meteo;
use Carbon\Carbon;
use App;
use App\Models\Contador;
use URL;
use Lang;
use Ramsey\Collection\Collection;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $meteo = new MeteoController();
        //$meteo->saveDatabaseMeteo();
        return view('welcome');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexMeteo()
    {
        $meteo = new MeteoController(); 
        $ip = request()->ip();
        $contador = Contador::updateOrCreate(
            ['ip' =>  $ip],
        );
        $contador->n_visites = $contador->n_visites+1;
        $contador->save();
        //$meteo->saveDatabaseMeteo();
        return view('meteo');
    }
    

}
