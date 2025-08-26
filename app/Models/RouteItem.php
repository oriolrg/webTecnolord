<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RouteItem extends Model
{
    protected $fillable = [
        'user_id','uploader_name','title','description','type','visibility','gpx_path',
        'distance_m','elevation_gain_m','start_lat','start_lng','end_lat','end_lng','bbox','status'
    ];

    protected $casts = [
        'bbox' => 'array',
        'track_stats'   => 'array',
        'track_geojson' => 'array',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /*public function pois(): HasMany {
        return $this->hasMany(Poi::class);
    }*/
}
