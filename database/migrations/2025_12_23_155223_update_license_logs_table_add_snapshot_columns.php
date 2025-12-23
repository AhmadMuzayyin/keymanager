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
        Schema::table('license_logs', function (Blueprint $table) {
            // Drop foreign key dan license_id jika ada
            if (Schema::hasColumn('license_logs', 'license_id')) {
                // Try to drop foreign key if exists
                try {
                    $table->dropForeign(['license_id']);
                } catch (\Exception $e) {
                    // Foreign key doesn't exist, continue
                }
                $table->dropColumn('license_id');
            }
            
            // Rename kolom domain menjadi request_domain jika ada
            if (Schema::hasColumn('license_logs', 'domain') && !Schema::hasColumn('license_logs', 'request_domain')) {
                $table->renameColumn('domain', 'request_domain');
            }
            
            // Tambah kolom snapshot lisensi jika belum ada
            if (!Schema::hasColumn('license_logs', 'license_product_name')) {
                $table->string('license_product_name')->nullable()->after('license_key');
            }
            if (!Schema::hasColumn('license_logs', 'license_status')) {
                $table->enum('license_status', ['active', 'suspended', 'revoked'])->nullable()->after('license_product_name');
            }
            if (!Schema::hasColumn('license_logs', 'license_domain')) {
                $table->string('license_domain')->nullable()->after('license_status');
            }
            if (!Schema::hasColumn('license_logs', 'license_expires_at')) {
                $table->timestamp('license_expires_at')->nullable()->after('license_domain');
            }
            
            // Tambah kolom invalid_reason jika belum ada
            if (!Schema::hasColumn('license_logs', 'invalid_reason')) {
                $table->string('invalid_reason')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('license_logs', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan
            if (Schema::hasColumn('license_logs', 'license_product_name')) {
                $table->dropColumn('license_product_name');
            }
            if (Schema::hasColumn('license_logs', 'license_status')) {
                $table->dropColumn('license_status');
            }
            if (Schema::hasColumn('license_logs', 'license_domain')) {
                $table->dropColumn('license_domain');
            }
            if (Schema::hasColumn('license_logs', 'license_expires_at')) {
                $table->dropColumn('license_expires_at');
            }
            if (Schema::hasColumn('license_logs', 'invalid_reason')) {
                $table->dropColumn('invalid_reason');
            }
            
            // Rename kembali kolom jika ada
            if (Schema::hasColumn('license_logs', 'request_domain')) {
                $table->renameColumn('request_domain', 'domain');
            }
            
            // Tambah kembali license_id jika tidak ada
            if (!Schema::hasColumn('license_logs', 'license_id')) {
                $table->unsignedBigInteger('license_id')->nullable()->after('id');
            }
        });
    }
};
