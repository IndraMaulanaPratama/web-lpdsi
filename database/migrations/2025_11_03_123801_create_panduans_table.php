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
        Schema::create('panduans', function (Blueprint $table) {
           $table->id();

            // Relasi ke tabel category_panduans
            $table->foreignId('category_panduan_id')->constrained('category_panduans')->onDelete('cascade');

            // Relasi ke tabel divisis
            $table->foreignId('divisi_id')->constrained('divisis')->onDelete('cascade');

            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('penulis');
            $table->longText('isi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panduans');
    }
};
