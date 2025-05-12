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
         Schema::create('loans', function (Blueprint $table) {
             $table->id();
             $table->foreignId('user_id')->constrained()->onDelete('cascade');
             $table->foreignId('book_id')->constrained()->onDelete('cascade');
             $table->unsignedInteger('quantity')->default(1);
             $table->date('loan_date');
             $table->date('due_date');
             $table->date('return_date')->nullable();
             $table->enum('status', ['borrowed', 'returned', 'overdue'])->default('borrowed');
             $table->text('notes')->nullable();
             $table->timestamps();
            
             // Optional: Indexes for faster queries
             $table->index('user_id');
             $table->index('book_id');
             $table->index('status');
         });
     }

     /**
      * Reverse the migrations.
      */
     public function down(): void
     {
         Schema::dropIfExists('loans');
     }
};
