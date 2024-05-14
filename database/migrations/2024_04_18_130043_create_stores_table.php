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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->unique();
            $table->string('name_ar')->unique();
            $table->text('description_en');
            $table->text('description_ar');
            $table->text('link_en')->unique();
            $table->text('link_ar')->unique();
            $table->string('image');
            $table->enum('status',["active", "in-active"]);
            $table->enum('featured',["featured", "not-featured"]);
            $table->string('meta_title_en')->unique();
            $table->string('meta_title_ar')->unique();
            $table->text('meta_description_en');
            $table->text('meta_description_ar');
            $table->string('meta_keyword_en');
            $table->string('meta_keyword_ar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
