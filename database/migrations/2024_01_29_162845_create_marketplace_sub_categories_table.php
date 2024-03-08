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
        Schema::create('marketplace_subcategories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('marketplace_category_id')->nullable();
            $table->foreign('marketplace_category_id')->references('id')->on('marketplace_categories')->onDelete('cascade');
            
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
        Schema::dropIfExists('marketplace_sub_categories');
    }
};
