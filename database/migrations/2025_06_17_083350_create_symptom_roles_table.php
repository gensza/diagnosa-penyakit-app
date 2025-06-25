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
        Schema::create('symptom_roles', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rule', 100);
            $table->string('kode_gejala', 100);
            $table->integer('id_penyakit');
            $table->string('nama_penyakit', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('symptom_roles');
    }
};
