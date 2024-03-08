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
        Schema::create('marketplace_announcements', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('telegram_chat_id')->nullable();
            $table->string('slug')->nullable();

            $table->string('title')->nullable();
            $table->text('caption')->nullable();
            $table->string('city')->nullable();
            $table->integer('type')->nullable();
            $table->float('price')->nullable();
            $table->string('currency')->nullable();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            
            $table->integer('condition')->nullable();

            $table->json('location')->nullable();
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
        Schema::dropIfExists('marketplace_announcements');
    }
};
