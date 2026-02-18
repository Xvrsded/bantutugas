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
        Schema::table('orders', function (Blueprint $table) {
            // Parameter Kalkulasi
            $table->string('question_type')->nullable()->after('quantity'); // pilgan, esai, hitungan, project, coding
            $table->string('subject')->nullable(); // Mata pelajaran
            $table->integer('question_count')->nullable(); // Jumlah soal/halaman
            $table->boolean('needs_explanation')->default(false); // Butuh penjelasan
            $table->integer('deadline_hours')->nullable(); // Deadline dalam jam
            
            // Hasil Kalkulasi
            $table->integer('difficulty_score')->nullable(); // Total skor
            $table->string('difficulty_level')->nullable(); // easy, medium, hard
            $table->decimal('base_price', 12, 2)->nullable(); // Harga dasar
            $table->decimal('multiplier', 4, 2)->default(1.0); // Pengali kesulitan
            $table->decimal('calculated_price', 12, 2)->nullable(); // Harga hasil kalkulasi
            $table->decimal('final_price', 12, 2)->nullable(); // Harga final (bisa di-override admin)
            $table->boolean('price_overridden')->default(false); // Apakah harga di-override
            $table->text('price_adjustment_reason')->nullable(); // Alasan adjustment
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'question_type',
                'subject',
                'question_count',
                'needs_explanation',
                'deadline_hours',
                'difficulty_score',
                'difficulty_level',
                'base_price',
                'multiplier',
                'calculated_price',
                'final_price',
                'price_overridden',
                'price_adjustment_reason'
            ]);
        });
    }
};
