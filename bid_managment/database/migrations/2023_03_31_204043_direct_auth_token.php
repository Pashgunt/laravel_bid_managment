<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('direct_auth_tokens', function(Blueprint $table){
            $table->id();
            $table->string('client_id')->default(null)->nullable(true);
            $table->string('client_secret')->default(null)->nullable(true);
            $table->string('acess_token')->default(null)->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('direct_auth_tokens');
    }
};
