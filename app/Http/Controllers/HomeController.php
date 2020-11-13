<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\MeteoController;
use App\Models\ProjectePublic;
use App\Models\Meteo;
use Carbon\Carbon;
use App;
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
        $current = Http::get('https://api.weather.com/v2/pws/observations/current?stationId=ISANTL9&format=json&units=m&apiKey=979bf738d55144929bf738d551f49248&numericPrecision=decimal');
        $value = $current->json('observations');
        $projectes = ProjectePublic::where('publicat', '1')->get();
        //return $value[0]['metric']['temp'];
        Meteo::create([
            'temperatura' => $value[0]['metric']['temp'],
            'temperatura_sensacio' => $value[0]['metric']['windChill'],
            'humitat' => $value[0]['humidity'],
            'direccio_vent' => $value[0]['winddir'],
            'velocitat_vent' => $value[0]['metric']['windSpeed'],
            'rafega_vent' => $value[0]['metric']['windGust'],
            'pressio' => $value[0]['metric']['pressure'],
            'precipRate' => $value[0]['metric']['precipRate'],
            'precipTotal' => $value[0]['metric']['precipTotal'],
            'punt_rosada' => $value[0]['metric']['dewpt'],
            'radiacio_solar' => $value[0]['solarRadiation'],
            'uv' => $value[0]['uv'],
            'data' => $value[0]['obsTimeLocal'],
        ]);
        return view('public.welcome')
            ->with('projectes', $projectes)
            ->with('dirVent', $value[0]['winddir'])
            ->with('velVent', $value[0]['metric']['windSpeed'])
            ->with('rafegaVent', $value[0]['metric']['windGust'])
            ->with('temperatura', $value[0]['metric']['temp'])
            ->with('temperaturaSensacio', $value[0]['metric']['windChill'])
            ->with('humitat', $value[0]['humidity'])
            ->with('precipRate', $value[0]['metric']['precipRate'])
            ->with('precipTotal', $value[0]['metric']['precipTotal'])
            ->with('punt_rosada', $value[0]['metric']['dewpt'])
            ->with('radSolar', $value[0]['solarRadiation'])
            ->with('uv', $value[0]['uv'])
            ->with('pressio', $value[0]['metric']['pressure'])
            ->with('dataActual', $value[0]['obsTimeLocal'])
            ->with('dadesDiaries',  MeteoController::getDiariData());
    }
    /**
     * Obtenir dades diaries
     *
     * @return void
     */
    /*public function getDiariData()
    {
        $dadesDiaries = collect();
        $dadesDiaries['Tmitjana'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->avg('temperatura');
        $dadesDiaries['TMax'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->orderBy('temperatura','desc')->first()->temperatura;
        $dadesDiaries['TMin'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->orderBy('temperatura','asc')->first()->temperatura;
        $dadesDiaries['PTotal'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->orderBy('precipTotal','desc')->first()->precipTotal;
        $dadesDiaries['HMin'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->orderBy('humitat','desc')->first()->humitat;
        $dadesDiaries['HMax'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->orderBy('humitat','asc')->first()->humitat;
        $dadesDiaries['VVentMitjana'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->avg('velocitat_vent');
        $dadesDiaries['RafegaMaxima'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->orderBy('rafega_vent','desc')->first()->rafega_vent;
        $dadesDiaries['PMax'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->orderBy('pressio','desc')->first()->pressio;
        $dadesDiaries['PMin'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->orderBy('pressio','asc')->first()->pressio;
        return $dadesDiaries;
    }*/
}
