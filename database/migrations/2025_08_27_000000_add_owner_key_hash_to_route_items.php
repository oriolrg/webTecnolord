<?php 
// database/migrations/2025_08_27_000000_add_owner_key_hash_to_route_items.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('route_items', function (Blueprint $table) {
            $table->string('owner_key_hash', 64)->nullable()->after('edit_token_hash');
            $table->index('owner_key_hash');
        });
    }
    public function down(): void {
        Schema::table('route_items', function (Blueprint $table) {
            $table->dropIndex(['owner_key_hash']);
            $table->dropColumn('owner_key_hash');
        });
    }
};
