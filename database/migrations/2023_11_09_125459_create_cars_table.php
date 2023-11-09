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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string("model");
            $table->string("year");
            $table->string("phone");
            $table->string("whatsapp");
            $table->string("title");
            $table->text("description");
            $table->string("location");
            $table->string("body_type");
            $table->string("image");
            $table->double('mileage', 15, 8);
            $table->string("transmission");
            $table->string("fuel");
            $table->string("color");
            $table->string("tags");
            $table->double("price")->default(0);
            $table->integer('doors');
            $table->integer('cylinders');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
