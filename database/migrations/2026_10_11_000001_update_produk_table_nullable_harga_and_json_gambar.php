<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableName = Schema::hasTable('produk') ? 'produk' : 'produks';

        Schema::table($tableName, function (Blueprint $table) {
            $table->decimal('harga', 15, 2)->nullable()->change();
            $table->text('gambar')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = Schema::hasTable('produk') ? 'produk' : 'produks';

        Schema::table($tableName, function (Blueprint $table) {
            $table->decimal('harga', 15, 2)->nullable(false)->change();
            $table->string('gambar')->nullable(false)->change();
        });
    }
};
