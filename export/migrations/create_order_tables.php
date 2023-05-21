<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('session')->nullable();
            $table->string('namespace')->nullable();
            $table->string('code')->nullable();
            $table->enum('status', ["pending", "processing", "delivering", "completed", "cancelled"])
                ->default('pending');
            $table->timestamps();

            $table->index(['session', 'namespace', 'code', 'status']);
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('orderable_type');
            $table->unsignedInteger('orderable_id');
            $table->integer('quantity')->default(1);
            $table->float('amount')->default(0.0);
            $table->tinyInteger('discount')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
    }
};
