<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('address')->nullable()->after('name');
            $table->string('phone', 20)->nullable()->after('address');
            $table->string('blood_type', 5)->nullable()->after('phone');
            $table->unsignedTinyInteger('age')->nullable()->after('blood_type');
            $table->string('user_type')->default('donor')->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn(['address', 'phone', 'blood_type', 'age', 'user_type']);
        });
    }
};
