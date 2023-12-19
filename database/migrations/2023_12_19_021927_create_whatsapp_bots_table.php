<?php

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
        Schema::create('whatsapp_bots', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Koperasi::class);
            $table->string('wa_phone' , 50);
            $table->string('app_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_bots');
    }
};
