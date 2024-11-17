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
        Schema::table('video_contents', function (Blueprint $table) {
            $table->text('name_ru');
            $table->text('description_ru');

            $table->text('name_de');
            $table->text('description_de');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('name_ru');
            $table->text('description_ru');

            $table->string('name_de');
            $table->text('description_de');
        });
    }

};
