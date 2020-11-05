<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_detail', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('investment_user_id');
            $table->tinyInteger('type')->comment('類型');
            $table->mediumInteger('amount')->comment('金額');
            $table->string('note')->default('')->comment('備註');
            $table->timestamps();

            $table->index(['investment_user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investment_detail');
    }
}
