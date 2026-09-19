<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spm_indicators', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama_indikator');
            $table->text('deskripsi')->nullable();
            $table->string('satuan', 100)->nullable();
            $table->integer('target')->default(0);
            $table->integer('capaian')->default(0);
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spm_indicators');
    }
};
