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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum("level",array('admin','kabupaten','kecamatan','desa','tps'))->default("admin");
            $table->string("no_ktp",16);
            $table->string("alamat");
            $table->bigInteger("id_kab");
            $table->bigInteger("id_kec");
            $table->bigInteger("id_desa");
            $table->bigInteger("id_tps")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
