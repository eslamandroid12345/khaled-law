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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transactionable_id')->nullable();
            $table->string('transactionable_type')->nullable();
            $table->enum('type', ['BANK', 'ELECTRONIC'])->nullable();
            $table->string('image')->nullable();
            $table->double('price')->nullable();
            $table->integer('counter')->nullable();
            $table->boolean('status')->default(false);
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
