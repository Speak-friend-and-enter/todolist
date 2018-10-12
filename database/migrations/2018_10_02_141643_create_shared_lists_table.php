<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharedListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_lists', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('task_list_id');
            $table->foreign('task_list_id')->references('id')
                ->on('task_lists')->onDelete('cascade');

            $table->unsignedInteger('user_from_id');
            $table->unsignedInteger('user_to_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shared_lists');
    }
}
