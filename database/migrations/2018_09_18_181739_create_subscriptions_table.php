<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->uuid('program_uuid');
            $table->foreign('program_uuid')
                ->references('uuid')
                ->on('programs')
                ->onDelete('cascade');
            $table->uuid('uuid')->unique();
            $table->integer('clicks')->unsigned()->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('subscriptions');
    }
}
