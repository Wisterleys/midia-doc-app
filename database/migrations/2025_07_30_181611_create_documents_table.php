<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users');
            $table->string('user_name');
            $table->string('user_document');
            $table->string('user_role');

            $table->string('brand');
            $table->string('model');
            $table->string('serial_number');
            $table->string('processor');
            $table->string('memory');
            $table->string('disk');
            $table->decimal('price', 10, 2);
            $table->string('price_string');

            $table->string('local');
            $table->date('date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
