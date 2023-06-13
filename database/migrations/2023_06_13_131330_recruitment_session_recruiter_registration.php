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
        Schema::create('recruitment_session_recruiter_registration', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('idSession');
            $table->unsignedBigInteger('idUser');
            $table->foreign('idSession')->on('recruitment_sessions')->references('id');
            $table->foreign('idUser')->on('users')->references('id');
            $table->timestamps();
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
