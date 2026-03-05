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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignId('writed_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reply_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('message');
            $table->text('response')->nullable();
            $table->timestamp('writed_at')->nullable();
            $table->timestamp('responsed_at')->nullable();
            $table->string('status')->default('kutilmoqda');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
