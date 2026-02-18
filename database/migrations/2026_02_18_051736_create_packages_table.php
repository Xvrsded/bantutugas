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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Hemat, Standar, Premium
            $table->string('slug'); // hemat, standar, premium
            $table->decimal('price_per_unit', 12, 2); // Harga per halaman/soal/project
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // List fitur sebagai JSON
            $table->integer('min_quantity')->default(1); // Minimum order
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['service_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
