<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('studentnum');
            $table->unsignedBigInteger('thematic_id');
            $table->string('subthematic_id');
            $table->string('generalobject');
            $table->string('modality');
            $table->string('requirements');
            $table->string('keywords');
            $table->integer('students')->nullable();
            $table->unsignedBigInteger('institution_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('thematic_id')->references('id')->on('thematics');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('institution_id')->references('id')->on('institutions');
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
        Schema::dropIfExists('proyectos');
    }
};
