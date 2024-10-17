<?php

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Sorting;
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
        Schema::create('sortings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->json('alternames')->nullable();
            $table->integer('order_number')->nullable();
            $table->string('direction')->nullable();
            $table->boolean('is_default')->default(false);
            $table->foreignIdFor(Attribute::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('category_sorting', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Sorting::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignIdFor(Category::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sortings');
    }
};
