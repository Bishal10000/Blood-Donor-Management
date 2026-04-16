<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_availabilities', function (Blueprint $table): void {
            $table->id();
            $table->string('health_post')->nullable();
            $table->string('province')->nullable();
            $table->string('district');
            $table->string('municipality')->nullable();
            $table->string('address');
            $table->string('blood_group', 5);
            $table->unsignedInteger('available_units')->default(0);
            $table->string('contact', 20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_availabilities');
    }
};
