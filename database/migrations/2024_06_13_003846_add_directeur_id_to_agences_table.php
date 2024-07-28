<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDirecteurIdToAgencesTable extends Migration
{
    public function up()
    {
        Schema::table('agences', function (Blueprint $table) {
            $table->unsignedBigInteger('directeur_id')->nullable();

            $table->foreign('directeur_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('agences', function (Blueprint $table) {
            $table->dropForeign(['directeur_id']);
            $table->dropColumn('directeur_id');
        });
    }
}
