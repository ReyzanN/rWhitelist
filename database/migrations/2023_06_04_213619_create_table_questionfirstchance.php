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
        Schema::create('question_first_chance', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->longText('answer');
            $table->boolean('active');
            $table->unsignedBigInteger('idTypeQuestion');
            $table->foreign('idTypeQuestion')->on('qcmquestiontype')->references('id')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_questionfirstchance');
    }
};
