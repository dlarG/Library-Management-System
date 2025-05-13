<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up()
    // {
    //     Schema::create('settings', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name')->unique();  // Changed from 'key'
    //         $table->string('group')->index();  // Added group column
    //         $table->json('payload');           // Changed from 'value'
    //         $table->timestamps();
    //     });
    // }

    // public function down()
    // {
    //     Schema::dropIfExists('settings');
    // }
};
