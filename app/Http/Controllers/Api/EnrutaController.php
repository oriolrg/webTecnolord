<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RouteItem;
use App\Models\Poi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class EnrutaController extends Controller
{
    public function index(Request $request)
    {
        // Valida de forma compatible
        $validated = $request->validate([
            'visibility'     => 'nullable|in:public,unlisted,private',
            'type'           => 'nullable|in:route,poi_set',
            'uploader_name'  => 'nullable|string|max:255',
            'limit'          => 'nullable|integer|min:1|max:200',
            'page'           => 'nullable|integer|min:1',
        ]);

        $query = RouteItem::query();

        if (!empty($validated['visibility'])) {
            $query->where('visibility', $validated['visibility']);
        }
        if (!empty($validated['type'])) {
            $query->where('type', $validated['type']);
        }
        if (!empty($validated['uploader_name'])) {
            $query->where('uploader_name', $validated['uploader_name']);
        }

        // Càlcul de paginació segur sense $request->integer()
        $limit = (int)($request->query('limit', 100));
        if ($limit < 1)  $limit = 1;
        if ($limit > 200) $limit = 200;

        $page  = (int)($request->query('page', 1));
        if ($page < 1) $page = 1;

        $paginator = $query
            ->orderByDesc('id')
            ->paginate($limit, ['*'], 'page', $page);

        $data = $paginator->getCollection()->map(function (RouteItem $ri) {
            return [
                'id'            => $ri->id,
                'title'         => $ri->title,
                'description'   => $ri->description,
                'type'          => $ri->type,
                'visibility'    => $ri->visibility,
                'uploader_name' => $ri->uploader_name,
                // Necessaris per la “alternativa sense GPX”
                'track_geojson' => $ri->track_geojson,
                'track_stats'   => $ri->track_stats,
                'created_at'    => optional($ri->created_at)->toISOString(),
            ];
        })->values();

        return response()->json([
            'data' => $data,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'uploader_name' => ['nullable','string','max:120'],
            'title'         => ['required','string','max:255'],
            'description'   => ['nullable','string'],
            'type'          => ['required', Rule::in(['route','poi_set'])],
            'visibility'    => ['nullable', Rule::in(['public','unlisted','private'])],
            'gpx'           => ['nullable','file','mimetypes:application/gpx+xml,text/xml,application/xml,text/plain','max:10240'],

            // opcional per ítems de “usuari públic”
            'owner_key'     => ['sometimes','nullable','string','min:6','max:120'],

            // camps opcionals per si no hi ha GPX
            'distance_m'       => ['nullable','numeric'],
            'elevation_gain_m' => ['nullable','numeric'],
            'start_lat'        => ['nullable','numeric'],
            'start_lng'        => ['nullable','numeric'],
            'end_lat'          => ['nullable','numeric'],
            'end_lng'          => ['nullable','numeric'],
            'bbox'             => ['nullable','array'],
        ]);

        $item = new RouteItem();
        $item->fill([
            'uploader_name' => $data['uploader_name'] ?? null,
            'title'         => $data['title'],
            'description'   => $data['description'] ?? null,
            'type'          => $data['type'],
            'visibility'    => $data['visibility'] ?? 'public',
        ]);

        // Assignació de propietari: si hi ha Auth, propietari; si no, “usuari públic”
        if (auth()->check()) {
            $item->user_id = auth()->id();
        } else {
            $item->user_id = null;

            // owner_key pot venir per body o per header (X-Owner-Key)
            $ownerKey = $data['owner_key'] ?? ($request->header('X-Owner-Key') ?: null);
            if (!empty($ownerKey)) {
                $item->owner_key_hash = hash('sha256', $ownerKey);
            }
        }

        // Token d’edició per ítem
        $editToken = Str::random(40);
        $item->edit_token_hash = hash('sha256', $editToken);

        // GPX o stats manuals
        if ($request->hasFile('gpx')) {
            $folder = 'gpx/global';
            $filename = Str::uuid().'.gpx';
            $path = $request->file('gpx')->storeAs($folder, $filename, 'local');
            $item->gpx_path = $path;

            try {
                [$geojson, $stats] = \App\Services\GpxService::parse(Storage::get($path));
                $item->track_geojson = $geojson;
                $item->track_stats   = $stats;
            } catch (\Throwable $e) {
                Storage::delete($path);
                return response()->json([
                    'message' => 'GPX parse failed',
                    'error'   => $e->getMessage(),
                ], 422);
            }
        } else {
            $stats = [
                'distance_m'        => $data['distance_m'] ?? null,
                'elevation_gain_m'  => $data['elevation_gain_m'] ?? null,
                'ascent_m'          => $data['elevation_gain_m'] ?? null, // compatibilitat
                'bbox'              => $data['bbox'] ?? null,
                'start'             => (isset($data['start_lng'], $data['start_lat'])) ? [$data['start_lng'], $data['start_lat']] : null,
                'end'               => (isset($data['end_lng'],   $data['end_lat']))   ? [$data['end_lng'],   $data['end_lat']]   : null,
            ];
            if (array_filter($stats, fn($v) => !is_null($v))) {
                $item->track_stats = $stats;
            }
        }

        $item->save();

        $payload = $item->toArray();
        $payload['edit_token'] = $editToken; // només en crear

        return response()->json($payload, 201);
    }

    public function show(Request $request, RouteItem $routeItem)
    {
        if ($routeItem->visibility === 'private') {
            abort(403);
        }

        $this->hydrateTrackIfMissing($routeItem);

        return response()->json($routeItem->only([
            'id','uploader_name','title','description','type','visibility',
            'gpx_path','track_stats','track_geojson','created_at','updated_at'
        ]));
    }

    public function track(Request $request, RouteItem $routeItem)
    {
        $format = strtolower($request->query('format', 'geojson'));

        if ($format === 'geojson') {
            $this->hydrateTrackIfMissing($routeItem);
            return response()->json($routeItem->track_geojson ?? []);
        }

        if ($format === 'gpx') {
            if (!$routeItem->gpx_path || !Storage::exists($routeItem->gpx_path)) {
                return response()->json(['message' => 'GPX not found'], 404);
            }

            return response()->download(
                Storage::path($routeItem->gpx_path),
                basename($routeItem->gpx_path),
                ['Content-Type' => 'application/gpx+xml']
            );
        }

        return response()->json(['message' => 'Format not supported. Use "geojson" or "gpx".'], 400);
    }

    public function downloadGpx(RouteItem $routeItem)
    {
        abort_unless($routeItem->gpx_path, 404);

        $downloadName = Str::slug($routeItem->title.'-'.$routeItem->id).'.gpx';

        return response()->download(
            Storage::path($routeItem->gpx_path),
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

        // Omple camps simples
        $routeItem->fill(collect($data)->except([
            'gpx','distance_m','elevation_gain_m','start_lat','start_lng','end_lat','end_lng','bbox'
        ])->all());

        // Si puja un GPX nou: desar + parsejar
        if ($request->hasFile('gpx')) {
            if ($routeItem->gpx_path) {
                Storage::delete($routeItem->gpx_path);
            }
            $folder = 'gpx/global';
            $filename = Str::uuid().'.gpx';
            $routeItem->gpx_path = $request->file('gpx')->storeAs($folder, $filename, 'local');

            try {
                [$geojson, $stats] = \App\Services\GpxService::parse(Storage::get($routeItem->gpx_path));
                $routeItem->track_geojson = $geojson;
                $routeItem->track_stats   = $stats;
            } catch (\Throwable $e) {
                Storage::delete($routeItem->gpx_path);
                return response()->json([
                    'message' => 'GPX parse failed',
                    'error'   => $e->getMessage(),
                ], 422);
            }
        } else {
            // Sense GPX nou: permet actualitzar stats manuals (merge sobre existents)
            $manualStats = [
                'distance_m'        => $data['distance_m'] ?? null,
                'elevation_gain_m'  => $data['elevation_gain_m'] ?? null,
                'ascent_m'          => $data['elevation_gain_m'] ?? null, // compatibilitat
                'bbox'              => $data['bbox'] ?? null,
                'start'             => (isset($data['start_lng'], $data['start_lat'])) ? [$data['start_lng'], $data['start_lat']] : null,
                'end'               => (isset($data['end_lng'],   $data['end_lat']))   ? [$data['end_lng'],   $data['end_lat']]   : null,
            ];
            if (array_filter($manualStats, fn($v) => !is_null($v))) {
                $routeItem->track_stats = array_filter(
                    array_merge($routeItem->track_stats ?? [], $manualStats),
                    fn ($v) => !is_null($v)
                );
            }
        }

        $routeItem->save();

        // Evita trencar si no tens la relació 'pois' al model:
        return response()->json($routeItem->fresh());
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

        return response()->json($result);
    }

   private function assertEditToken(Request $request, RouteItem $routeItem): void
{
    $dbg = [
        'item_id' => $routeItem->id,
        'has_user_id' => !empty($routeItem->user_id),
        'has_edit_hash' => !empty($routeItem->edit_token_hash),
        'has_owner_hash' => !empty($routeItem->owner_key_hash),
    ];

    // 0) Admin override (emergència)
    $adminKey = (string)$request->header('X-Admin-Key');
    if ($adminKey !== '' && hash_equals($adminKey, (string) env('ENRUTA_ADMIN_KEY'))) {
        \Log::info('Enruta auth: ADMIN override OK', $dbg);
        return;
    }

    // 1) Ítems 100% legacy sense cap propietat → permet
    if (empty($routeItem->user_id) && empty($routeItem->edit_token_hash) && empty($routeItem->owner_key_hash)) {
        \Log::info('Enruta auth: legacy item (no owner/edit) → OK', $dbg);
        return;
    }

    // 2) Usuari autenticat propietari o amb edit_token
    if (!empty($routeItem->user_id)) {
        if (auth()->check() && auth()->id() === (int)$routeItem->user_id) {
            \Log::info('Enruta auth: logged owner → OK', $dbg);
            return;
        }
        $token = (string)($request->header('X-Edit-Token') ?: $request->input('edit_token'));
        if ($token !== '' && hash('sha256', $token) === $routeItem->edit_token_hash) {
            \Log::info('Enruta auth: edit_token match → OK', $dbg);
            return;
        }
        \Log::warning('Enruta auth: FAIL (user-owned item, no match)', $dbg);
        abort(403, 'Token d’edició invàlid');
    }

    // 3) Clau d’usuari públic
    $ownerKey = trim((string)($request->header('X-Owner-Key') ?: $request->input('owner_key')));
    $ownerKeyHash = $ownerKey !== '' ? hash('sha256', $ownerKey) : null;

    // 3.a) Si l’ítem ja té owner_key_hash i coincideix → OK
    if ($ownerKeyHash && $routeItem->owner_key_hash && hash_equals($ownerKeyHash, $routeItem->owner_key_hash)) {
        \Log::info('Enruta auth: owner_key match → OK', $dbg);
        return;
    }

    // 3.b) **CLAIM**: si és públic (sense user_id) i NO té owner_key_hash, accepta la clau i guarda-la
    if ($ownerKeyHash && empty($routeItem->owner_key_hash)) {
        $routeItem->owner_key_hash = $ownerKeyHash; // backfill
        $routeItem->save();
        \Log::info('Enruta auth: owner_key CLAIM on empty → OK (backfilled)', $dbg);
        return;
    }

    // 3.c) **RECOVERY GLOBAL**: si existeix qualsevol altre ítem amb aquest owner_key_hash → OK
    if ($ownerKeyHash) {
        $exists = \App\Models\RouteItem::whereNull('user_id')
            ->where('owner_key_hash', $ownerKeyHash)
            ->where('id', '!=', $routeItem->id)
            ->exists();
        if ($exists) {
            \Log::info('Enruta auth: recovery global → OK', $dbg);
            // opcional: si l’actual no la tenia, backfill
            if (empty($routeItem->owner_key_hash)) {
                $routeItem->owner_key_hash = $ownerKeyHash;
                $routeItem->save();
            }
            return;
        }
    }

    // 4) Fallback: edit_token
    $token = (string)($request->header('X-Edit-Token') ?: $request->input('edit_token'));
    if ($token !== '' && $routeItem->edit_token_hash && hash('sha256', $token) === $routeItem->edit_token_hash) {
        \Log::info('Enruta auth: edit_token fallback → OK', $dbg);
        return;
    }

    \Log::warning('Enruta auth: FAIL (public item, no owner/edit match)', $dbg + [
        'recv_owner' => $ownerKey !== '' ? 'present' : 'absent',
        'recv_edit'  => $token !== '' ? 'present' : 'absent',
    ]);
    abort(403, 'Token d’edició invàlid');
}


    /**
     * Hidrata track_geojson/track_stats “on demand” si falta però tenim GPX.
     */
    protected function hydrateTrackIfMissing(RouteItem $routeItem): void
    {
        if (!empty($routeItem->track_geojson)) {
            return;
        }
        if (!$routeItem->gpx_path || !Storage::exists($routeItem->gpx_path)) {
            return;
        }

        try {
            [$geojson, $stats] = \App\Services\GpxService::parse(
                Storage::get($routeItem->gpx_path)
            );

            // merge amb stats existents (manuals o antigues)
            $routeItem->track_geojson = $geojson;
            $routeItem->track_stats = array_filter(
                array_merge($routeItem->track_stats ?? [], $stats ?? []),
                fn ($v) => !is_null($v)
            );
            $routeItem->save();
        } catch (\Throwable $e) {
            // Opcionalment logueja, però no bloquegis la petició
            // \Log::warning('GPX lazy hydrate failed', ['id'=>$routeItem->id,'err'=>$e->getMessage()]);
        }
    }
}
