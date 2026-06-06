<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('driver_name');
            $table->string('driver_phone');
            $table->string('car_model');
            $table->enum('car_type', ['economy', 'comfort', 'premium']);
            $table->string('route_from');
            $table->string('route_to');
            $table->unsignedInteger('seats');
            $table->decimal('price_per_seat', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};

