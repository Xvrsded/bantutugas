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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', [
                'academic-sma',
                'academic-kuliah',
                'academic-makalah',
                'academic-skripsi',
                'academic-tesis',
                'academic-revisi',
                'academic-olahdata',
                'tech-pcb',
                'tech-iot',
                'tech-webmonitoring',
                'tech-programming'
            ]);
            $table->text('description');
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price_start', 10, 2)->default(0);
            $table->decimal('price_end', 10, 2)->nullable();
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
