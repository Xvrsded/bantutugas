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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('project_title');
            $table->longText('description');
            $table->dateTime('deadline')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->integer('quantity')->default(1);
            $table->string('payment_method')->nullable();
            $table->string('attachment')->nullable();
            $table->enum('status', ['pending', 'accepted', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->longText('notes')->nullable();
            $table->boolean('is_notified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
