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
        Schema::create('general_wallets', function (Blueprint $table) {
            $table->id();
            $table->string('user_nik');
            $table->foreign('user_nik')->references('nik')->on('users');
            $table->string('ipaymu_va');
            $table->string('ipaymu_email');
            $table->string('ipaymu_name');
            $table->timestamp('active_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_wallets');
    }
};
