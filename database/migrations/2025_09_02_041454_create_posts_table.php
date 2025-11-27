<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('penulis');
            $table->string('judul');
            $table->string('slug');
            $table->longtext('isi');
            $table->string('gambar');
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });
    } 

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
