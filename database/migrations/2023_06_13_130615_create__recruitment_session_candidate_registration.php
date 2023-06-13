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
        Schema::create('recruitment_session_candidate_registration', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idSession');
            $table->unsignedBigInteger('validatedBy');
            $table->text('backgroundURL');
            $table->boolean('present')->nullable(true)->default(null);
            $table->boolean('result')->nullable(true)->default(null);
            $table->timestamps();
            $table->foreign('idSession')->on('recruitment_sessions')->references('id');
            $table->foreign('validatedBy')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_session_candidate_registration');
    }
};
