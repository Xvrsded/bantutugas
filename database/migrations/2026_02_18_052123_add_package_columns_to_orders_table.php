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
            $table->foreignId('package_id')->nullable()->after('service_id')->constrained()->onDelete('set null');
            $table->integer('unit_quantity')->nullable()->after('quantity'); // Jumlah halaman/soal
            $table->decimal('package_price', 12, 2)->nullable()->after('budget'); // Harga package
            $table->decimal('addons_total', 12, 2)->default(0)->after('package_price'); // Total harga add-ons
            $table->decimal('subtotal', 12, 2)->nullable()->after('addons_total'); // package_price + addons
            $table->decimal('admin_adjusted_price', 12, 2)->nullable()->after('final_price'); // Harga setelah admin adjust
            $table->text('price_adjustment_notes')->nullable()->after('price_adjustment_reason'); // Catatan adjustment
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropColumn([
                'package_id',
                'unit_quantity',
                'package_price',
                'addons_total',
                'subtotal',
                'admin_adjusted_price',
                'price_adjustment_notes'
            ]);
        });
    }
};
