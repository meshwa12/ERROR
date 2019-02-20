<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Project extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Project', function (Blueprint $table) {
            $table->increments('Proj_id');
            $table->integer('id')->unsigned()->index('project_id_foreign');
            $table->integer('tech_id')->unsigned()->index('project_tech_id_foreign');
            $table->string('project_name', 250);
            $table->text('project_details', 250);
            $table->string('file', 65535);
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
        Schema::drop('project');
    }
}
