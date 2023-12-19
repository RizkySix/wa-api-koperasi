<?php

use App\Models\Customer;
use App\Models\Koperasi;
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
        Schema::create('koperasi_user', function (Blueprint $table) {
            $table->foreignIdFor(Koperasi::class)->constrained('koperasis')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('user_nik');
            $table->foreign('user_nik')->references('nik')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('verified')->nullable()->default(false);
            $table->timestamp('verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koperasi_user');
    }
};
