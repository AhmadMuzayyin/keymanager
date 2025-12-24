<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['product_price_id']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->change();
            $table->unsignedBigInteger('product_price_id')->nullable()->change();
            $table->string('price_name', 100)->after('product_name');
            $table->decimal('subtotal', 12, 2)->after('quantity');

            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
            $table->foreign('product_price_id')->references('id')->on('product_prices')->nullOnDelete();
        });

        if (Schema::hasColumn('order_items', 'package_name')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropColumn('package_name');
            });
        }
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['product_price_id']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable(false)->change();
            $table->unsignedBigInteger('product_price_id')->nullable(false)->change();
            $table->string('package_name', 100)->after('product_name');
            $table->dropColumn(['price_name', 'subtotal']);

            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('product_price_id')->references('id')->on('product_prices')->cascadeOnDelete();
        });
    }
};
