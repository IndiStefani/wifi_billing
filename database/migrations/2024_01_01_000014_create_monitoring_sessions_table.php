<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitoring_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cust_serv_id')->constrained('customers_services')->cascadeOnDelete();
            $table->foreignId('router_id')->constrained('routers')->cascadeOnDelete();
            $table->timestamp('login_time')->nullable();
            $table->timestamp('logout_time')->nullable();
            $table->unsignedBigInteger('uptime')->nullable(); // dalam detik
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            $table->unsignedBigInteger('download')->default(0); // bytes
            $table->unsignedBigInteger('upload')->default(0); // bytes
            $table->string('status')->default('active'); // active, ended
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_sessions');
    }
};
