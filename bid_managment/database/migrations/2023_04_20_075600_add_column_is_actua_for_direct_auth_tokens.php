<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('direct_auth_tokens', function (Blueprint $table) {
            $table->integer('is_actual')->default(1)->nullable(false);
        });
    }

    public function down(): void
    {
        Schema::table('direct_auth_tokens', function (Blueprint $table) {
            $table->dropColumn('is_actual');
        });
    }
};
