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
        Schema::create('accessory_notebook', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accessory_id');
            $table->unsignedBigInteger('notebook_id');
            $table->timestamps();
        });

        Schema::table('accessory_notebook', function (Blueprint $table) {
            $table->foreign('accessory_id')->references('id')->on('accessories');
            $table->foreign('notebook_id')->references('id')->on('notebooks');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessory_notebook');
    }
};
