<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuturesStatementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('futures_statement', function (Blueprint $table) {
            $table->id();
            $table->date('period');
            $table->mediumInteger('commitment')->default(0)->comment('期末權益');
            $table->mediumInteger('open_interest')->default(0)->comment('未平倉損益');
            $table->mediumInteger('profit')->default(0)->comment('沖銷損益');
            $table->mediumInteger('real_commitment')->default(0)->comment('權益淨值');
            $table->mediumInteger('net_commitment')->default(0)->comment('權益變動');
            $table->mediumInteger('distribution')->default(0)->comment('可分配總額');
            $table->string('note')->default('')->comment('備註');
            $table->timestamps();

            $table->index('period');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('futures_statement');
    }
}
