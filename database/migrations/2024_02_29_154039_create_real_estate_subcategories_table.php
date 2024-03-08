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
        Schema::create('real_estate_subcategories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('real_estate_category_id')->nullable();
            $table->foreign('real_estate_category_id')->references('id')->on('real_estate_categories')->onDelete('cascade');
            
            $table->string('name')->nullable();
            $table->json('alternames')->nullable();
            $table->string('slug')->nullable();
            $table->string('icon_name')->nullable();
            $table->boolean('is_active')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_estate_subcategories');
    }
};
