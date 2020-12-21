<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Meteo;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Storage;

class MeteoController extends Controller
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
     * Obté les dades meteo al moment
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current = Http::get('https://api.weather.com/v2/pws/observations/current?stationId=ISANTL9&format=json&units=m&apiKey=979bf738d55144929bf738d551f49248&numericPrecision=decimal');
        $value = $current->json('observations');

        return view('publicmeteo.welcomemeteo')
        ->with('dataActual', $value[0]['obsTimeLocal']);/*
        ->with('temperatura', $value['metric']['temp'])
        ->with('humitat', $value['humidity'])
        ->with('pressio', $value['metric']['pressure']);*/
    }
    /**
     * Guarda les dades meteo
     *
     * @return \Illuminate\Http\Response
     */
    public function saveMeteo()
    {
        $current = Http::get('https://api.weather.com/v2/pws/observations/current?stationId=ISANTL9&format=json&units=m&apiKey=979bf738d55144929bf738d551f49248&numericPrecision=decimal');
        $data = $current->json('observations');
        $value = end($data);
        Meteo::create([
            'temperatura' => $value['metric']['temp'],
            'temperatura_sensacio' => $value['metric']['windChill'],
            'humitat' => $value['humidity'],
            'direccio_vent' => $value['winddir'],
            'velocitat_vent' => $value['metric']['windSpeed'],
            'rafega_vent' => $value['metric']['windGust'],
            'pressio' => $value['metric']['pressure'],
            'precipRate' => $value['metric']['precipRate'],
            'precipTotal' => $value['metric']['precipTotal'],
            'punt_rosada' => $value['metric']['dewpt'],
            'radiacio_solar' => $value['solarRadiation'],
            'uv' => $value['uv'],
            'data' => $value['obsTimeLocal'],
        ]);
    }
    /**
     * Obte les dades meteo d'un dia concret
     *
     * @return \Illuminate\Http\Response
     */
    public function getMeteoDia($dia)
    {
        $current = Http::get('https://api.weather.com/v2/pws/observations/current?stationId=ISANTL9&format=json&units=m&apiKey=979bf738d55144929bf738d551f49248&numericPrecision=decimal');
        $value = $current->json('observations');
        $dadesMensuals = collect();
        $dadesMensuals = Meteo::whereDate('data', '=', $dia)
        ->get();
        $dades['dadesActuals'] = $value[0];
        $dades['desglosDia'] = $dadesMensuals;
        $dades['TMax'] = $dadesMensuals->max('temperatura');
        $dades['TMin'] = $dadesMensuals->min('temperatura');
        return $dades;
    }
    /**
     * Obte les dades meteo d'un mes concret
     *
     * @return \Illuminate\Http\Response
     */
    public function getMesMeteo($mes, $any)
    {
        $dadesMensuals = Meteo::whereYear('data', '=', $any)
        ->whereMonth('data', '=', $mes)
        ->get();
        $dades['desglosMes'] = $dadesMensuals;

        return $dades;
    }
    /**
     * Obte les dades meteo d'un any concret
     *
     * @return \Illuminate\Http\Response
     */
    public function getAnyMeteo($any)
    {
        $dadesMensuals = collect();
        $dadesMensuals = Meteo::whereYear('data', '=', $any)
        ->get();
        $dades['desglosAny'] = $dadesMensuals;

        return $dades;
    }
}
