<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RouteItem;
//use App\Models\Poi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class EnrutaController extends Controller
{
    public function index(Request $request)
    {
        $query = RouteItem::query();

        if ($type = $request->query('type')) {
            $query->where('type', $type);
        }

        if ($visibility = $request->query('visibility')) {
            $query->where('visibility', $visibility);
        } else {
            // per defecte només public i unlisted
            $query->whereIn('visibility', ['public','unlisted']);
        }

        if ($q = $request->query('q')) {
            $query->where(function($qq) use ($q) {
                $qq->where('title', 'like', "%$q%")
                   ->orWhere('description', 'like', "%$q%");
            });
        }

        return $query->latest()->paginate($request->integer('per_page', 20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'uploader_name' => ['nullable','string','max:120'],
            'title'         => ['required','string','max:255'],
            'description'   => ['nullable','string'],
            'type'          => ['required', \Illuminate\Validation\Rule::in(['route','poi_set'])],
            'visibility'    => ['nullable', \Illuminate\Validation\Rule::in(['public','unlisted','private'])],

            'gpx'           => ['nullable','file','mimetypes:application/gpx+xml,text/xml,application/xml,text/plain','max:10240'],

            // camps opcionals per si no hi ha GPX
            'distance_m'       => ['nullable','numeric'],
            'elevation_gain_m' => ['nullable','numeric'],
            'start_lat'        => ['nullable','numeric'],
            'start_lng'        => ['nullable','numeric'],
            'end_lat'          => ['nullable','numeric'],
            'end_lng'          => ['nullable','numeric'],
            'bbox'             => ['nullable','array'],
        ]);

        $item = new \App\Models\RouteItem();
        $item->fill([
            'uploader_name' => $data['uploader_name'] ?? null,
            'title'         => $data['title'],
            'description'   => $data['description'] ?? null,
            'type'          => $data['type'],
            'visibility'    => $data['visibility'] ?? 'public',
        ]);
        $item->user_id = null; // fase 1: sense usuari

        // Token d’edició (guardem el hash; el token pla el retornarem al client)
        $editToken = \Illuminate\Support\Str::random(40);
        $item->edit_token_hash = hash('sha256', $editToken);

        // Si ve un GPX, el desen i el parsegem
        if ($request->hasFile('gpx')) {
            $folder = 'gpx/global';
            $filename = \Illuminate\Support\Str::uuid().'.gpx';
            $path = $request->file('gpx')->storeAs($folder, $filename, 'local');
            $item->gpx_path = $path;

            try {
                [$geojson, $stats] = \App\Services\GpxService::parse(\Illuminate\Support\Facades\Storage::get($path));
                $item->track_geojson = $geojson; // array (LineString)
                $item->track_stats   = $stats;   // array (distance_m, ascent_m, ... bbox, start, end)
            } catch (\Throwable $e) {
                // neteja si el parse falla
                \Illuminate\Support\Facades\Storage::delete($path);
                return response()->json([
                    'message' => 'GPX parse failed',
                    'error'   => $e->getMessage(),
                ], 422);
            }
        } else {
            // Sense GPX: permetre guardar estadístiques bàsiques si arriben
            $stats = [
                'distance_m' => $data['distance_m'] ?? null,
                'ascent_m'   => $data['elevation_gain_m'] ?? null,
                'bbox'       => $data['bbox'] ?? null,
                'start'      => (isset($data['start_lng'], $data['start_lat'])) ? [$data['start_lng'], $data['start_lat']] : null,
                'end'        => (isset($data['end_lng'],   $data['end_lat']))   ? [$data['end_lng'],   $data['end_lat']]   : null,
            ];
            if (array_filter($stats, fn($v) => !is_null($v))) {
                $item->track_stats = $stats;
            }
        }

        $item->save();

        $payload = $item->toArray();
        $payload['edit_token'] = $editToken; // només es mostra en crear

        return response()->json($payload, 201);
    }


    public function show(Request $request, RouteItem $routeItem)
    {
        if ($routeItem->visibility === 'private') {
            abort(403);
        }

        // Si vols controlar els camps retornats:
        return response()->json($routeItem->only([
            'id','uploader_name','title','description','type','visibility',
            'gpx_path','track_stats','track_geojson','created_at','updated_at'
        ]));
    }
    public function track(Request $request, RouteItem $routeItem)
    {
        $format = strtolower($request->query('format', 'geojson'));

        if ($format === 'geojson') {
            return response()->json($routeItem->track_geojson);
        }

        if ($format === 'gpx') {
            if (! $routeItem->gpx_path || ! \Storage::exists($routeItem->gpx_path)) {
                return response()->json(['message' => 'GPX not found'], 404);
            }

            return response()->download(
                \Storage::path($routeItem->gpx_path),
                basename($routeItem->gpx_path),
                ['Content-Type' => 'application/gpx+xml']
            );
        }

        return response()->json(['message' => 'Format not supported. Use "geojson" or "gpx".'], 400);
    }

    public function downloadGpx(\App\Models\RouteItem $routeItem)
    {
        abort_unless($routeItem->gpx_path, 404);

        $downloadName = \Illuminate\Support\Str::slug($routeItem->title.'-'.$routeItem->id).'.gpx';

        return response()->download(
            \Illuminate\Support\Facades\Storage::path($routeItem->gpx_path),
            $downloadName,
            ['Content-Type' => 'application/gpx+xml']
        );
    }

    public function update(Request $request, RouteItem $routeItem)
    {
        $this->assertEditToken($request, $routeItem);

        $data = $request->validate([
            'uploader_name' => ['sometimes','nullable','string','max:120'],
            'title'         => ['sometimes','string','max:255'],
            'description'   => ['sometimes','nullable','string'],
            'visibility'    => ['sometimes', Rule::in(['public','unlisted','private'])],
            'status'        => ['sometimes', Rule::in(['draft','published'])],

            'gpx'           => ['sometimes','file','mimetypes:application/gpx+xml,text/xml,application/xml,text/plain','max:10240'],

            'distance_m'       => ['sometimes','nullable','numeric'],
            'elevation_gain_m' => ['sometimes','nullable','numeric'],
            'start_lat'        => ['sometimes','nullable','numeric'],
            'start_lng'        => ['sometimes','nullable','numeric'],
            'end_lat'          => ['sometimes','nullable','numeric'],
            'end_lng'          => ['sometimes','nullable','numeric'],
            'bbox'             => ['sometimes','nullable','array'],
        ]);

        $routeItem->fill($data);

        if ($request->hasFile('gpx')) {
            if ($routeItem->gpx_path) {
                Storage::delete($routeItem->gpx_path);
            }
            $folder = 'gpx/global';
            $filename = Str::uuid().'.gpx';
            $routeItem->gpx_path = $request->file('gpx')->storeAs($folder, $filename, 'local');
        }

        $routeItem->save();
        return $routeItem->fresh()->load('pois');
    }

    public function destroy(Request $request, RouteItem $routeItem)
    {
        $this->assertEditToken($request, $routeItem);

        if ($routeItem->gpx_path) {
            Storage::delete($routeItem->gpx_path);
        }
        $routeItem->delete();

        return response()->noContent();
    }

    public function upsertPois(Request $request, RouteItem $routeItem)
    {
        $this->assertEditToken($request, $routeItem);

        $data = $request->validate([
            'pois'               => ['required','array','min:1'],
            'pois.*.id'          => ['nullable','integer','exists:pois,id'],
            'pois.*.name'        => ['required','string','max:255'],
            'pois.*.description' => ['nullable','string'],
            'pois.*.lat'         => ['required','numeric'],
            'pois.*.lng'         => ['required','numeric'],
            'pois.*.altitude_m'  => ['nullable','numeric'],
            'pois.*.sort_order'  => ['nullable','integer'],
            'pois.*.meta'        => ['nullable','array'],
        ]);

        $result = [];
        foreach ($data['pois'] as $p) {
            if (!empty($p['id'])) {
                $poi = Poi::where('route_item_id', $routeItem->id)->where('id', $p['id'])->firstOrFail();
                $poi->update($p);
            } else {
                $poi = $routeItem->pois()->create($p);
            }
            $result[] = $poi;
        }

        return $result;
    }

    /*public function downloadGpx(Request $request, RouteItem $routeItem)
    {
        if (!$routeItem->gpx_path) abort(404, 'No hi ha GPX associat');
        if ($routeItem->visibility === 'private') abort(403);

        $filename = Str::slug($routeItem->title.'-'.$routeItem->id).'.gpx';
        return response()->download(storage_path('app/'.$routeItem->gpx_path), $filename);
    }*/

    private function assertEditToken(Request $request, RouteItem $routeItem): void
    {
        $token = $request->header('X-Edit-Token') ?: $request->input('edit_token');
        abort_unless($token && $routeItem->edit_token_hash === hash('sha256', $token), 403, 'Token d’edició invàlid');
    }
}