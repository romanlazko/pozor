<?php

use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\AttributeSection;
use App\Models\Category;
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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('label')->nullable();
            $table->json('alterlabels')->nullable();
            $table->string('create_type')->nullable();
            $table->string('search_type')->nullable();
            $table->foreignIdFor(AttributeSection::class)->nullable();
            $table->string('column_span')->nullable();
            $table->string('column_start')->nullable();
            $table->integer('order_number')->nullable();
            $table->json('visible')->nullable();
            $table->foreignIdFor(AttributeOption::class)->nullable();
            $table->boolean('translatable')->default(false);
            $table->boolean('is_feature')->default(false);
            $table->boolean('required')->default(false);
            $table->boolean('searchable')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('attribute_category', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Attribute::class)
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
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('attribute_category');
    }
};
