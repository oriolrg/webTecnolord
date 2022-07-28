<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Meteo;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Goutte\Client;
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
        $data = $current->json('observations');
        if($data != null){
            $value = end($data);
        }else{
            $current = Http::get('https://api.weather.com/v2/pws/observations/current?stationId=ISANTLLO6&format=json&units=m&apiKey=979bf738d55144929bf738d551f49248&numericPrecision=decimal');
            $data = $current->json('observations');
            if($data != null){
                $value = end($data);
            }else{
                $value = null;
            }
        }

        return view('publicmeteo.welcomemeteo')->with('value', $value)
        ->with('temperatura', $value['metric']['temp'])
        ->with('dataActual', $value['obsTimeLocal'])
        ->with('temperaturaSensacio', $value['metric']['windChill'])
        ->with('precipRate', $value['metric']['precipRate'])
        ->with('precipTotal', $value['metric']['precipTotal'])
        ->with('humitat', $value['humidity'])
        ->with('punt_rosada', $value['metric']['dewpt'])
        ->with('radSolar', $value['solarRadiation'])
        ->with('uv', $value['uv'])
        ->with('velVent', $value['metric']['windSpeed'])
        ->with('rafegaVent', $value['metric']['windGust'])
        ->with('dirVent', $value['winddir'])
        ->with('pressio', $value['metric']['pressure']);
    }
    public function meteoInsta()
    {
        $current = Http::get('https://api.weather.com/v2/pws/observations/current?stationId=ISANTL9&format=json&units=m&apiKey=979bf738d55144929bf738d551f49248&numericPrecision=decimal');
        $data = $current->json('observations');
        if($data != null){
            $value = end($data);
        }else{
            $current = Http::get('https://api.weather.com/v2/pws/observations/current?stationId=ISANTLLO6&format=json&units=m&apiKey=979bf738d55144929bf738d551f49248&numericPrecision=decimal');
            $data = $current->json('observations');
            if($data != null){
                $value = end($data);
            }else{
                $current = Http::get('https://api.weather.com/v2/pws/observations/current?stationId=ISANTL13&format=json&units=m&apiKey=979bf738d55144929bf738d551f49248&numericPrecision=decimal');
                $data = $current->json('observations');
                if($data != null){
                    $value = end($data);
                }else{
                    $value = null;
                }
            }
        }
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
        return view('publicmeteo.welcomemeteoInsta')
        ->with('value', $value)
        ->with('temperatura', $value['metric']['temp'])
        ->with('dataActual', $value['obsTimeLocal'])
        ->with('temperaturaSensacio', $value['metric']['windChill'])
        ->with('precipRate', $value['metric']['precipRate'])
        ->with('precipTotal', $value['metric']['precipTotal'])
        ->with('humitat', $value['humidity'])
        ->with('punt_rosada', $value['metric']['dewpt'])
        ->with('radSolar', $value['solarRadiation'])
        ->with('uv', $value['uv'])
        ->with('velVent', $value['metric']['windSpeed'])
        ->with('rafegaVent', $value['metric']['windGust'])
        ->with('dirVent', $value['winddir'])
        ->with('pressio', $value['metric']['pressure']);
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
        if($data != null){
            $value = end($data);
        }else{
            $current = Http::get('https://api.weather.com/v2/pws/observations/current?stationId=ISANTLLO6&format=json&units=m&apiKey=979bf738d55144929bf738d551f49248&numericPrecision=decimal');
            $data = $current->json('observations');
            if($data != null){
                $value = end($data);
            }else{
                $value = null;
            }
        }
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
        //$page = file_get_contents('https://www.wunderground.com/dashboard/pws/ISANTLLO6/graph/2022-07-25/2022-07-25/monthly');
        //return $page;
        /*$client = new Client();
        $url = "https://www.wunderground.com/dashboard/pws/ISANTLLO6/graph/2022-07-25/2022-07-25/monthly";
        $crawler = $client->request('GET', $url);
        $periode = $crawler->filter('.date-text > strong:nth-child(1)')->text();

        $news = $crawler->filter('.charts-canvas > div')->html();
        echo($news."\n");*/
        /*
        
        if($crawler != null){
            try {
                $header_data->meteo_alt_imatge = $crawler->filter('div > .condition-icon > p')->each(function ($node) {
                    return $node->text();
                });
                
                //Obting temperatura i la passo a centigrads
                $header_data->temperatura = ceil(($crawler->filter('span > .wu-value  ')->each(function ($node) {
                    return $node->text();
                })[0] - 32) * (5 / 9));
            } catch (\Throwable $th) {
                $crawler=null;
            }
        }
        $dadesMensuals = Meteo::whereYear('data', '=', $any)
        ->whereMonth('data', '=', $mes)
        ->get();
        $dades['desglosMes'] = $dadesMensuals;

        return $dades;*/
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
        $dadesAnuals = collect();
        $dadesAnualsget = Meteo::whereYear('data', '=', $any)
        ->get();
        $day = 1;
        $TMin = null;
        $TMax = null;

        $HMin = null;
        $HMax = null;

        $VVMin = null;
        $VVMax = null;

        $precipitacio = 0;
        $precipitacioAcumulada = 0;
        foreach ($dadesAnualsget as $key => $value) {
            if(Carbon::parse($value->data)->day == $day){
                //echo "Temp ". $TMin;
                if($value->temperatura > $TMax){
                    $TMax = $value->temperatura;
                }
                if($value->temperatura < $TMin){
                    $TMin = $value->temperatura;
                }
                if($value->humitat > $HMax){
                    $HMax = $value->humitat;
                }
                if($value->humitat < $HMin){
                    $HMin = $value->humitat;
                }
                if($value->velocitat_vent > $VVMax){
                    $VVMax = $value->velocitat_vent;
                }
                if($value->velocitat_vent < $VVMin){
                    $VVMin = $value->velocitat_vent;
                }
                if($value->precipTotal > $precipitacio){
                    $precipitacio = $value->precipTotal;
                }
            }else{
                $precipitacioAcumulada = $precipitacioAcumulada + $precipitacio;
                $day = Carbon::parse($value->data)->day;
                $dadesDia = collect();
                $dadesDia['data'] = $value->data;
                $dadesDia['TMax'] = $TMax;
                $dadesDia['TMin'] = $TMin;
                $dadesDia['HMax'] = $HMax;
                $dadesDia['HMin'] = $HMin;
                $dadesDia['VVMax'] = $VVMax;
                $dadesDia['VVMin'] = $VVMin;
                $dadesDia['precipTotal'] = $precipitacio;
                $dadesDia['precipAcumulada'] = $precipitacioAcumulada;
                $dadesAnuals->push($dadesDia);

                $TMin = $TMax;
                $TMax = null;
                $VVMin = null;
                $VVMax = null;
                $HMin = null;
                $HMax = null;
                $precipitacio = 0;
            }
            //$dadesAnuals['Tminima'] = $TMin;
        }
        //return Carbon::parse($dadesAnuals->data)->day;
        $dades['desglosAny'] = $dadesAnuals;

        return $dades;
    }
}
