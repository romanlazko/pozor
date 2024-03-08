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
        Schema::create('real_estate_announcement_photos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('announcement_id')->nullable();
            $table->foreign('announcement_id')->references('id')->on('real_estate_announcements')->onDelete('cascade');

            $table->string('src')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_estate_announcement_photos');
    }
};
