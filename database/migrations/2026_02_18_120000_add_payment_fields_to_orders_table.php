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
            $table->string('payment_choice')->nullable()->after('payment_method'); // dp or full
            $table->integer('dp_percentage')->nullable()->after('payment_choice');
            $table->decimal('dp_amount', 12, 2)->nullable()->after('dp_percentage');
            $table->decimal('remaining_amount', 12, 2)->nullable()->after('dp_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_choice',
                'dp_percentage',
                'dp_amount',
                'remaining_amount'
            ]);
        });
    }
};
