<?php

use Igaster\LaravelCities\Geo;
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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->nullable();
            
            $table->string('title')->nullable();
            $table->json('translated_title')->nullable();
            
            $table->string('slug')->nullable();

            $table->text('description')->nullable();
            $table->json('translated_description')->nullable();

            $table->integer('current_price')->nullable();
            $table->integer('old_price')->nullable();
            $table->string('currency_id')->nullable();

            $table->unsignedBigInteger('category_id')->nullable();

            $table->foreignIdFor(Geo::class)->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            
            $table->boolean('should_be_published_in_telegram')->default(true);

            $table->unsignedBigInteger('views')->default('0');

            $table->integer('status')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
