<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->string('nama_router');
            $table->string('ip_address');
            $table->unsignedInteger('api_port')->default(8728); // default port API Mikrotik
            $table->string('username');
            $table->string('password'); // sebaiknya dienkripsi via cast di model
            $table->string('lokasi')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routers');
    }
};
