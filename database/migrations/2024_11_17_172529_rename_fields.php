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
            $table->dropColumn('name_ru');
            $table->dropColumn('description_ru');
            $table->dropColumn('name_de');
            $table->dropColumn('description_de');
        });

        Schema::table('video_contents', function (Blueprint $table) {
            $table->renameColumn('name', 'name_ru');
            $table->renameColumn('description', 'description_ru');
        });

        Schema::table('video_contents', function (Blueprint $table) {
            $table->text('name')->after('vkId');
            $table->text('name_de')->after('name_ru');
            $table->text('description')->after('name_de');
            $table->text('description_de')->after('description_ru');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('name_ru');
            $table->dropColumn('description_ru');
            $table->dropColumn('name_de');
            $table->dropColumn('description_de');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->renameColumn('name', 'name_ru');
            $table->renameColumn('description', 'description_ru');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->text('name')->after('updated_at');
            $table->text('name_de')->after('name_ru');
            $table->text('description')->after('name_de');
            $table->text('description_de')->after('description_ru');
        });
    }
};
