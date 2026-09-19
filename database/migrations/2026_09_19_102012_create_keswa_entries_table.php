<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keswa_entries', function (Blueprint $table) {
            $table->id();

            // Periode laporan
            $table->date('tanggal');

            // ODGJ Berat
            $table->unsignedInteger('total_odgj_berat')->default(0);

            // SPM
            $table->unsignedInteger('spm_sasaran')->default(0);
            $table->unsignedInteger('spm_capaian')->default(0);

            // Diagnosis
            $table->unsignedInteger('f23')->default(0);
            $table->unsignedInteger('f20')->default(0);

            // Distribusi 5 desa/kelurahan
            $table->unsignedInteger('manusak')->default(0);
            $table->unsignedInteger('oelatimo')->default(0);
            $table->unsignedInteger('pukdale')->default(0);
            $table->unsignedInteger('nunkurus')->default(0);
            $table->unsignedInteger('naibonat')->default(0);

            // Pemantauan obat
            $table->unsignedInteger('obat_sasaran')->default(0);
            $table->unsignedInteger('obat_rutin')->default(0);
            $table->unsignedInteger('obat_tidak_rutin')->default(0);
            $table->unsignedInteger('obat_putus')->default(0);

            // ODGJB baru
            $table->unsignedInteger('odgjb_baru')->default(0);

            // Pelacakan
            $table->unsignedInteger('pelacakan_sasaran')->default(0);
            $table->unsignedInteger('pelacakan_capaian')->default(0);

            // P3LP
            $table->unsignedInteger('p3lp_sasaran')->default(0);

            // Skrining
            $table->unsignedInteger('skrining_sasaran')->default(0);
            $table->unsignedInteger('skrining_capaian')->default(0);

            // Kendala, solusi, dan RTL
            $table->text('kendala')->nullable();
            $table->text('solusi')->nullable();
            $table->text('rencana_tindak_lanjut')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keswa_entries');
    }
};