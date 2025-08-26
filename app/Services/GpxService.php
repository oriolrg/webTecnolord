<?php
// app/Services/GpxService.php
namespace App\Services;

class GpxService
{
    public static function parse(string $gpx): array
    {
        $xml = simplexml_load_string($gpx);
        // Namespaces (GPX 1.1)
        $xml->registerXPathNamespace('gpx', 'http://www.topografix.com/GPX/1/1');
        $pts = $xml->xpath('//gpx:trk/gpx:trkseg/gpx:trkpt') ?: [];

        $coords = [];
        $distance = 0.0; $ascent = 0.0; $descent = 0.0;
        $minLat = $minLon =  999; $maxLat = $maxLon = -999;
        $firstTime = null; $lastTime = null;

        $prev = null;
        foreach ($pts as $p) {
            $lat = (float)$p['lat']; $lon = (float)$p['lon'];
            $ele = isset($p->ele) ? (float)$p->ele : null;
            $time= isset($p->time)? strtotime((string)$p->time) : null;

            $coords[] = $ele !== null ? [$lon,$lat,$ele] : [$lon,$lat];

            $minLat = min($minLat,$lat); $maxLat = max($maxLat,$lat);
            $minLon = min($minLon,$lon); $maxLon = max($maxLon,$lon);

            if ($time) { $firstTime ??= $time; $lastTime = $time; }

            if ($prev) {
                $distance += self::haversine($prev['lat'],$prev['lon'],$lat,$lon);
                if ($ele !== null && $prev['ele'] !== null) {
                    $d = $ele - $prev['ele'];
                    if ($d > 0) $ascent += $d; else $descent += -$d;
                }
            }
            $prev = ['lat'=>$lat,'lon'=>$lon,'ele'=>$ele];
        }

        $geojson = [
            'type' => 'LineString',
            'coordinates' => $coords,
        ];
        $stats = [
            'points'      => count($coords),
            'distance_m'  => round($distance, 2),
            'ascent_m'    => round($ascent, 1),
            'descent_m'   => round($descent, 1),
            'duration_s'  => $firstTime && $lastTime ? max(0, $lastTime - $firstTime) : null,
            'bbox'        => [$minLon,$minLat,$maxLon,$maxLat], // [west,south,east,north]
            'start'       => $coords[0] ?? null,
            'end'         => $coords[count($coords)-1] ?? null,
        ];

        return [$geojson, $stats];
    }

    protected static function haversine($lat1,$lon1,$lat2,$lon2): float
    {
        $R = 6371000; // metres
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2)**2 + cos(deg2rad($lat1))*cos(deg2rad($lat2))*sin($dLon/2)**2;
        return 2 * $R * atan2(sqrt($a), sqrt(1-$a));
    }
}
