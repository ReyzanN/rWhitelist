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
        Schema::table('recruitment_sessions', function(Blueprint $table){
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('closed_by')->nullable(true)->default(null);
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('closed_by')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
