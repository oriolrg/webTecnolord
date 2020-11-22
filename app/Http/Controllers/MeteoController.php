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
        $dadesDiaries['HMax'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->orderBy('humitat','desc')->first()->humitat;
        $dadesDiaries['HMin'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->orderBy('humitat','asc')->first()->humitat;
        $dadesDiaries['VVentMitjana'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->avg('velocitat_vent');
        $dadesDiaries['RafegaMaxima'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->orderBy('rafega_vent','desc')->first()->rafega_vent;
        $dadesDiaries['PMax'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->orderBy('pressio','desc')->first()->pressio;
        $dadesDiaries['PMin'] = Meteo::whereDate('data', Carbon::now()->format('Y-m-d'))->orderBy('pressio','asc')->first()->pressio;
        return $dadesDiaries;
    }
    /**
     * Obte les dades d'un dia en concret
     *
     * @return \Illuminate\Http\Response
     */
    public function getMeteoDiaMesAny($dia, $mes, $any)
    {
        $dadesDiaMesAny = collect();
        $dadesDiaMesAny = Meteo::whereYear('data', '=', $any)
        ->whereMonth('data', '=', $mes)
        ->whereDay('data', '=', $dia);
        $dades['resumDia'] = $dadesDiaMesAny;
        $dades['Tmitjana'] = $dadesDiaMesAny->avg('temperatura');
        $dades['TMax'] = $dadesDiaMesAny->max('temperatura');
        $dades['TMin'] = $dadesDiaMesAny->min('temperatura');
        $dades['PTotal'] = $dadesDiaMesAny->max('precipTotal');
        $dades['HMax'] = $dadesDiaMesAny->max('humitat');
        $dades['HMin'] = $dadesDiaMesAny->min('humitat');
        $dades['VVentMitjana'] = $dadesDiaMesAny->avg('velocitat_vent');
        $dades['RafegaMaxima'] = $dadesDiaMesAny->max('rafega_vent');
        $dades['PMax'] = $dadesDiaMesAny->max('pressio');
        $dades['PMin'] = $dadesDiaMesAny->min('pressio');

        return $dades;
        return $dadesDiaMesAny
        ->get();
        $current = Http::get('https://api.weather.com/v2/pws/history/all?stationId=ISANTL9&format=json&units=m&apiKey=979bf738d55144929bf738d551f49248&numericPrecision=decimal&year=20200512');
        $data = $current->json('observations');
        $value = end($data);
        return $value;
    }
    /**
     * Obte les dades meteo mensuals
     *
     * @return \Illuminate\Http\Response
     */
    public function getMeteoDia($dia)
    {
        $dadesMensuals = collect();
        $dadesMensuals = Meteo::whereDate('data', '=', $dia)
        ->get();
        $dades['desglosDia'] = $dadesMensuals;
        $dades['Tmitjana'] = $dadesMensuals->avg('temperatura');
        $dades['TMax'] = $dadesMensuals->max('temperatura');
        $dades['TMin'] = $dadesMensuals->min('temperatura');
        $dades['PTotal'] = $dadesMensuals->max('precipTotal');
        $dades['HMax'] = $dadesMensuals->max('humitat');
        $dades['HMin'] = $dadesMensuals->min('humitat');
        $dades['VVentMitjana'] = $dadesMensuals->avg('velocitat_vent');
        $dades['RafegaMaxima'] = $dadesMensuals->max('rafega_vent');
        $dades['PMax'] = $dadesMensuals->max('pressio');
        $dades['PMin'] = $dadesMensuals->min('pressio');

        return $dades;
    }
    /**
     * Obte les dades meteo mensuals
     *
     * @return \Illuminate\Http\Response
     */
    public function getMesMeteo($mes, $any)
    {
        $dadesMensuals = collect();
        $dadesMensuals = Meteo::whereYear('data', '=', $any)
        ->whereMonth('data', '=', $mes)
        ->get();
        $dades['desglosMes'] = $dadesMensuals;
        $dades['Tmitjana'] = $dadesMensuals->avg('temperatura');
        $dades['TMax'] = $dadesMensuals->max('temperatura');
        $dades['TMin'] = $dadesMensuals->min('temperatura');
        $dades['PTotal'] = $dadesMensuals->max('precipTotal');
        $dades['HMax'] = $dadesMensuals->max('humitat');
        $dades['HMin'] = $dadesMensuals->min('humitat');
        $dades['VVentMitjana'] = $dadesMensuals->avg('velocitat_vent');
        $dades['RafegaMaxima'] = $dadesMensuals->max('rafega_vent');
        $dades['PMax'] = $dadesMensuals->max('pressio');
        $dades['PMin'] = $dadesMensuals->min('pressio');

        return $dades;
    }
    /**
     * Obte les dades meteo anuals
     *
     * @return \Illuminate\Http\Response
     */
    public function getAnyMeteo($any)
    {
        $dadesAnuals = collect();
        $dadesAnuals = Meteo::whereYear('data', '=', $any)
        ->get();
        $dades['desglosAny'] = $dadesAnuals;
        $dades['Tmitjana'] = $dadesAnuals->avg('temperatura');
        $dades['TMax'] = $dadesAnuals->max('temperatura');
        $dades['TMin'] = $dadesAnuals->min('temperatura');
        $dades['PTotal'] = $dadesAnuals->max('precipTotal');
        $dades['HMax'] = $dadesAnuals->max('humitat');
        $dades['HMin'] = $dadesAnuals->min('humitat');
        $dades['VVentMitjana'] = $dadesAnuals->avg('velocitat_vent');
        $dades['RafegaMaxima'] = $dadesAnuals->max('rafega_vent');
        $dades['PMax'] = $dadesAnuals->max('pressio');
        $dades['PMin'] = $dadesAnuals->min('pressio');

        return $dades;
    }
}
