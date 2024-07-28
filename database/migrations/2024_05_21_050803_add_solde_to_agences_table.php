<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoldeToAgencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agences', function (Blueprint $table) {
            $table->decimal('solde', 15, 2)->default(0)->after('nom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agences', function (Blueprint $table) {
            $table->dropColumn('solde');
        });
    }
}
