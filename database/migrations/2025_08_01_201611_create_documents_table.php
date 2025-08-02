<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('notebook_id');
            $table->string('local', 45);
            $table->dateTime('date');
            $table->timestamps();

        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('notebook_id')->references('id')->on('notebooks');

            $table->index(['date']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
