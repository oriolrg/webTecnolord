<?php

namespace App\Http\Controllers;

use App\Models\Meteo;
use Carbon\Carbon;
use Illuminate\Http\Request; // ✔ correcte (abans tenies Illuminate\Http\Client\Request)
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MeteoController extends Controller
{
    /**
     * Obté l'històric de dades meteo
     */
    public function getMeteo()
    {
        $hora = (int) Carbon::now()->format('H') + 3;
        $result = Meteo::orderBy('created_at', 'desc')->paginate($hora);

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

        // Et retorno JSON amb headers correctes
        return response()->json($meteo);
    }

    public function getPreviMeteo()
    {
        return response()->json(Meteo::get());
    }

    /**
     * Endpoint “max/min” robust (no peta si no hi ha dades)
     */
    public function getMeteoMaxMin()
    {
        $res = Meteo::where('created_at', '>=', Carbon::today())->get();

        if (!$res instanceof Collection || $res->isEmpty()) {
            Log::info('Meteo.getMeteoMaxMin: no data today');
            return response()->json([
                'temperatura' => $this->emptyMaxMin(),
                'humitat'     => $this->emptyMaxMin(),
                'vent'        => $this->emptyMaxMin(),
                'rafega'      => $this->emptyMaxMin(),
            ]);
        }

        return response()->json([
            'temperatura' => $this->getMaxTemperature($res),
            'humitat'     => $this->getMaxHumitat($res),
            'vent'        => $this->getMaxVent($res),
            'rafega'      => $this->getMaxRafega($res),
        ]);
    }

    /** Helpers comuns */
    private function emptyMaxMin(): array
    {
        return [
            'max' => ['value' => null, 'hora' => null],
            'min' => ['value' => null, 'hora' => null],
        ];
    }

    private function toIso($ts): ?string
    {
        if (!$ts) return null;
        return method_exists($ts, 'toIso8601String') ? $ts->toIso8601String() : (string) $ts;
    }

    private function maxMin(Collection $res, string $field): array
    {
        // descarta files sense valor
        $filtered = $res->filter(fn($r) => isset($r->$field) && $r->$field !== null);

        if ($filtered->isEmpty()) return $this->emptyMaxMin();

        // evita comparar floats per igualtat; ordena i agafa el 1r
        $maxRow = $filtered->sortByDesc($field)->first();
        $minRow = $filtered->sortBy($field)->first();

        return [
            'max' => [
                'value' => (float) $maxRow->$field,
                'hora'  => $this->toIso($maxRow->created_at),
            ],
            'min' => [
                'value' => (float) $minRow->$field,
                'hora'  => $this->toIso($minRow->created_at),
            ],
        ];
    }

    /** Max/min de cada magnitud — deleguen al helper comú */
    public function getMaxVent(Collection $res)    { return $this->maxMin($res, 'wind_speed'); }
    public function getMaxRafega(Collection $res)  { return $this->maxMin($res, 'wind_gust'); }
    public function getMaxTemperature(Collection $res){ return $this->maxMin($res, 'temperature'); }
    public function getMaxHumitat(Collection $res) { return $this->maxMin($res, 'humidity'); }

    /**
     * Guarda una lectura “manual”
     */
    public function saveDatabaseMeteo()
    {
        $current = Http::get('https://api.ecowitt.net/api/v3/device/real_time?application_key=411E5E067FA93EBE6CBB7077849A0D88&api_key=48f227ba-17e7-4b10-8e18-cc5456608048&mac=8C:AA:B5:C6:74:5F&call_back=all&temp_unitid=1&wind_speed_unitid=8&rainfall_unitid=12&pressure_unitid=3&wind_speed_unitid=7&rainfall_unitid=12');
        $value = json_decode($current);
        $value->data->cabals = $this->getCabals();
        $this->saveMeteo($value);
        return response()->json(['ok' => true]);
    }

    public function saveCronDatabaseMeteo()
    {
        $current = Http::get('https://api.ecowitt.net/api/v3/device/real_time?application_key=411E5E067FA93EBE6CBB7077849A0D88&api_key=48f227ba-17e7-4b10-8e18-cc5456608048&mac=8C:AA:B5:C6:74:5F&call_back=all&temp_unitid=1&wind_speed_unitid=8&rainfall_unitid=12&pressure_unitid=3&wind_speed_unitid=7&rainfall_unitid=12');
        $value = json_decode($current);
        $value->data->cabals = $this->getCabals();
        $this->saveMeteo($value);
        return response()->json(['ok' => true]);
    }

    /**
     * Carrega els cabals amb guàrdies per evitar 500 si l’API canvia
     */
    public function getCabals(): array
    {
        $idValls = '251116-004';
        $idCardener = '251116-005';
        $idLlosa = '081419-003';

        $cabalRius = Http::withOptions(['verify' => false])->get('http://aplicacions.aca.gencat.cat/aetr/vishid/v2/data/public/rivergauges/river_flow_6min')->json();
        $capacitatLlosa = Http::withOptions(['verify' => false])->get('http://aplicacions.aca.gencat.cat/aetr/vishid/v2/data/public/reservoir/capacity_6min')->json();

        $get = fn($arr, $path) => data_get($arr, $path);
        return [
            'cardener'      => $get($cabalRius, "{$idCardener}.popup.river_flow.value"),
            'valls'         => $get($cabalRius, "{$idValls}.popup.river_flow.value"),
            'llosa'         => $get($cabalRius, "{$idLlosa}.popup.river_flow.value"),
            'capacitatllosa'=> $get($capacitatLlosa, "{$idLlosa}.popup.capacity.value"),
        ];
    }

    /**
     * Desa una lectura a BBDD
     */
    public function saveMeteo($value)
    {
        $meteo= new Meteo();
        $meteo->humidity       = $value->data->outdoor->humidity->value ?? null;
        $meteo->dew_point      = $value->data->outdoor->dew_point->value ?? null;
        $meteo->feels_like     = $value->data->outdoor->feels_like->value ?? null;
        $meteo->rain_rate      = $value->data->rainfall->rain_rate->value ?? null;
        $meteo->daily          = $value->data->rainfall->daily->value ?? null;
        $meteo->event          = $value->data->rainfall->event->value ?? null;
        $meteo->hourly         = $value->data->rainfall->hourly->value ?? null;
        $meteo->weekly         = $value->data->rainfall->weekly->value ?? null;
        $meteo->monthly        = $value->data->rainfall->monthly->value ?? null;
        $meteo->absolute       = $value->data->pressure->absolute->value ?? null;
        $meteo->relative       = $value->data->pressure->relative->value ?? null;
        $meteo->temperature    = $value->data->outdoor->temperature->value ?? null;
        $meteo->uvi            = $value->data->solar_and_uvi->uvi->value ?? null;
        $meteo->solar          = $value->data->solar_and_uvi->solar->value ?? null;
        $meteo->wind_speed     = $value->data->wind->wind_speed->value ?? null;
        $meteo->wind_gust      = $value->data->wind->wind_gust->value ?? null;
        $meteo->wind_direction = $value->data->wind->wind_direction->value ?? null;
        $meteo->cardener       = $value->data->cabals["cardener"] ?? null;
        $meteo->valls          = $value->data->cabals["valls"] ?? null;
        $meteo->llosa          = $value->data->cabals["llosa"] ?? null;
        $meteo->capacitatllosa = $value->data->cabals["capacitatllosa"] ?? null;
        $meteo->save();
    }
}

