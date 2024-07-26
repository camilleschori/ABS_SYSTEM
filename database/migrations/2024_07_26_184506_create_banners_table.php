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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->enum('location', ['home_bottom', 'home_middle', 'home_top']);
            $table->enum('target_type', ['brand', 'category', 'product', 'general']);
            $table->unsignedBigInteger('target_id')->nullable();
            $table->dateTime('expiry_at');
            $table->integer('sequence');
            $table->timestamps();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
