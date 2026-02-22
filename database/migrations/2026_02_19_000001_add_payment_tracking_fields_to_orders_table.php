<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_status')->default('waiting')->after('payment_choice');
            $table->decimal('payment_admin_fee', 12, 2)->default(0)->after('remaining_amount');
            $table->decimal('payment_total_due', 12, 2)->nullable()->after('payment_admin_fee');
            $table->timestamp('paid_at')->nullable()->after('payment_total_due');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'payment_admin_fee',
                'payment_total_due',
                'paid_at',
            ]);
        });
    }
};
