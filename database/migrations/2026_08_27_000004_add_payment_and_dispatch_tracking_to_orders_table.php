<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * `orders.payment_method` and `orders.status` already exist — untouched.
     * This adds what's missing for the Admin/Employee side: whether payment
     * has actually cleared (needed before dispatching credit_card/cheque
     * orders), and who dispatched the order + when.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_status', ['pending', 'cleared', 'failed'])
                ->default('pending')
                ->after('payment_method');

            $table->foreignId('dispatched_by')
                ->nullable()
                ->after('billing_address_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('dispatched_at')->nullable()->after('dispatched_by');
            $table->timestamp('delivered_at')->nullable()->after('dispatched_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('dispatched_by');
            $table->dropColumn(['payment_status', 'dispatched_at', 'delivered_at']);
        });
    }
};
