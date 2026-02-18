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
        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Express, Turnitin, English, etc
            $table->string('slug'); // express, turnitin, english
            $table->string('type'); // percentage, fixed, per_unit
            $table->decimal('price', 12, 2); // Harga atau persentase
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Bootstrap icon class
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addons');
    }
};
