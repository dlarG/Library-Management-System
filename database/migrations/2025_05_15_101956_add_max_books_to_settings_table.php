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
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('max_books_per_user')->default(3)->after('loan_period');
            $table->integer('grace_period')->default(3)->after('max_books_per_user');
            $table->integer('renewal_limit')->default(2)->after('grace_period');
            $table->integer('reminder_days_before_due')->default(2)->after('renewal_limit');
            $table->boolean('enable_email_notifications')->default(true)->after('reminder_days_before_due');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
