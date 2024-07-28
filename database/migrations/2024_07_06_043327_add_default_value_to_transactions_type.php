<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_default_value_to_transactions_type.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToTransactionsType extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('type')->default('versement')->change();
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('type')->default(null)->change();
        });
    }
}
