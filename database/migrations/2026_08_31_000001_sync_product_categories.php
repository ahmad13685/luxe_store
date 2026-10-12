<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('categories') || !Schema::hasTable('products')) {
            return;
        }

        DB::transaction(function (): void {
            $names = DB::table('products')
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->distinct()
                ->pluck('category')
                ->filter()
                ->values();

            foreach ($names as $name) {
                if (DB::table('categories')->where('name', $name)->exists()) {
                    continue;
                }

                $used = DB::table('categories')->pluck('code')->map(fn ($code) => (int) $code)->all();
                $next = 1;
                while (in_array($next, $used, true) && $next <= 99) {
                    $next++;
                }

                if ($next > 99) {
                    throw new RuntimeException('Unable to create category: the 99 category code limit has been reached.');
                }

                DB::table('categories')->insert([
                    'code' => str_pad((string) $next, 2, '0', STR_PAD_LEFT),
                    'name' => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $categories = DB::table('categories')->pluck('id', 'name');

            foreach ($categories as $name => $id) {
                DB::table('products')
                    ->where('category', $name)
                    ->whereNull('category_id')
                    ->update(['category_id' => $id]);
            }

            // Back-fill missing product IDs without changing any existing IDs.
            foreach (DB::table('products')->whereNull('product_code')->orderBy('id')->get() as $product) {
                if (!$product->category_id) {
                    continue;
                }

                $category = DB::table('categories')->find($product->category_id);
                if (!$category) {
                    continue;
                }

                $last = DB::table('products')
                    ->where('category_id', $product->category_id)
                    ->whereNotNull('product_code')
                    ->where('product_code', 'like', $category->code . '%')
                    ->orderByDesc('product_code')
                    ->value('product_code');

                $next = $last ? ((int) substr($last, 2)) + 1 : 1;
                $code = $category->code . str_pad((string) $next, 5, '0', STR_PAD_LEFT);

                DB::table('products')->where('id', $product->id)->update(['product_code' => $code]);
            }
        });
    }

    public function down(): void
    {
        // Deliberately leave the repaired data intact on rollback.
    }
};
