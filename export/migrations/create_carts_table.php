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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('session')->nullable();
            $table->string('namespace')->nullable();
            $table->string('payable_type');
            $table->unsignedInteger('payable_id');
            $table->integer('quantity')->default(0);
            $table->timestamps();

            $table->index(['session', 'namespace', 'payable_type', 'payable_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
