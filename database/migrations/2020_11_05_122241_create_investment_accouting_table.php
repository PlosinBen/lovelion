<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentAccoutingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_accounting', function (Blueprint $table) {
            $table->id();
            $table->date('period');
            $table->integer('investment_user_id');
            $table->mediumInteger('deposit')->default(0)->comment('入金');
            $table->mediumInteger('withdraw')->default(0)->comment('出金');
            $table->mediumInteger('profit')->default(0)->comment('損益');
            $table->mediumInteger('transfer')->default(0)->comment('出金轉存');
            $table->mediumInteger('expense')->default(0)->comment('結餘');
            $table->mediumInteger('commitment')->default(0);
            $table->timestamps();

            $table->unique(['period', 'investment_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investment_accounting');
    }
}
