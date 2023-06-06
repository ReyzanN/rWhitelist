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
        Schema::create('qcmCandidateAnswer',function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('idQCMCandidate');
            $table->unsignedBigInteger('idQuestion');
            $table->text('answer');
            $table->boolean('status');
            $table->timestamps();
            $table->foreign('idQCMCandidate')->on('qcmcandidate')->references('id');
            $table->foreign('idQuestion')->on('question_first_chance')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qcmCandidateAnswer');
    }
};
