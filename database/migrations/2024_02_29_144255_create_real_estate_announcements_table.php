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
        Schema::create('real_estate_announcements', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->nullable();
            $table->string('slug')->nullable();

            $table->text('description')->nullable();
            
            $table->integer('type')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('configuration_id')->nullable();

            $table->integer('condition')->nullable();

            $table->float('price')->nullable();
            $table->string('price_currency')->nullable();
            $table->float('deposit')->nullable();
            $table->string('deposit_currency')->nullable();
            $table->float('utilities')->nullable();
            $table->string('utilities_currency')->nullable();

            $table->float('square_meters')->nullable();

            $table->date('check_in_date')->nullable();

            $table->json('additional_spaces')->nullable();

            $table->integer('equipment')->nullable();

            $table->integer('floor')->nullable();

            $table->json('location')->nullable();
            $table->string('address')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();

            $table->boolean('should_be_published_in_telegram')->default(true);

            $table->unsignedBigInteger('views')->default('0');

            $table->json('status_info')->nullable();
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
        Schema::dropIfExists('real_estate_announcements');
    }
};
