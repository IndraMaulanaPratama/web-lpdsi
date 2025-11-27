<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('sops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_sop_id')->constrained('category_sops')->onDelete('cascade');
            $table->foreignId('divisi_id')->constrained('divisis')->onDelete('cascade');
            $table->string('sop_name');
            $table->string('sop_description')->nullable();
            $table->boolean('sop_status')->default(true);
            $table->text('sop_file')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sops');
    }
};
