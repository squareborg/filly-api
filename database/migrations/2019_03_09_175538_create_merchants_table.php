<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('user_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->text('logo')->nullable();
            $table->boolean('auto_approve_affiliates')->default(false);
            $table->float('merchant_reward')->default(10.0);
            $table->timestamps();
            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('program_categories')->onDelete('set null');
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchants');
    }
}
