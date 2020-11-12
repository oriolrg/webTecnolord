<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Meteo;
use Illuminate\Support\Facades\Http;

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
        ->with('dataActual', $value[0]['obsTimeLocal']);
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
     * Obte les dades meteo diaries
     *
     * @return \Illuminate\Http\Response
     */
    public function getDayMeteo()
    {
        $current = Http::get('https://api.weather.com/v2/pws/observations/current?stationId=ISANTL9&format=json&units=m&apiKey=979bf738d55144929bf738d551f49248&numericPrecision=decimal');
        $data = $current->json('observations');
        $value = end($data);
        return $value;
    }
    /**
     * Obte les dades meteo mensuals
     *
     * @return \Illuminate\Http\Response
     */
    public function getMesMeteo()
    {
        $current = Http::get('https://api.weather.com/v2/pws/observations/current?stationId=ISANTL9&format=json&units=m&apiKey=979bf738d55144929bf738d551f49248&numericPrecision=decimal');
        $data = $current->json('observations');
        $value = end($data);
        
        return $value;
    }
    /**
     * Obte les dades meteo anuals
     *
     * @return \Illuminate\Http\Response
     */
    public function getAnyMeteo()
    {
        $current = Http::get('https://api.weather.com/v2/pws/observations/current?stationId=ISANTL9&format=json&units=m&apiKey=979bf738d55144929bf738d551f49248&numericPrecision=decimal');
        $data = $current->json('observations');
        $value = end($data);
        
        return $value;
    }
}
