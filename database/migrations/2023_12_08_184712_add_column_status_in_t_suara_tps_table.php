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
        Schema::table('t_suara_tps', function (Blueprint $table) {
            $table->enum('status',array('waiting','valid','invalid'))->default('waiting')->after('bukti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_suara_tps', function (Blueprint $table) {
            //
        });
    }
};
