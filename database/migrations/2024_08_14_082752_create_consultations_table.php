<?php

use App\Http\Enums\ConsultationStatusEnum;
use App\Http\Enums\ConsultationTypeEnum;
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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ConsultationTypeEnum::values());
            $table->enum('status', ConsultationStatusEnum::values());
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('lawyer_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
//            $table->timestamp('at')->nullable();
            $table->string('name')->nullable();
            $table->string('id_number')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->string('legal_question')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
