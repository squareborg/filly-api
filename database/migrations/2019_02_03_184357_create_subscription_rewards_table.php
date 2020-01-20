<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id');
            $table->integer('subscription_id');
            $table->decimal('amount_gbp',8,2);
            $table->boolean('rewarded')->default(false);
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
        Schema::dropIfExists('subscrption_rewards');
    }
}
