<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 30)->unique();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20)->nullable();
            $table->enum('project_type', ['android', 'desktop', 'web', 'other']);
            $table->string('title');
            $table->longText('description');
            $table->string('budget_range', 100)->nullable();
            $table->date('deadline')->nullable();
            $table->json('attachments')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'quoted', 'accepted', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->decimal('quoted_price', 12, 2)->nullable();
            $table->timestamp('quoted_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_orders');
    }
};
