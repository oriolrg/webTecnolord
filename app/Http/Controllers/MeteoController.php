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
        $url = 'http://109.167.55.247:8001/record/current.jpg';
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $url);
        $contents = curl_exec($c);
        curl_close($c);
        $name = substr($url, strrpos($url, '/') + 1);
        Storage::put($name, $contents);
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
        ->with('dataActual', $value[0]['obsTimeLocal'])
        ->with('dadesDiaries',  $this->getDiariData());
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
    /**
     * Obtenir dades diaries
     *
     * @return void
     */
    public static function getDiariData()
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
    }
}
