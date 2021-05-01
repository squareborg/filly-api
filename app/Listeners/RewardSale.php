<?php

namespace App\Listeners;

use App\Events\ProgramSale;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\NewSubscriptionSale;
use App\Notifications\NewProgramSale;

class RewardSale
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProgramSale  $event
     * @return void
     */
    public function handle(ProgramSale $event)
    {
        $sale = $event->sale;
        $subscription = $sale->subscription;
        $program = $subscription->program;
        if (!$program->programReward || $program->programReward->percentage === null){
            $reward_amount = ($sale->order_total / 100) * $program->merchant->merchantReward->percentage;
        } else {
            $reward_amount = ($sale->order_total / 100) * $program->programReward->percentage;
        }

        $reward = $event->sale->subscription->rewards()->create(
            [
                'sale_id' => $event->sale->id,
                'amount_gbp' => $reward_amount
            ]
        );

        $event->sale->subscription->user->notify(new NewSubscriptionSale($sale->subscription, $reward));
        $event->sale->subscription->program->merchant->user->notify(new NewProgramSale($sale->subscription, $reward));
    }
}
