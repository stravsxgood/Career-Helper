<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('record_jobs', function (Blueprint $table) {
            $table->id();

            // Tanggal Melamar
            $table->date('applied_at');

            // Nama Platform/Web (misal: Glints, LinkedIn, JobStreet, dll)
            $table->string('platform');

            // Nama Perusahaan
            $table->string('company_name');

            // Posisi Pekerjaan
            $table->string('position');

            // Status Lamaran (Default: Applied)
            $table->enum('status', ['Applied', 'Interview', 'Testing', 'Accepted', 'Rejected'])
                  ->default('Applied');

            // Gaji/Salary (Menggunakan unsignedBigInteger untuk menampung nominal angka tanpa desimal)
            $table->unsignedBigInteger('salary')->nullable();

            // URL Lowongan Pekerjaan
            $table->string('job_url')->nullable();

            // Catatan Tambahan
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('record_jobs');
    }
};
