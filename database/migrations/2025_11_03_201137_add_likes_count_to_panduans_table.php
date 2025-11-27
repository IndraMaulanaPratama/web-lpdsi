<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('panduans', function (Blueprint $table) {
            if (!Schema::hasColumn('panduans', 'likes_count')) {
                $table->unsignedInteger('likes_count')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('panduans', function (Blueprint $table) {
            if (Schema::hasColumn('panduans', 'likes_count')) {
                $table->dropColumn('likes_count');
            }
        });
    }
};
