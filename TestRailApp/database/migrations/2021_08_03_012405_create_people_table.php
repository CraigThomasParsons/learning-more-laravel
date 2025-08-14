<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('fullName');
            $table->unsignedBigInteger('user_id')->unique();
            $table->unsignedInteger('role_id');
            $table->boolean('active');
            $table->string('role');
            $table->timestamps();

            $table->index('active');
            $table->index('fullName');
            $table->index('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
