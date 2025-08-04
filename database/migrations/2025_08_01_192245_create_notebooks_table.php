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
        Schema::create('notebooks', function (Blueprint $table) {
            $table->id('id');
            $table->string('brand', 45);
            $table->string('model', 45);
            $table->string('serial_number', 45);
            $table->string('processor', 45);
            $table->integer('memory');
            $table->integer('disk');
            $table->decimal('price', 10, 2);
            $table->string('price_string', 120);
            $table->timestamps();
        });

        Schema::table('notebooks', function (Blueprint $table) {
            $table->index(['brand', 'model']);
            $table->index(['serial_number']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notebooks');
    }
};
