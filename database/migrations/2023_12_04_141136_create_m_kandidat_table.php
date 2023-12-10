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
        Schema::create('m_kandidat', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("id_partai");
            $table->string("nama");
            $table->enum("kategori",array("caleg","lawan"));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kandidat');
    }
};
