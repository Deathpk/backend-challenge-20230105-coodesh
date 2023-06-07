<?php

use App\Enums\Product\Status;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->enum('status', Status::getAvailableStatus());
            $table->date('imported_t');
            $table->string('url');
            $table->string('creator');
            $table->timestamp('created_t');
            $table->timestamp('last_modified_t');
            $table->string('product_name');
            $table->string('quantity');
            $table->string('brands');
            $table->text('categories');
            $table->string('labels');
            $table->string('cities');
            $table->string('purchase_places');
            $table->string('stores');
            $table->text('ingredients_text');
            $table->string('traces');
            $table->string('serving_size');
            $table->float('serving_quantity')->nullable();
            $table->string('nutriscore_score')->nullable();
            $table->char('nutriscore_grade', 1);
            $table->string('main_category');
            $table->string('image_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
