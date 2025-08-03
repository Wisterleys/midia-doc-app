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
        Schema::create('accessories', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 45);
            $table->string('description', 500)->nullable();
            $table->string('brand', 45)->nullable();
            $table->timestamps();
        });

        Schema::table('accessories', function (Blueprint $table) {
            $table->index(['name']);
            $table->index(['brand']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessories');
    }
};
