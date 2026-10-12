<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * `products.category` (a plain string) already exists and the storefront
     * likely reads/filters on it — we leave it alone. `category_id` is added
     * ALONGSIDE it as the new, structured way for Admin to manage categories.
     * The Product model keeps both in sync automatically (see kit notes),
     * so the teammate's existing storefront code needs zero changes.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'category_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('category_id')
                    ->nullable()
                    ->after('category')
                    ->constrained()
                    ->nullOnDelete();
            });
        }

        if (!Schema::hasColumn('products', 'product_code')) {
            Schema::table('products', function (Blueprint $table) {
                // 7-digit business ID: 2-digit category code + 5-digit sequence.
                // Nullable at first so existing rows don't break; back-fill via
                // a quick tinker loop or by re-saving each product in Filament.
                $table->char('product_code', 7)->nullable()->unique()->after('id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category_id')) {
                $table->dropConstrainedForeignId('category_id');
            }

            if (Schema::hasColumn('products', 'product_code')) {
                $table->dropColumn('product_code');
            }
        });
    }
};
