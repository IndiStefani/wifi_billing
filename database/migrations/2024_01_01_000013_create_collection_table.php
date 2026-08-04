<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inv_id')->constrained('invoices')->cascadeOnDelete();
            $table->foreignId('coll_id')->constrained('collectors')->cascadeOnDelete();
            $table->date('visit_date');
            $table->enum('status', ['SUCCESS', 'NOT_HOME', 'PROMISE_TO_PAY', 'REJECTED'])
                ->default('NOT_HOME');
            $table->text('note')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('foto')->nullable(); // path/nama file foto bukti kunjungan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection');
    }
};
