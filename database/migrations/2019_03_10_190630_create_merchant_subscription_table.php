<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('affiliate_id');
            $table->unsignedInteger('merchant_id');
            $table->boolean('approved')->default(false);
            $table->boolean('rejected')->default(false);
            $table->string('rejected_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('affiliate_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_subscriptions');
    }
}
