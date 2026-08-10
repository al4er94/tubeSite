<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('image_similar', function (Blueprint $table) {
            $table->foreignId('image_id')->constrained('images')->cascadeOnDelete();
            $table->foreignId('similar_image_id')->constrained('images')->cascadeOnDelete();
            $table->primary(['image_id', 'similar_image_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('image_similar');
    }
};
