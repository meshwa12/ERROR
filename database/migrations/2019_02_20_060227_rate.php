<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('Rate', function (Blueprint $table) {
            $table->integer('id')->unsigned()->index('rate_id_foreign');
            $table->integer('Proj_id')->unsigned()->index('rate_Proj_id_foreign');
            $table->float('Rate', 5)->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::drop('Rate');
    }
}
