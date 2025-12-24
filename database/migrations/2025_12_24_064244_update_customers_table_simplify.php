<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop unique index pada phone jika ada
        try {
            DB::statement('ALTER TABLE customers DROP INDEX customers_phone_unique');
        } catch (\Exception $e) {
            // Index tidak ada, lanjut
        }

        Schema::table('customers', function (Blueprint $table) {
            if (! Schema::hasColumn('customers', 'email')) {
                $table->string('email')->after('name');
            }
        });

        // Hapus kolom satu per satu dalam Schema terpisah
        $columnsToDrop = ['referral_code', 'total_referrals', 'total_commission', 'commission_rate', 'status'];
        foreach ($columnsToDrop as $column) {
            if (Schema::hasColumn('customers', $column)) {
                Schema::table('customers', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }

        Schema::table('customers', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (! Schema::hasColumn('customers', 'referral_code')) {
                $table->string('referral_code')->unique()->after('phone');
            }
            if (! Schema::hasColumn('customers', 'total_referrals')) {
                $table->integer('total_referrals')->default(0);
            }
            if (! Schema::hasColumn('customers', 'total_commission')) {
                $table->decimal('total_commission', 12, 2)->default(0);
            }
            if (! Schema::hasColumn('customers', 'commission_rate')) {
                $table->decimal('commission_rate', 5, 2)->default(10.00);
            }
            if (! Schema::hasColumn('customers', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active');
            }
            if (Schema::hasColumn('customers', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};
