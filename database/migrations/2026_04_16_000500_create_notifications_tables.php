<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('user_email')->nullable();
            $table->text('message');
            $table->string('status')->default('unread');
            $table->timestamps();
        });

        Schema::create('donor_notifications', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('donor_id')->constrained('donors')->cascadeOnDelete();
            $table->string('donor_email')->nullable();
            $table->text('message');
            $table->string('status')->default('unread');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donor_notifications');
        Schema::dropIfExists('notifications');
    }
};
