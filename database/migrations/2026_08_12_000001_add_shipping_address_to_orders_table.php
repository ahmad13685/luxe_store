<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The checkout form collects a free-text shipping address, and
 * Order::$fillable already listed "shipping_address" - but the
 * original orders table only ever had shipping_address_id (a FK
 * to a saved Address). This adds the missing text column so
 * OrderController::placeOrder() can actually save it without a
 * "SQLSTATE[42S22]: Unknown column" error.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'shipping_address')) {
                $table->text('shipping_address')
                    ->nullable()
                    ->after('total_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'shipping_address')) {
                $table->dropColumn('shipping_address');
            }
        });
    }
};
