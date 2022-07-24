<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageablesTable extends Migration
{
    public function up()
    {
        Schema::create('imageables', function (Blueprint $table) {
            $table->unsignedInteger('photo_id');
            $table->foreign('photo_id')->references('id')->on('photos');
            $table->unsignedInteger('imageable_id');
            $table->string('imageable_type');



            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('imageables');
    }
}
