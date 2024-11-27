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
            $table->enum('status', ['UNDER_REVIEW', 'WAITING_PAYMENT', 'IN_PROGRESS', 'FINISHED'])->default('UNDER_REVIEW');
            $table->foreignId('user_id')->nullable()->constrained('users')
                ->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('lawyer_id')->nullable()->constrained('users')
                ->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')
                ->cascadeOnUpdate()->nullOnDelete();
            $table->enum('data_type', ['MY', 'CLIENT'])->default('MY');
            $table->string('name')->nullable();
            $table->string('client_relationship')->nullable();
            $table->string('national_id')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('case_title')->nullable();
            $table->longText('case_description')->nullable();
            $table->longText('case_conclusion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
