<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('active_account_for_user', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable(false);
            $table->integer('direct_id')->nullable(false);
            $table->integer('is_actual')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('active_account_for_user');
    }
};
