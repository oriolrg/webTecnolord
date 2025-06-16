<?php

namespace App\Http\Controllers;
use App\Models\Humitat;
use App\Models\Meteo;
use App\Models\Pluja;
use App\Models\Pressio;
use App\Models\Temperatura;
use App\Models\Uvi;
use App\Models\Vent;
use Carbon\Carbon;
use Illuminate\Http\Client\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;

class MeteoController extends Controller
{
    /**
     * Obte l'historic de dades meteo
     *
     * @return void
     */
    public function getMeteo(){
        //$page = $_REQUEST['page'];
        $hora = Carbon::now()->format('H')+3;
        //if($page <= 1){
            $result = Meteo::orderBy('created_at', 'desc')->paginate($hora);
        //}else{
        //    $result = Meteo::orderBy('created_at', 'desc')->paginate(24); 
        //}
        
        //$result = Meteo::whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();
        //$result = Meteo::orderBy('created_at', 'desc')->paginate(24);
        $meteo = [];
        foreach ($result as $key => $value) {
            $meteo[$key]['dia'] = $value->created_at;
            $meteo[$key]['data']['outdoor']['temperature']['value'] = $value->temperature;
            $meteo[$key]['data']['outdoor']['temperature']['unit'] = "℃";
            $meteo[$key]['data']['outdoor']['feels_like']['value'] = $value->feels_like;
            $meteo[$key]['data']['outdoor']['feels_like']['unit'] = "℃";
            $meteo[$key]['data']['outdoor']['dew_point']['value'] = $value->dew_point;
            $meteo[$key]['data']['outdoor']['dew_point']['unit'] = "℃";
            $meteo[$key]['data']['outdoor']['humidity']['value'] = $value->humidity;
            $meteo[$key]['data']['outdoor']['humidity']['unit'] = "%";
            $meteo[$key]['data']['solar_and_uvi']['solar']['value'] = $value->solar;
            $meteo[$key]['data']['solar_and_uvi']['solar']['unit'] = "%";
            $meteo[$key]['data']['solar_and_uvi']['uvi']['value'] = $value->uvi;
            $meteo[$key]['data']['solar_and_uvi']['uvi']['unit'] = "%";
            $meteo[$key]['data']['rainfall']['rain_rate']['value'] = $value->rain_rate;
            $meteo[$key]['data']['rainfall']['rain_rate']['unit'] = "%";
            $meteo[$key]['data']['rainfall']['daily']['value'] = $value->daily;
            $meteo[$key]['data']['rainfall']['daily']['unit'] = "mm/hr";
            $meteo[$key]['data']['rainfall']['event']['value'] = $value->event;
            $meteo[$key]['data']['rainfall']['event']['unit'] = "mm";
            $meteo[$key]['data']['rainfall']['hourly']['value'] = $value->hourly;
            $meteo[$key]['data']['rainfall']['hourly']['unit'] = "mm";
            $meteo[$key]['data']['rainfall']['weekly']['value'] = $value->weekly;
            $meteo[$key]['data']['rainfall']['weekly']['unit'] = "mm";
            $meteo[$key]['data']['rainfall']['monthly']['value'] = $value->monthly;
            $meteo[$key]['data']['rainfall']['monthly']['unit'] = "mm";
            $meteo[$key]['data']['wind']['wind_speed']['value'] = $value->wind_speed;
            $meteo[$key]['data']['wind']['wind_speed']['unit'] = "Km/h";
            $meteo[$key]['data']['wind']['wind_gust']['value'] = $value->wind_gust;
            $meteo[$key]['data']['wind']['wind_gust']['unit'] = "Km/h";
            $meteo[$key]['data']['wind']['wind_direction']['value'] = $value->wind_direction;
            $meteo[$key]['data']['wind']['wind_direction']['unit'] = "º";
            $meteo[$key]['data']['pressure']['relative']['value'] = $value->relative;
            $meteo[$key]['data']['pressure']['relative']['unit'] = "hPa";
            $meteo[$key]['data']['pressure']['absolute']['value'] = $value->absolute;
            $meteo[$key]['data']['pressure']['absolute']['unit'] = "hPa";
            $meteo[$key]['data']['cardener'] = $value->cardener;
            $meteo[$key]['data']['valls'] = $value->valls;
            $meteo[$key]['data']['llosa']= $value->llosa;
            $meteo[$key]['data']['capacitatllosa'] = $value->capacitatllosa;
        }
        return $meteo;
    }
    public function getPreviMeteo(){
        $result = Meteo::get();
        return $result;
    }
    public function getMeteoMaxMin(){
        $res =  Meteo::where('created_at', '>=', Carbon::today())->get();
        $resultat['temperatura'] = $this->getMaxTemperature($res);
        $resultat['humitat'] = $this->getMaxHumitat($res);
        $resultat['vent'] = $this->getMaxVent($res);
        $resultat['rafega'] = $this->getMaxRafega($res);
        return $resultat;
    }
    /**
     * Obte el vent maxim i minim
     *
     * @param [type] $res
     * @return $resultat['temperatura]
     */
    public function getMaxVent($res){
        $resultat["max"]["wind_speed"] = $res->max("wind_speed");
        $resultat["max"]["hora"] = $res->where('wind_speed', '==', $res->max("wind_speed"))->first()->created_at;
        return $resultat;
    }
    /**
     * Obte la rafega maxima i minima
     *
     * @param [type] $res
     * @return $resultat['temperatura]
     */
    public function getMaxRafega($res){
        $resultat["max"]["wind_gust"] = $res->max("wind_gust");
        $resultat["max"]["hora"] = $res->where('wind_gust', '==', $res->max("wind_gust"))->first()->created_at;
        return $resultat;
    }
    /**
     * Obte la temperatura maxima i minima
     *
     * @param [type] $res
     * @return $resultat['temperatura]
     */
    public function getMaxTemperature($res){
        $resultat["max"]["temperatura"] = $res->max("temperature");
        $resultat["max"]["hora"] = $res->where('temperature', '==', $res->max("temperature"))->first()->created_at;
        $resultat["min"]["temperatura"] = $res->min("temperature");
        $resultat["min"]["hora"] = $res->where('temperature', '==', $res->min("temperature"))->first()->created_at;
        return $resultat;
    }
    /**
     * Obte la humitat maxima i minima
     *
     * @param [type] $res
     * @return $resultat['temperatura]
     */
    public function getMaxHumitat($res){
        $resultat["max"]["humitat"] = $res->max("humidity");
        $resultat["max"]["hora"] = $res->where('humidity', '==', $res->max("humidity"))->first()->created_at;
        $resultat["min"]["humitat"] = $res->min("humidity");
        $resultat["min"]["hora"] = $res->where('humidity', '==', $res->min("humidity"))->first()->created_at;
        return $resultat;
    }
    /**
     * Emmagatzema les dades metereologiques a la BBDD
     *
     * @return void
     */
    public function saveDatabaseMeteo(){
        $current = Http::get('https://api.ecowitt.net/api/v3/device/real_time?application_key=411E5E067FA93EBE6CBB7077849A0D88&api_key=48f227ba-17e7-4b10-8e18-cc5456608048&mac=8C:AA:B5:C6:74:5F&call_back=all&temp_unitid=1&wind_speed_unitid=8&rainfall_unitid=12&pressure_unitid=3&wind_speed_unitid=7&rainfall_unitid=12');
        $value = json_decode($current);
        $value->data->cabals = $this->getCabals();
        $this->saveMeteo($value);
    }
    /**
     * Carrega els cabals function
     *
     * @return cabals array
     */
    public function getCabals(){
        $idValls = '251116-004';
        $idCardener = '251116-005';
        $idLlosa = '081419-003';
        $cabalRius = Http::withOptions(['verify' => false,])->get('http://aplicacions.aca.gencat.cat/aetr/vishid/v2/data/public/rivergauges/river_flow_6min');
        $capacitatLlosa = Http::withOptions(['verify' => false,])->get('http://aplicacions.aca.gencat.cat/aetr/vishid/v2/data/public/reservoir/capacity_6min');
        $valor['cardener']= $cabalRius[$idCardener]['popup']['river_flow']['value'];
        $valor['valls']= $cabalRius[$idValls]['popup']['river_flow']['value'];
        $valor['llosa']= $cabalRius[$idLlosa]['popup']['river_flow']['value'];
        $valor['capacitatllosa']= $capacitatLlosa[$idLlosa]['popup']['capacity']['value'];
        return $valor;
    }
    /**
     * Emmagatzema les dades meteo
     *
     * @param [type] $value
     * @return void
     */
    public function saveMeteo($value){
        $meteo= new Meteo();
        $meteo->humidity = $value->data->outdoor->humidity->value;
        $meteo->dew_point = $value->data->outdoor->dew_point->value;
        $meteo->feels_like = $value->data->outdoor->feels_like->value;
        $meteo->rain_rate= $value->data->rainfall->rain_rate->value;
        $meteo->daily = $value->data->rainfall->daily->value;
        $meteo->event =	$value->data->rainfall->event->value;
        $meteo->hourly = $value->data->rainfall->hourly->value;	
        $meteo->weekly = $value->data->rainfall->weekly->value;
        $meteo->monthly = $value->data->rainfall->monthly->value;
        $meteo->absolute = $value->data->pressure->absolute->value;
        $meteo->relative = $value->data->pressure->relative->value;
        $meteo->temperature = $value->data->outdoor->temperature->value;
        $meteo->uvi = $value->data->solar_and_uvi->uvi->value;
        $meteo->solar = $value->data->solar_and_uvi->solar->value;
        $meteo->wind_speed = $value->data->wind->wind_speed->value;	
        $meteo->wind_gust = $value->data->wind->wind_gust->value;
        $meteo->wind_direction = $value->data->wind->wind_direction->value;
        $meteo->cardener = $value->data->cabals["cardener"];
        $meteo->valls = $value->data->cabals["valls"];	
        $meteo->llosa = $value->data->cabals["llosa"];
        $meteo->capacitatllosa = $value->data->cabals["capacitatllosa"];
        $meteo->save();
    }
}
