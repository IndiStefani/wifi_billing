<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cust_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('pack_id')->constrained('internet_packet')->cascadeOnDelete();
            $table->foreignId('router_id')->constrained('routers')->cascadeOnDelete();
            $table->string('usn'); // username PPPoE
            $table->string('pass'); // password PPPoE
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            $table->date('act_date')->nullable();
            $table->date('exp_date')->nullable();
            $table->string('status')->default('active'); // active, isolir, nonaktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers_services');
    }
};
