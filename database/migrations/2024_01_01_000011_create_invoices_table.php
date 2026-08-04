<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('inv_number')->unique();
            $table->foreignId('cust_serv_id')->constrained('customers_services')->cascadeOnDelete();
            $table->string('periode'); // contoh: "2026-07"
            $table->decimal('nominal', 12, 2)->default(0);
            $table->decimal('diskon', 12, 2)->default(0);
            $table->decimal('adm_fee', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->date('due_date')->nullable();
            $table->string('status')->default('unpaid'); // unpaid, paid, overdue
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
