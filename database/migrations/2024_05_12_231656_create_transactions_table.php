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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant');
            $table->string('type');
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('agence_id');
            $table->unsignedBigInteger('compte_id');
            $table->timestamps();




            $table->foreign('agent_id')->references('id')->on('agents');
            $table->foreign('agence_id')->references('id')->on('agences');
            $table->foreign('compte_id')->references('id')->on('comptes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
