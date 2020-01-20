<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->uuid('uuid')->unique();
            $table->boolean('approved')->default(false);
            $table->boolean('rejected')->default(false);
            $table->text('rejected_reason')->nullable();
            $table->integer('merchant_id')->unsigned()->index();
            $table->foreign('merchant_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('program_category_id')->nullable()->unsigned()->index();
            $table->foreign('program_category_id')->references('id')->on('program_categories')->onDelete('set null');
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
        Schema::dropIfExists('programs');
    }
}
