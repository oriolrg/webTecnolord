<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('route_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // 🔑 serà null a Fase 1
            $table->string('uploader_name')->nullable(); // opcional: nom que posa qui puja la ruta
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['route','poi_set'])->index();
            $table->enum('visibility', ['public','unlisted','private'])->default('public')->index();
            $table->string('gpx_path')->nullable();

            $table->double('distance_m')->nullable();
            $table->double('elevation_gain_m')->nullable();
            $table->decimal('start_lat', 10, 7)->nullable();
            $table->decimal('start_lng', 10, 7)->nullable();
            $table->decimal('end_lat', 10, 7)->nullable();
            $table->decimal('end_lng', 10, 7)->nullable();
            $table->json('bbox')->nullable();

            $table->enum('status', ['draft','published'])->default('published')->index();

            // Token d’edició sense auth (guardem hash)
            $table->string('edit_token_hash', 64)->nullable()->index();
            $table->json('track_stats')->nullable();   // {distance_m, ascent_m, ...}
            $table->json('track_geojson')->nullable(); // {"type":"LineString","coordinates":[[lon,lat,ele?],...]}

            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('route_items');
    }
};
