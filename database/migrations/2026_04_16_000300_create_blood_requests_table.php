<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_requests', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 20);
            $table->string('blood_group', 5);
            $table->string('province');
            $table->string('district');
            $table->text('note')->nullable();
            $table->string('requisition_file')->nullable();
            $table->string('status')->default('pending');

            // Legacy compatibility fields from older blood request workflow.
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('contact', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('blood_type', 5)->nullable();
            $table->unsignedSmallInteger('units_needed')->nullable();
            $table->string('emergency_level')->nullable();
            $table->string('id_card_path')->nullable();
            $table->string('prescription_path')->nullable();
            $table->timestamp('requested_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};
