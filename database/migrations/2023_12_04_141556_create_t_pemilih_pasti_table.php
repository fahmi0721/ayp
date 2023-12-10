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
        Schema::create('t_pemilih_pasti', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("id_kabupaten")->index();
            $table->bigInteger("id_kecamatan")->index();
            $table->bigInteger("id_desa")->index();
            $table->bigInteger("id_tps")->index();
            $table->string("no_ktp")->unique();
            $table->string("nama");
            $table->string("alamat");
            $table->string("keterangan");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_pemilih_pasti');
    }
};
