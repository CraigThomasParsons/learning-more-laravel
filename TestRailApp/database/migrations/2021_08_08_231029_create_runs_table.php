<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('runs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name');
            $table->string('description');

            // Foreign keys
            $table->unsignedBigInteger('plan_id')->unique();
            $table->unsignedBigInteger('project_id')->unique();
            $table->unsignedBigInteger('assignedto_id')->unique();
            $table->unsignedBigInteger('suite_id')->unique();
            $table->unsignedBigInteger('milestone_id')->unique();

            $table->boolean('is_completed');
            $table->unsignedBigInteger('completed_on');

            $table->integer('passed_count');
            $table->integer('blocked_count');
            $table->integer('untested_count');
            $table->integer('retest_count');
            $table->integer('failed_count');
            $table->integer('custom_status1_count');
            $table->integer('custom_status2_count');
            $table->integer('custom_status3_count');
            $table->integer('custom_status4_count');
            $table->integer('custom_status5_count');
            $table->integer('custom_status6_count');
            $table->integer('custom_status7_count');

            $table->timestamps();

            // Version of when it was created based on api data.
            $table->integer('created_on');
            $table->integer('created_by');

            $table->index('is_completed');
            $table->index('assignedto_id');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('runs');
    }
}
