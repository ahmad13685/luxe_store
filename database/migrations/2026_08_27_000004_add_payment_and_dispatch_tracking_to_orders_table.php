<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * `orders.payment_method` and `orders.status` already exist — untouched.
     * This adds what's missing for the Admin/Employee side: whether payment
     * has actually cleared (needed before dispatching credit_card/cheque
     * orders), and who dispatched the order + when.
     *
     * NOTE: on some environments an earlier (now-untracked) migration
     * already added `payment_status` to this table with capitalised values
     * such as "Pending". Every step below is guarded with hasColumn() so
     * this migration is safe to run whether or not that happened, and it
     * never drops or recreates the table. Existing values are normalised
     * (not deleted) so they match what the admin panel expects.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('orders', 'payment_status')) {
            Schema::table('orders', function (Blueprint $table) {
                // Plain string (not enum) so it can't fail if legacy data
                // contains a value outside the current option list.
                $table->string('payment_status', 30)
                    ->default('pending')
                    ->after('payment_method');
            });
        }

        // Normalise any existing values (e.g. legacy "Pending") to the
        // lowercase values the model/admin panel compare against, without
        // touching any other order data.
        DB::table('orders')
            ->whereNotNull('payment_status')
            ->select('id', 'payment_status')
            ->orderBy('id')
            ->each(function ($order): void {
                $normalized = strtolower(trim((string) $order->payment_status));

                if (!in_array($normalized, ['pending', 'cleared', 'failed'], true)) {
                    $normalized = 'pending';
                }

                if ($normalized !== $order->payment_status) {
                    DB::table('orders')->where('id', $order->id)->update([
                        'payment_status' => $normalized,
                    ]);
                }
            });

        if (!Schema::hasColumn('orders', 'dispatched_by')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('dispatched_by')
                    ->nullable()
                    ->after('billing_address_id')
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }

        if (!Schema::hasColumn('orders', 'dispatched_at')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->timestamp('dispatched_at')->nullable()->after('dispatched_by');
            });
        }

        if (!Schema::hasColumn('orders', 'delivered_at')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->timestamp('delivered_at')->nullable()->after('dispatched_at');
            });
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'dispatched_by')) {
                $table->dropConstrainedForeignId('dispatched_by');
            }

            $drop = array_values(array_filter(
                ['payment_status', 'dispatched_at', 'delivered_at'],
                fn (string $column) => Schema::hasColumn('orders', $column)
            ));

            if ($drop !== []) {
                $table->dropColumn($drop);
            }
        });
    }
};
