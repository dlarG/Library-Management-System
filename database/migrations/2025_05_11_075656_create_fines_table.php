<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('fines', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('loan_id')->constrained()->onDelete('cascade');
    //         $table->foreignId('user_id')->constrained()->onDelete('cascade');
    //         $table->decimal('amount', 8, 2);
    //         $table->integer('days_overdue');
    //         $table->decimal('daily_rate', 8, 2);
    //         $table->enum('status', ['pending', 'paid'])->default('pending');
    //         $table->timestamp('paid_at')->nullable();
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::dropIfExists('fines');
    // }
};
