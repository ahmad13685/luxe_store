<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('returns_replacements')) {
            return;
        }

        Schema::create('returns_replacements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['return', 'replace']);
            $table->text('reason');
            $table->enum('status', ['requested', 'approved', 'rejected', 'completed'])
                ->default('requested');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('returns_replacements');
    }
};
